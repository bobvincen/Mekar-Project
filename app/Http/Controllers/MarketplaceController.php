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
            $search = strtolower(trim($request->input('search')));
            $searchTokens = array_filter(explode(' ', $search));
            $noSpaceSearch = str_replace(' ', '', $search);

            // 1. Kamus Bahasa Sehari-hari (Thesaurus Gejala & Typo Obat untuk toleransi orang tua)
            $synonyms = [
                // Gejala / Penyakit Umum
                'pusing' => ['sakit kepala', 'pusing', 'migrain', 'vertigo', 'paracetamol', 'panadol', 'bodrex', 'paramex', 'oskadon', 'neuralgin'],
                'demam' => ['panas', 'demam', 'paracetamol', 'sanmol', 'ibuprofen', 'proris', 'tempra'],
                'batuk' => ['batuk', 'berdahak', 'kering', 'komik', 'obh', 'siladex', 'woods', 'bisolvon', 'laserin', 'actifed'],
                'pilek' => ['flu', 'pilek', 'hidung tersumbat', 'meler', 'rhinos', 'mixagrip', 'procold', 'demacolin', 'decolgen', 'tremenza'],
                'mencret' => ['diare', 'mencret', 'mules', 'diapet', 'lodia', 'imodium', 'entrostop', 'tay pin san', 'oralit'],
                'lambung' => ['maag', 'asam lambung', 'gerd', 'perih', 'mual', 'promag', 'mylanta', 'polysilane', 'antasida', 'omeprazole', 'lansoprazole'],
                'maag' => ['maag', 'asam lambung', 'gerd', 'perih', 'mual', 'promag', 'mylanta', 'polysilane', 'antasida'],
                'muntah' => ['mual', 'muntah', 'antimo', 'ondansetron', 'domperidone', 'vometa'],
                'pegal' => ['pegal', 'linu', 'nyeri otot', 'keseleo', 'koyok', 'salonpas', 'hotin', 'voltaren', 'counterpain', 'neo rheumacyl'],
                'luka' => ['luka', 'berdarah', 'betadine', 'rivanol', 'hansaplast', 'plester', 'bioplacenton'],
                'gatal' => ['gatal', 'alergi', 'biduran', 'kaligata', 'ctm', 'incidal', 'cetirizine', 'caladine', 'salep', 'daktarin', 'loratadine'],
                'vitamin' => ['vitamin', 'suplemen', 'daya tahan', 'imun', 'enervon', 'imboost', 'fatigon', 'stimuno', 'blackmores', 'c'],
                'darah tinggi' => ['hipertensi', 'darah tinggi', 'amlodipine', 'captopril', 'tensivask', 'candesartan'],
                'kencing manis' => ['diabetes', 'kencing manis', 'gula darah', 'metformin', 'glimepiride', 'insulin'],
                'capek' => ['letih', 'lesu', 'capek', 'lelah', 'vitamin', 'suplemen', 'fatigon', 'sangobion', 'hemabion'],
                'kurang darah' => ['anemia', 'kurang darah', 'sangobion', 'zat besi'],
                'sariawan' => ['sariawan', 'panas dalam', 'albotyl', 'kenalog', 'larutan', 'adem sari'],
                'asam urat' => ['asam urat', 'nyeri sendi', 'allopurinol', 'piroxicam', 'meloxicam'],
                'kolesterol' => ['kolesterol', 'simvastatin', 'atorvastatin'],
                'gigi' => ['sakit gigi', 'nyeri', 'ponstan', 'mefenamat', 'katarak', 'cataflam'],
                'mata' => ['sakit mata', 'merah', 'insto', 'rohto', 'cendocitrol'],

                // Typo Toleransi Ekstra Obat Populer
                'paramek' => ['paramex'],
                'bodrek' => ['bodrex'],
                'sanmol' => ['sanmol', 'paracetamol'],
                'amoxilin' => ['amoxicillin', 'amoksisilin'],
                'amosilin' => ['amoxicillin', 'amoksisilin'],
                'ibupropen' => ['ibuprofen'],
                'antasid' => ['antasida'],
                'proma' => ['promag'],
                'koyo' => ['koyok', 'salonpas'],
            ];

            // 2. Expand search terms based on synonyms and typo tolerance
            $expandedSearchTerms = [$search];
            foreach ($synonyms as $key => $relatedTerms) {
                // If user typed string contains a synonym key (e.g. "obat pusing")
                if (str_contains($search, $key)) {
                    $expandedSearchTerms = array_merge($expandedSearchTerms, $relatedTerms);
                }
            }

            // 3. Typo handling using similar_text on synonym keys (Toleransi Typo)
            foreach ($searchTokens as $token) {
                if (strlen($token) >= 4) { // Ignore short words like 'di', 'ke', 'ini'
                    foreach ($synonyms as $key => $relatedTerms) {
                        similar_text($key, $token, $percent);
                        if ($percent >= 70) { // 70% similarity to tolerate 'pusng', 'demamm', 'muntahhh'
                            $expandedSearchTerms = array_merge($expandedSearchTerms, $relatedTerms);
                        }
                    }
                }
            }

            $expandedSearchTerms = array_unique($expandedSearchTerms);

            $query->where(function($q) use ($search, $searchTokens, $noSpaceSearch, $expandedSearchTerms) {
                // Pengecekan pada semua term yang diperluas
                foreach ($expandedSearchTerms as $term) {
                    $q->orWhere('nama_obat', 'like', '%' . $term . '%')
                      ->orWhere('deskripsi', 'like', '%' . $term . '%');
                }
                
                // Pencarian berdasarkan kategori
                foreach ($expandedSearchTerms as $term) {
                    $q->orWhereHas('kategori', function($kq) use ($term) {
                        $kq->where('nama_kategori', 'like', '%' . $term . '%');
                    });
                }
                
                $q->orWhere('kode_obat', 'like', '%' . $search . '%');

                // Phonetic match (Membantu mencocokkan kemiripan bunyi seperti 'paramek' dengan 'paramex' di database)
                $q->orWhereRaw("SOUNDEX(nama_obat) = SOUNDEX(?)", [$search]);

                // Space insensitive match (handles "para setamol" vs "paracetamol")
                $q->orWhereRaw("REPLACE(nama_obat, ' ', '') LIKE ?", ['%' . $noSpaceSearch . '%']);

                // Tokenized match (handles order swapping, e.g., "sirup batuk" vs "batuk sirup")
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
