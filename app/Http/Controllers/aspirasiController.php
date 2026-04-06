<?php

namespace App\Http\Controllers;
use App\Models\aspirasi;

use Illuminate\Http\Request;

class aspirasiController extends Controller
{

    public function index() {
        return aspirasi::all();
    }

    public function store(Request $request)
{
    $request->validate([
        'nis' => 'required',
        'id_kategori' => 'required',
        'lokasi' => 'required',
        'keterangan' => 'required'
    ], [
        'nis.required' => 'NIS wajib diisi',
        'id_kategori.required' => 'Kategori wajib dipilih',
        'lokasi.required' => 'Lokasi wajib diisi',
        'keterangan.required' => 'Keterangan wajib diisi'
    ]);

    aspirasi::create($request->all());

    return back()->with('success', 'Berhasil dikirim');
}

    public function update(Request $request, $id) {
        $data = aspirasi::find($id);
        $data->status = $request->status;
        $data->feedback = $request->feedback;
        $data->save();

        return back();
    }
}

