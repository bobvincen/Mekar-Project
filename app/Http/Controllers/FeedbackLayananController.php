<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedbackLayanan;

class FeedbackLayananController extends Controller
{
    public function index()
    {
        $feedbacks = FeedbackLayanan::latest()->get();
        
        $totalPenilaian = $feedbacks->count();
        $rataRata = $totalPenilaian > 0 ? $feedbacks->avg('rating') : 0;
        
        $bintang5 = $feedbacks->where('rating', 5)->count();
        $bintang4 = $feedbacks->where('rating', 4)->count();
        $bintang3 = $feedbacks->where('rating', 3)->count();
        $bintang2 = $feedbacks->where('rating', 2)->count();
        $bintang1 = $feedbacks->where('rating', 1)->count();
        
        return view('admin.feedback-layanan.index', compact(
            'feedbacks', 'totalPenilaian', 'rataRata',
            'bintang5', 'bintang4', 'bintang3', 'bintang2', 'bintang1'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:5',
            'nama_pelanggan' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'transaksi_id' => 'nullable|exists:transaksis,id',
        ]);

        if (!empty($validated['transaksi_id'])) {
            $transaksi = \App\Models\Transaksi::find($validated['transaksi_id']);
            
            // Check ownership if user is logged in
            if (auth()->check() && $transaksi->user_id && $transaksi->user_id !== auth()->id()) {
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses ke transaksi ini.'], 403);
                }
                return back()->with('error', 'Anda tidak memiliki akses ke transaksi ini.');
            }

            // Check if status is completed (Selesai)
            if ($transaksi->status !== 'Selesai') {
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Anda hanya dapat memberikan feedback untuk transaksi yang sudah selesai.'], 400);
                }
                return back()->with('error', 'Anda hanya dapat memberikan feedback untuk transaksi yang sudah selesai.');
            }

            // Check for duplicate feedback
            $existing = FeedbackLayanan::where('transaksi_id', $validated['transaksi_id'])->first();
            if ($existing) {
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Anda sudah memberikan feedback untuk transaksi ini.'], 422);
                }
                return back()->with('error', 'Anda sudah memberikan feedback untuk transaksi ini.');
            }
        }

        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }

        FeedbackLayanan::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Terima kasih atas penilaian Anda.']);
        }
        
        return back()->with('success', 'Terima kasih atas penilaian Anda.');
    }

    public function destroy($id)
    {
        $feedback = FeedbackLayanan::findOrFail($id);
        $feedback->delete();

        return redirect()->route('admin.feedback-layanan.index')->with('success', 'Penilaian layanan berhasil dihapus.');
    }
}
