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

        return view('marketplace.home', compact('kategoris', 'latestProducts', 'bestSellerProducts'));
    }

    public function products(Request $request)
    {
        $kategoris = Kategori::withCount('obats')->get();
        
        $query = Obat::with('kategori');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nama_obat', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhere('kode_obat', 'like', '%' . $search . '%');
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
}
