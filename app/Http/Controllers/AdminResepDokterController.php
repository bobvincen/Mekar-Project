<?php

namespace App\Http\Controllers;

use App\Models\ResepDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminResepDokterController extends Controller
{
    public function index()
    {
        $reseps = ResepDokter::latest()->get();
        return view('admin.resep-dokter.index', compact('reseps'));
    }

    public function destroy($id)
    {
        $resep = ResepDokter::findOrFail($id);
        
        if ($resep->foto_resep) {
            if (Str::startsWith($resep->foto_resep, 'private/')) {
                $localPath = Str::after($resep->foto_resep, 'private/');
                if (Storage::disk('local')->exists($localPath)) {
                    Storage::disk('local')->delete($localPath);
                }
            } else {
                if (Storage::disk('public')->exists($resep->foto_resep)) {
                    Storage::disk('public')->delete($resep->foto_resep);
                }
            }
        }
        
        $resep->delete();

        return redirect()->route('admin.resep.index')->with('success', 'Data resep berhasil dihapus');
    }
}
