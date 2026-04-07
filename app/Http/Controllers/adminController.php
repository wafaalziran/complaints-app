<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\aspirasi;

class adminController extends Controller
{
        public function index(Request $request)
    {
        $semuaKategori = DB::table('kategori')->get();
        $query = \App\Models\Aspirasi::query();

        if ($request->filled('search_nis')) {
            $query->where('nis', 'LIKE', '%' . $request->search_nis . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->filled('hari')) {
            $query->whereDate('created_at', $request->hari);
        }

        $laporan = $query->latest()->get();
        return view('admin', compact('laporan', 'semuaKategori'));
    }

        public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'feedback' => 'required',
            'pesan_admin' => 'nullable|string' // Validasi pesan
        ]);

        $laporan = \App\Models\aspirasi::findOrFail($id);
        $laporan->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
            'pesan_admin' => $request->pesan_admin
        ]);

        return redirect()->back()->with('success', 'Tanggapan berhasil dikirim!');
    }
}