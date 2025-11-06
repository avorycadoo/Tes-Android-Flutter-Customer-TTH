<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerTTH;
use App\Models\CustomerTTHDetail;
use App\Models\MobileConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers
     */
    public function index(Request $request)
    {
        $query = Customer::with(['branch', 'tths']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Name', 'like', "%{$search}%")
                  ->orWhere('CustID', 'like', "%{$search}%")
                  ->orWhere('Address', 'like', "%{$search}%")
                  ->orWhere('PhoneNo', 'like', "%{$search}%");
            });
        }

        // Filter by branch
        if ($request->has('branch') && $request->branch != '') {
            $query->where('BranchCode', $request->branch);
        }

        $customers = $query->orderBy('Name')->paginate(15);
        $branches = MobileConfig::select('BranchCode', 'Name')
            ->distinct()
            ->orderBy('BranchCode')
            ->get();

        return view('customers.index', compact('customers', 'branches'));
    }

    /**
     * Show the form for creating a new customer
     */
    public function create()
    {
        $branches = MobileConfig::select('BranchCode', 'Name')
            ->distinct()
            ->orderBy('BranchCode')
            ->get();

        return view('customers.create', compact('branches'));
    }

    private function determineUnit($jenis)
    {
        if (stripos($jenis, 'emas') !== false || stripos($jenis, 'gr') !== false) {
            return 'Buah';
        }

        if (stripos($jenis, 'voucher') !== false || stripos($jenis, 'rb') !== false) {
            return 'Lembar';
        }

        return 'Buah'; // Default
    }

    /**
     * Store a newly created customer
     */
    public function store(Request $request)
    {
        $request->validate([
            // CUSTOMER
            'CustID' => 'required|unique:customer,CustID|max:50',
            'Name' => 'required|max:255',
            'Address' => 'required|max:500',
            'BranchCode' => 'required|max:10',
            'PhoneNo' => 'required|max:20',

            // TTH
            'TTHNo' => 'required|unique:customertth,TTHNo|max:50',
            'TTOTTPNo' => 'required|max:50',
            'SalesID' => 'required|max:50',
            'DocDate' => 'required|date',

            // TTH DETAILS
            'details' => 'required|array|min:1',
            'details.*.Jenis' => 'required|max:100',
            'details.*.Qty'   => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {

            // ✅ 1. SIMPAN CUSTOMER
            Customer::create([
                'CustID'     => $request->CustID,
                'Name'       => $request->Name,
                'Address'    => $request->Address,
                'BranchCode' => $request->BranchCode,
                'PhoneNo'    => $request->PhoneNo,
            ]);

            // ✅ 2. SIMPAN TTH
            $tth = CustomerTTH::create([
                'TTHNo'        => $request->TTHNo,
                'SalesID'      => $request->SalesID,
                'TTOTTPNo'     => $request->TTOTTPNo,
                'CustID'       => $request->CustID,
                'DocDate'      => $request->DocDate,
                'Received'     => 0,
                'ReceivedDate' => null,
                'FailedReason' => null
            ]);

            // ✅ 3. SIMPAN TTH DETAIL (BANYAK)
            foreach ($request->details as $detail) {

                // Tentukan unit
                $unit = $this->determineUnit($detail['Jenis']);

                CustomerTTHDetail::create([
                    'TTHNo'     => $tth->TTHNo,
                    'TTOTTPNo'  => $request->TTOTTPNo,
                    'Jenis'     => $detail['Jenis'],
                    'Qty'       => $detail['Qty'],
                    'Unit'      => $unit
                ]);
            }

            DB::commit();

            return redirect()->route('customers.index')
                ->with('success', 'Customer, TTH, dan detail berhasil ditambahkan!');

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified customer
     */
    public function show($id)
    {
        $customer = Customer::with(['tths.details', 'branch'])
            ->findOrFail($id);

        return view('customers.show', compact('customer'));
    }

    /**
     * Remove the specified customer
     */
    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            
            // Check if customer has TTH records
            if ($customer->tths()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Tidak dapat menghapus customer yang memiliki data TTH!');
            }

            $customer->delete();

            return redirect()->route('customers.index')
                ->with('success', 'Customer berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus customer: ' . $e->getMessage());
        }
    }
}