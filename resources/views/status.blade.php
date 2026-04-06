<style>
    body { font-family: 'Arial', sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; }
    .container { width: 95%; max-width: 1100px; margin: 30px auto; }
    h2 { color: #2c3e50; margin-bottom: 20px; }

    /* Desain Tabel Laporan */
    table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
    th { background-color: #3498db; color: white; text-transform: uppercase; font-size: 13px; letter-spacing: 1px; }
    tr:hover { background-color: #fcfcfc; }

    /* Warna Badge Status Dinamis */
    .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; display: inline-block; }
    .bg-warning { background: #ffeaa7; color: #d6a312; }
    .bg-info { background: #81ecec; color: #008b8b; }
    .bg-success { background: #55efc4; color: #00b894; }

    /* Tipografi Feedback Admin */
    .feedback-text { font-style: italic; color: #7f8c8d; font-size: 13px; margin-top: 5px; }
    .stars { color: #f1c40f; font-weight: bold; font-size: 14px; display: block; }
    .desc-text { color: #2ecc71; font-weight: bold; font-size: 11px; display: block; margin-top: 2px; }
</style>

<div class="container">
    <h2>Daftar Laporan Aspirasi</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Keterangan & Lokasi</th>
                <th>Status</th>
                <th>Tanggapan Admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($semuaAspirasi as $item)
            <tr>
                <td>{{ $item->created_at->format('d M Y') }}</td>
                <td>
                    <strong>
                        @if($item->id_kategori == 1) Fasilitas Rusak
                        @elseif($item->id_kategori == 2) Kebersihan
                        @else Keamanan @endif
                    </strong>
                </td>
                <td>
                    {{ $item->keterangan }} <br>
                    <small style="color: #999;">📍 {{ $item->lokasi }}</small>
                </td>
                <td>
                    <span class="badge @if($item->status == 'Menunggu') bg-warning @elseif($item->status == 'Proses') bg-info @else bg-success @endif">
                        {{ $item->status }}
                    </span>
                </td>
                <td>
                    @if($item->feedback)
                        <div class="feedback-text">
                            @if(is_numeric($item->feedback))
                                <span class="stars">@for($i = 0; $i < $item->feedback; $i++) ⭐ @endfor</span>

                                <span class="desc-text">
                                    @if($item->feedback == '1') (Masih Aman)
                                    @elseif($item->feedback == '2') (Survei)
                                    @elseif($item->feedback == '3') (Dipertimbangkan)
                                    @elseif($item->feedback == '4') (Segera)
                                    @elseif($item->feedback == '5') (Ditindaklanjuti)
                                    @endif
                                </span>
                            @else
                                {{ $item->feedback }}
                            @endif
                        </div>
                    @else
                        <small style="color: #ccc;">Belum ada tanggapan</small>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top: 20px;">
        <a href="/p-siswa/create" style="text-decoration: none; background: #3498db; color: white; padding: 10px 20px; border-radius: 5px; font-weight: bold;">+ Laporan Baru</a>
    </div>
</div>