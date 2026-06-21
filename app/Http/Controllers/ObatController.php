<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Exports\ObatTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::with(['kategori', 'supplier'])
            ->latest()
            ->get();

        return view('obat.index', compact('obats'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $suppliers = Supplier::all();

        return view('obat.create', compact(
            'kategoris',
            'suppliers'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_obat' => 'required',
            'nama_obat' => 'required',
            'kategori_id' => 'required',
            'supplier_id' => 'required',
            'stok' => 'required|integer|min:1',
            'harga_jual' => 'required|numeric|min:1',
            'tanggal_kadaluarsa' => 'required|date',
            'deskripsi' => 'nullable'
        ], [
            'kode_obat.required' => 'Kode obat wajib diisi.',
            'nama_obat.required' => 'Nama obat wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'supplier_id.required' => 'Supplier wajib dipilih.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok minimal 1.',
            'harga_jual.required' => 'Harga jual wajib diisi.',
            'harga_jual.numeric' => 'Harga jual harus berupa angka.',
            'harga_jual.min' => 'Harga jual minimal 1.',
            'tanggal_kadaluarsa.required' => 'Tanggal kadaluarsa wajib diisi.',
            'tanggal_kadaluarsa.date' => 'Format tanggal kadaluarsa tidak valid.'
        ]);

        Obat::create([
            'kode_obat' => $request->kode_obat,
            'nama_obat' => $request->nama_obat,
            'kategori_id' => $request->kategori_id,
            'supplier_id' => $request->supplier_id,
            'stok' => $request->stok,
            'harga_jual' => $request->harga_jual,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('obat.index')
            ->with('success', 'Obat berhasil ditambahkan');
    }

    public function edit(Obat $obat)
    {
        $kategoris = Kategori::all();
        $suppliers = Supplier::all();

        return view('obat.edit', compact(
            'obat',
            'kategoris',
            'suppliers'
        ));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'kode_obat' => 'required',
            'nama_obat' => 'required',
            'kategori_id' => 'required',
            'supplier_id' => 'required',
            'stok' => 'required|integer|min:1',
            'harga_jual' => 'required|numeric|min:1',
            'tanggal_kadaluarsa' => 'required|date',
            'deskripsi' => 'nullable'
        ], [
            'kode_obat.required' => 'Kode obat wajib diisi.',
            'nama_obat.required' => 'Nama obat wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'supplier_id.required' => 'Supplier wajib dipilih.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok minimal 1.',
            'harga_jual.required' => 'Harga jual wajib diisi.',
            'harga_jual.numeric' => 'Harga jual harus berupa angka.',
            'harga_jual.min' => 'Harga jual minimal 1.',
            'tanggal_kadaluarsa.required' => 'Tanggal kadaluarsa wajib diisi.',
            'tanggal_kadaluarsa.date' => 'Format tanggal kadaluarsa tidak valid.'
        ]);

        $obat->update([
            'kode_obat' => $request->kode_obat,
            'nama_obat' => $request->nama_obat,
            'kategori_id' => $request->kategori_id,
            'supplier_id' => $request->supplier_id,
            'stok' => $request->stok,
            'harga_jual' => $request->harga_jual,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('obat.index')
            ->with('success', 'Obat berhasil diubah');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();

        return redirect()
            ->route('obat.index')
            ->with('success', 'Obat berhasil dihapus');
    }

    public function downloadTemplate()
    {
        return Excel::download(new ObatTemplateExport, 'template_obat.xlsx');
    }

    public function previewImport(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls'
        ], [
            'file_excel.required' => 'File Excel wajib diunggah.',
            'file_excel.file' => 'Input harus berupa file.',
            'file_excel.mimes' => 'Format file harus berupa .xlsx atau .xls.'
        ]);

        try {
            $file = $request->file('file_excel');
            $data = Excel::toArray(new \stdClass(), $file);
            $rows = $data[0] ?? [];

            if (count($rows) <= 1) {
                return back()->with('error', 'File Excel kosong atau hanya berisi heading.');
            }

            $headings = $rows[0] ?? [];
            $headings = array_map(function($h) {
                return trim(strtolower($h));
            }, $headings);

            $expected = ['nama_obat', 'kategori', 'supplier', 'stok', 'harga_jual', 'tanggal_kadaluarsa'];

            // Validate headings
            $diff = array_diff($expected, $headings);
            if (count($diff) > 0) {
                return back()->with('error', 'Format heading file Excel tidak sesuai. Harap gunakan template yang diunduh.');
            }

            $map = [];
            foreach ($expected as $col) {
                $map[$col] = array_search($col, $headings);
            }

            $validRows = [];
            $errors = [];
            $newCategories = [];
            $newSuppliers = [];

            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];

                if (empty(array_filter($row))) {
                    continue;
                }

                $rawDate = $row[$map['tanggal_kadaluarsa']] ?? null;
                $parsedDate = $rawDate;
                if (is_numeric($rawDate)) {
                    try {
                        $parsedDate = ExcelDate::excelToDateTimeObject($rawDate)->format('Y-m-d');
                    } catch (\Exception $e) {
                        $parsedDate = $rawDate;
                    }
                }

                $rowData = [
                    'nama_obat' => $row[$map['nama_obat']] ?? null,
                    'kategori' => $row[$map['kategori']] ?? null,
                    'supplier' => $row[$map['supplier']] ?? null,
                    'stok' => $row[$map['stok']] ?? null,
                    'harga_jual' => $row[$map['harga_jual']] ?? null,
                    'tanggal_kadaluarsa' => $parsedDate,
                ];

                $validator = Validator::make($rowData, [
                    'nama_obat' => 'required|string|max:255',
                    'kategori' => 'required|string|max:255',
                    'supplier' => 'required|string|max:255',
                    'stok' => 'required|integer|min:0',
                    'harga_jual' => 'required|numeric|min:0',
                    'tanggal_kadaluarsa' => 'required|date_format:Y-m-d'
                ], [
                    'nama_obat.required' => 'Nama obat wajib diisi.',
                    'kategori.required' => 'Kategori wajib diisi.',
                    'supplier.required' => 'Supplier wajib diisi.',
                    'stok.required' => 'Stok wajib diisi.',
                    'stok.integer' => 'Stok harus berupa angka.',
                    'stok.min' => 'Stok minimal 0.',
                    'harga_jual.required' => 'Harga jual wajib diisi.',
                    'harga_jual.numeric' => 'Harga jual harus berupa angka.',
                    'harga_jual.min' => 'Harga jual minimal 0.',
                    'tanggal_kadaluarsa.required' => 'Tanggal kadaluarsa wajib diisi.',
                    'tanggal_kadaluarsa.date_format' => 'Format tanggal kadaluarsa harus YYYY-MM-DD.'
                ]);

                if ($validator->fails()) {
                    $errors[$i + 1] = $validator->errors()->all();
                } else {
                    $validRows[] = $rowData;

                    $catName = trim($rowData['kategori']);
                    if (!Kategori::where('nama_kategori', $catName)->exists() && !in_array($catName, $newCategories)) {
                        $newCategories[] = $catName;
                    }

                    $supName = trim($rowData['supplier']);
                    if (!Supplier::where('nama_supplier', $supName)->exists() && !in_array($supName, $newSuppliers)) {
                        $newSuppliers[] = $supName;
                    }
                }
            }

            session(['temp_import_data' => $validRows]);

            $validCount = count($validRows);
            $errorCount = count($errors);
            $totalRows = $validCount + $errorCount;

            return view('obat.preview', compact(
                'validRows',
                'errors',
                'newCategories',
                'newSuppliers',
                'totalRows',
                'validCount',
                'errorCount'
            ));

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses file Excel: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $data = session('temp_import_data');

        if (empty($data)) {
            return redirect()->route('obat.index')->with('error', 'Tidak ada data valid yang siap diimport.');
        }

        DB::beginTransaction();
        try {
            $maxId = Obat::max('id') ?? 0;
            foreach ($data as $index => $row) {
                $kategori = Kategori::firstOrCreate([
                    'nama_kategori' => trim($row['kategori'])
                ]);

                $supplier = Supplier::firstOrCreate(
                    ['nama_supplier' => trim($row['supplier'])],
                    [
                        'alamat' => 'Alamat ' . trim($row['supplier']),
                        'telepon' => '081234567890',
                        'email' => strtolower(str_replace([' ', '.', ','], '', trim($row['supplier']))) . '@supplier.com'
                    ]
                );

                $kode = 'OBT-' . str_pad($maxId + 1 + $index, 4, '0', STR_PAD_LEFT);

                Obat::create([
                    'kode_obat' => $kode,
                    'nama_obat' => trim($row['nama_obat']),
                    'kategori_id' => $kategori->id,
                    'supplier_id' => $supplier->id,
                    'stok' => intval($row['stok']),
                    'harga_jual' => floatval($row['harga_jual']),
                    'tanggal_kadaluarsa' => $row['tanggal_kadaluarsa'],
                    'deskripsi' => trim($row['nama_obat']) . ' diimport massal.'
                ]);
            }

            DB::commit();
            session()->forget('temp_import_data');
            return redirect()->route('obat.index')->with('success', count($data) . ' data obat berhasil diimport.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('obat.index')->with('error', 'Terjadi kesalahan saat import data: ' . $e->getMessage());
        }
    }
}