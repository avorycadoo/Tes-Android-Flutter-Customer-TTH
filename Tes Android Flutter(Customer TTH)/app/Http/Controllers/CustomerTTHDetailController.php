<?php

namespace App\Http\Controllers;

use App\Models\CustomerTTHDetail;
use App\Models\CustomerTTH;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerTTHDetailController extends Controller
{
    /**
     * Store a newly created TTH detail (AJAX)
     * Untuk menambah hadiah baru ke TTH yang sudah ada
     */
    public function store(Request $request)
    {
        $request->validate([
            'TTHNo' => 'required|exists:customertth,TTHNo',
            'TTOTTPNo' => 'required|max:50',
            'Jenis' => 'required|max:100',
            'Qty' => 'required|integer|min:1'
        ]);

        try {
            // Determine unit based on Jenis
            $unit = $this->determineUnit($request->Jenis);

            // Create new detail
            $detail = CustomerTTHDetail::create([
                'TTHNo' => $request->TTHNo,
                'TTOTTPNo' => $request->TTOTTPNo,
                'Jenis' => $request->Jenis,
                'Qty' => $request->Qty,
                'Unit' => $unit
            ]);

            // Log activity
            Log::info('TTH Detail Created', [
                'detail_id' => $detail->ID,
                'tth_no' => $detail->TTHNo,
                'jenis' => $detail->Jenis,
                'qty' => $detail->Qty,
                'unit' => $detail->Unit
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Hadiah berhasil ditambahkan!',
                'data' => [
                    'id' => $detail->ID,
                    'jenis' => $detail->Jenis,
                    'qty' => $detail->Qty,
                    'unit' => $detail->Unit
                ]
            ], 201);

        } catch (\Exception $e) {
            Log::error('Failed to create TTH detail', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan hadiah: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified TTH detail (AJAX)
     * Untuk edit jenis hadiah dan jumlah
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Jenis' => 'required|max:100',
            'Qty' => 'required|integer|min:1'
        ]);

        try {
            $detail = CustomerTTHDetail::findOrFail($id);
            
            // Store old values for logging
            $oldJenis = $detail->Jenis;
            $oldQty = $detail->Qty;
            $oldUnit = $detail->Unit;
            
            // Update values
            $detail->Jenis = $request->Jenis;
            $detail->Qty = $request->Qty;
            
            // Auto-set unit based on new Jenis
            $detail->Unit = $this->determineUnit($request->Jenis);
            
            $detail->save();

            // Log activity
            Log::info('TTH Detail Updated', [
                'detail_id' => $detail->ID,
                'tth_no' => $detail->TTHNo,
                'old' => [
                    'jenis' => $oldJenis,
                    'qty' => $oldQty,
                    'unit' => $oldUnit
                ],
                'new' => [
                    'jenis' => $detail->Jenis,
                    'qty' => $detail->Qty,
                    'unit' => $detail->Unit
                ]
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Hadiah berhasil diupdate!',
                'data' => [
                    'id' => $detail->ID,
                    'jenis' => $detail->Jenis,
                    'qty' => $detail->Qty,
                    'unit' => $detail->Unit
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Detail hadiah tidak ditemukan!'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Failed to update TTH detail', [
                'detail_id' => $id,
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate hadiah: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified TTH detail (AJAX)
     * Untuk hapus hadiah dari TTH
     */
    public function destroy($id)
    {
        try {
            $detail = CustomerTTHDetail::findOrFail($id);
            $tthNo = $detail->TTHNo;
            
            // Check if this is the last detail
            $detailCount = CustomerTTHDetail::where('TTHNo', $tthNo)->count();
            
            if ($detailCount <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus hadiah terakhir! TTH harus memiliki minimal 1 hadiah.'
                ], 400);
            }
            
            // Store for logging before delete
            $deletedData = [
                'id' => $detail->ID,
                'tth_no' => $detail->TTHNo,
                'jenis' => $detail->Jenis,
                'qty' => $detail->Qty,
                'unit' => $detail->Unit
            ];
            
            $detail->delete();

            // Log activity
            Log::info('TTH Detail Deleted', $deletedData);

            return response()->json([
                'success' => true,
                'message' => 'Hadiah berhasil dihapus!'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Detail hadiah tidak ditemukan!'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Failed to delete TTH detail', [
                'detail_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus hadiah: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all details for a specific TTH (AJAX)
     * Untuk load detail via AJAX jika diperlukan
     */
    public function getDetailsByTTH($tthNo)
    {
        try {
            // Check if TTH exists
            $tth = CustomerTTH::where('TTHNo', $tthNo)->firstOrFail();
            
            // Get all details
            $details = CustomerTTHDetail::where('TTHNo', $tthNo)
                ->orderBy('ID')
                ->get()
                ->map(function($detail) {
                    return [
                        'id' => $detail->ID,
                        'jenis' => $detail->Jenis,
                        'qty' => $detail->Qty,
                        'unit' => $detail->Unit,
                        'display' => $detail->display,
                        'badge' => $detail->jenis_badge
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $details,
                'total' => $details->count()
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'TTH tidak ditemukan!'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Failed to get TTH details', [
                'tth_no' => $tthNo,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data detail: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Determine unit based on Jenis hadiah
     * 
     * @param string $jenis
     * @return string
     */
    private function determineUnit($jenis)
    {
        // Check if it's Emas (gold)
        if (stripos($jenis, 'emas') !== false || stripos($jenis, 'Gr') !== false) {
            return 'Buah';
        }
        
        // Check if it's Voucher
        if (stripos($jenis, 'voucher') !== false || stripos($jenis, 'rb') !== false) {
            return 'Lembar';
        }
        
        // Default to Buah
        return 'Buah';
    }

    /**
     * Bulk update details for a TTH (Optional - untuk fitur advanced)
     */
    public function bulkUpdate(Request $request, $tthNo)
    {
        $request->validate([
            'details' => 'required|array|min:1',
            'details.*.id' => 'required|exists:customertthdetail,ID',
            'details.*.Jenis' => 'required|max:100',
            'details.*.Qty' => 'required|integer|min:1'
        ]);

        try {
            $updated = [];
            
            foreach ($request->details as $detailData) {
                $detail = CustomerTTHDetail::findOrFail($detailData['id']);
                
                // Ensure detail belongs to the specified TTH
                if ($detail->TTHNo !== $tthNo) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Detail tidak sesuai dengan TTH yang dipilih!'
                    ], 400);
                }
                
                $detail->Jenis = $detailData['Jenis'];
                $detail->Qty = $detailData['Qty'];
                $detail->Unit = $this->determineUnit($detailData['Jenis']);
                $detail->save();
                
                $updated[] = $detail->ID;
            }

            Log::info('TTH Details Bulk Updated', [
                'tth_no' => $tthNo,
                'updated_ids' => $updated,
                'count' => count($updated)
            ]);

            return response()->json([
                'success' => true,
                'message' => count($updated) . ' hadiah berhasil diupdate!',
                'updated_count' => count($updated)
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to bulk update TTH details', [
                'tth_no' => $tthNo,
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate hadiah: ' . $e->getMessage()
            ], 500);
        }
    }
}