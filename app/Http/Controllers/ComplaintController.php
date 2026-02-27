<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{
    /**
     * Display list of complaints for admin
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $complaints = Complaint::when($status !== 'all', function($query) use ($status) {
            return $query->byStatus($status);
        })->latest()->paginate(10);
        
        return view('admin.complaints.index', compact('complaints', 'status'));
    }

    /**
     * Display complaint details
     */
    public function show($id)
    {
        $complaint = Complaint::findOrFail($id);
        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Store a new complaint
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orderNumber' => 'nullable|string|max:50',
            'email' => 'required|email|max:255',
            'issue' => 'required|string|min:3|max:1000',
            'evidence' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'issue.required' => 'Deskripsi kendala wajib diisi',
            'issue.min' => 'Deskripsi kendala minimal 3 karakter',
            'issue.max' => 'Deskripsi kendala maksimal 1000 karakter',
            'evidence.mimes' => 'File bukti harus berformat JPG, PNG, atau PDF',
            'evidence.max' => 'Ukuran file bukti maksimal 5MB'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', $validator->errors()->all()),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $evidencePath = null;
            if ($request->hasFile('evidence')) {
                $file = $request->file('evidence');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $evidencePath = $file->storeAs('complaints/evidence', $filename, 'public');
                
                // Log file storage for debugging
                \Log::info('File stored: ' . $evidencePath);
            }

            $complaint = Complaint::create([
                'order_number' => $request->orderNumber,
                'email' => $request->email,
                'issue_description' => $request->issue,
                'evidence_file_path' => $evidencePath,
                'status' => 'pending'
            ]);

            \Log::info('Complaint created: ' . $complaint->id);

            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil dikirim',
                'data' => $complaint
            ]);

        } catch (\Exception $e) {
            \Log::error('Complaint submission error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan laporan: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download evidence file
     */
    public function downloadEvidence($id)
    {
        $complaint = Complaint::findOrFail($id);
        
        if (!$complaint->evidence_file_path) {
            abort(404, 'File bukti tidak ditemukan');
        }

        $filePath = storage_path('app/public/' . $complaint->evidence_file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        $filename = 'bukti_' . $complaint->order_number . '_' . $complaint->id . '.' . pathinfo($filePath, PATHINFO_EXTENSION);
        
        return response()->download($filePath, $filename);
    }

    /**
     * Update complaint status
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,in_progress,resolved',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $complaint = Complaint::findOrFail($id);
            $complaint->update([
                'status' => $request->status,
                'admin_notes' => $request->admin_notes
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status laporan berhasil diperbarui',
                'data' => $complaint
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
