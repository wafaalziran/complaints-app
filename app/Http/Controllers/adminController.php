<?php
namespace App\Http\Controllers;

use App\Models\aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminController extends Controller
{
    // Menampilkan semua laporan ke Admin
    public function index(Request $request)
    {
        // fungsi untuk query mysql
        $semuaKategori = DB::table('kategori')->get();
        $query = \App\Models\aspirasi::query();

        // Filter Kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // Filter Bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // Filter Hari (Tanggal spesifik)
        if ($request->filled('hari')) {
            $query->whereDate('created_at', $request->hari);
        }

        $laporan = $query->latest()->get();

        // Kirim data laporan dan kategori ke view/blade admin
        return view('admin', compact('laporan', 'semuaKategori'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Mencari data berdasarkan ID, jika tidak ketemu akan error 404
        $data = \App\Models\aspirasi::findOrFail($id);

        // Mengupdate kolom status dan feedback sesuai input dari form admin
        $data->status = $request->status;
        $data->feedback = $request->feedback; // simpan feedback
        $data->save();

        // Kembali ke halaman admin dengan pesan sukses
        return redirect()->route('admin.index')->with('success', 'Berhasil update!');
    }
}