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
            'komentar' => 'required|string|min:10',
            'nama_pelanggan' => 'nullable|string',
            'whatsapp' => 'nullable|string',
        ]);

        FeedbackLayanan::create($validated);

        return response()->json(['success' => true, 'message' => 'Terima kasih atas penilaian Anda.']);
    }

    public function destroy($id)
    {
        $feedback = FeedbackLayanan::findOrFail($id);
        $feedback->delete();

        return redirect()->route('admin.feedback-layanan.index')->with('success', 'Penilaian layanan berhasil dihapus.');
    }
}
