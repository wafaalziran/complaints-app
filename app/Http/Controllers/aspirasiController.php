<?php

namespace App\Http\Controllers;

use App\Models\aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class aspirasiController extends Controller
{
    /**
     * Menampilkan daftar aspirasi (Halaman Status)
     */
    public function index()
    {
        $semuaAspirasi = aspirasi::where('nis', Auth::user()->nis)->get();
        return view('status', compact('semuaAspirasi'));
    }

    public function create()
    {
        return view('p-siswa');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required',
            'keterangan' => 'required',
            'lokasi' => 'required',
        ]);

        aspirasi::create([
            'nis' => Auth::user()->nis,
            'id_kategori' => $request->id_kategori,
            'keterangan' => $request->keterangan,
            'lokasi' => $request->lokasi,
            'status' => 'Menunggu',
        ]);

        return redirect('/aspirasi')->with('success', 'Aspirasi berhasil dikirim!');
    }
}