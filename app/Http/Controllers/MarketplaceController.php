<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function home()
    {
        $kategoris = Kategori::withCount('obats')->get();
        
        // Latest products (produk terbaru)
        $latestProducts = Obat::with('kategori')
            ->latest()
            ->take(8)
            ->get();
            
        // Best sellers (produk terlaris - random for now as requested)
        $bestSellerProducts = Obat::with('kategori')
            ->inRandomOrder()
            ->take(8)
            ->get();

        // Penilaian Pengguna
        $ulasanTerbaru = \App\Models\FeedbackLayanan::whereIn('rating', [4, 5])
            ->latest()
            ->take(6)
            ->get();
            
        $totalPenilaian = \App\Models\FeedbackLayanan::count();
        $rataRata = $totalPenilaian > 0 ? \App\Models\FeedbackLayanan::avg('rating') : 0;

        return view('marketplace.home', compact(
            'kategoris', 'latestProducts', 'bestSellerProducts', 
            'ulasanTerbaru', 'totalPenilaian', 'rataRata'
        ));
    }

    public function products(Request $request)
    {
        $kategoris = Kategori::withCount('obats')->get();
        
        $query = Obat::with('kategori');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $searchTokens = array_filter(explode(' ', $search));
            $noSpaceSearch = str_replace(' ', '', $search);

            $query->where(function($q) use ($search, $searchTokens, $noSpaceSearch) {
                // 1. Basic LIKE (already case-insensitive in MySQL by default)
                $q->where('nama_obat', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhere('kode_obat', 'like', '%' . $search . '%');
                
                // 2. Space insensitive match (handles "para setamol" vs "paracetamol")
                $q->orWhereRaw("REPLACE(nama_obat, ' ', '') LIKE ?", ['%' . $noSpaceSearch . '%']);

                // 3. Tokenized match (handles order swapping, e.g., "sirup batuk" vs "batuk sirup")
                if (count($searchTokens) > 1) {
                    $q->orWhere(function($subQ) use ($searchTokens) {
                        foreach($searchTokens as $token) {
                            $subQ->where('nama_obat', 'like', '%' . $token . '%');
                        }
                    });
                }
            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('kategori_id', $request->input('category_id'));
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('marketplace.products', compact('products', 'kategoris'));
    }

    public function showProduct($id)
    {
        $product = Obat::with(['kategori', 'supplier'])->findOrFail($id);
        
        // Recommended/related products (same category)
        $relatedProducts = Obat::with('kategori')
            ->where('kategori_id', $product->kategori_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('marketplace.show', compact('product', 'relatedProducts'));
    }

    public function category($id)
    {
        $category = Kategori::findOrFail($id);
        $kategoris = Kategori::withCount('obats')->get();
        
        $products = Obat::with('kategori')
            ->where('kategori_id', $id)
            ->latest()
            ->paginate(12);

        return view('marketplace.products', [
            'products' => $products,
            'kategoris' => $kategoris,
            'selectedCategory' => $category
        ]);
    }
    public function logKonsultasi(Request $request)
    {
        \App\Models\KonsultasiLog::create([
            'waktu' => now(),
            'sumber' => $request->input('sumber', 'unknown'),
            'ip_pengunjung' => $request->ip()
        ]);
        return response()->json(['success' => true]);
    }
}
