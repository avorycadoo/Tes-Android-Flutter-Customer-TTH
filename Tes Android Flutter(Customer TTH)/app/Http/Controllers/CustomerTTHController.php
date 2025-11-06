<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerTTH;
use App\Models\CustomerTTHDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerTTHController extends Controller
{
    /**
     * Display a listing of TTH
     */
    public function index(Request $request)
    {
        $query = CustomerTTH::with(['customer', 'details']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('TTHNo', 'like', "%{$search}%")
                  ->orWhere('CustID', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q2) use ($search) {
                      $q2->where('Name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('Received', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('DocDate', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('DocDate', '<=', $request->date_to);
        }

        $tths = $query->orderBy('DocDate', 'desc')->paginate(15);

        return view('tth.index', compact('tths'));
    }

    /**
     * Show the form for creating a new TTH
     */
    public function create()
    {
        $customers = Customer::orderBy('Name')->get();
        return view('tth.create', compact('customers'));
    }

    /**
     * Store a newly created TTH with details
     */
    public function store(Request $request)
    {
        $request->validate([
            'TTHNo' => 'required|unique:customertth,TTHNo|max:50',
            'CustID' => 'required|exists:customer,CustID',
            'SalesID' => 'required|max:50',
            'TTOTTPNo' => 'required|max:50',
            'DocDate' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*.Jenis' => 'required|max:100',
            'details.*.Qty' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            // Create TTH
            $tth = CustomerTTH::create([
                'TTHNo' => $request->TTHNo,
                'SalesID' => $request->SalesID,
                'TTOTTPNo' => $request->TTOTTPNo,
                'CustID' => $request->CustID,
                'DocDate' => $request->DocDate,
                'Received' => 0,
                'ReceivedDate' => null,
                'FailedReason' => null
            ]);

            // Create TTH Details
            foreach ($request->details as $detail) {
                $unit = $this->determineUnit($detail['Jenis']);
                
                CustomerTTHDetail::create([
                    'TTHNo' => $tth->TTHNo,
                    'TTOTTPNo' => $request->TTOTTPNo,
                    'Jenis' => $detail['Jenis'],
                    'Qty' => $detail['Qty'],
                    'Unit' => $unit
                ]);
            }

            DB::commit();

            return redirect()->route('tth.index')
                ->with('success', 'TTH berhasil ditambahkan beserta detailnya!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan TTH: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified TTH with details
     */
    public function show($id)
    {
        $tth = CustomerTTH::with(['customer.branch', 'details'])
            ->findOrFail($id);

        return view('tth.show', compact('tth'));
    }

    /**
     * Remove the specified TTH and its details
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $tth = CustomerTTH::findOrFail($id);
            
            // Delete details first
            CustomerTTHDetail::where('TTHNo', $tth->TTHNo)->delete();
            
            // Delete TTH
            $tth->delete();

            DB::commit();

            return redirect()->route('tth.index')
                ->with('success', 'TTH dan detailnya berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal menghapus TTH: ' . $e->getMessage());
        }
    }

    /**
     * Get TTH details via AJAX
     */
    public function getDetails($tthNo)
    {
        $details = CustomerTTHDetail::where('TTHNo', $tthNo)->get();
        return response()->json($details);
    }

    /**
     * Update TTH received status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'Received' => 'required|in:0,1',
            'FailedReason' => 'nullable|string|max:500'
        ]);

        try {
            $tth = CustomerTTH::findOrFail($id);
            
            $tth->Received = $request->Received;
            
            if ($request->Received == 1) {
                $tth->ReceivedDate = now();
                $tth->FailedReason = null;
            } else {
                $tth->FailedReason = $request->FailedReason;
            }
            
            $tth->save();

            return redirect()->back()
                ->with('success', 'Status TTH berhasil diupdate!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupdate status: ' . $e->getMessage());
        }
    }

    /**
     * Determine unit based on jenis
     */
    private function determineUnit($jenis)
    {
        if (stripos($jenis, 'emas') !== false || stripos($jenis, 'Gr') !== false) {
            return 'Buah';
        } elseif (stripos($jenis, 'voucher') !== false || stripos($jenis, 'rb') !== false) {
            return 'Lembar';
        }
        return 'Buah'; // Default
    }
}