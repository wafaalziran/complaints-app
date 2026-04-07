<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Aspirasi - Siswa</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; }
        
        /* Navigasi Header */
        .header { 
            background: white; 
            padding: 15px 5%; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .user-info { font-weight: bold; color: #2c3e50; }
        
        .btn-logout {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-logout:hover { background: #c0392b; }

        .container { width: 95%; max-width: 1100px; margin: 30px auto; }
        h2 { color: #2c3e50; margin-bottom: 20px; }

        /* Desain Tabel Laporan */
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #3498db; color: white; text-transform: uppercase; font-size: 13px; letter-spacing: 1px; }
        tr:hover { background-color: #fcfcfc; }

        /* Warna Badge Status Dinamis */
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 11px; font-weight: bold; display: inline-block; text-transform: uppercase; }
        .bg-warning { background: #ffeaa7; color: #d6a312; border: 1px solid #d6a312; }
        .bg-info { background: #81ecec; color: #008b8b; border: 1px solid #008b8b; }
        .bg-success { background: #55efc4; color: #00b894; border: 1px solid #00b894; }

        /* Waktu & Tanggal */
        .time-text { font-size: 11px; color: #95a5a6; display: block; margin-top: 4px; }
        .update-box { margin-top: 8px; padding-top: 8px; border-top: 1px dashed #ddd; }
        .update-label { font-size: 10px; font-weight: bold; color: #2ecc71; text-transform: uppercase; }

        /* Tipografi Feedback Admin */
        .feedback-text { font-style: italic; color: #34495e; font-size: 13px; margin-top: 5px; background: #f9f9f9; padding: 10px; border-radius: 6px; }
        .stars { color: #f1c40f; font-weight: bold; font-size: 14px; display: block; margin-bottom: 3px; }
        .desc-text { color: #2c3e50; font-weight: bold; font-size: 12px; display: block; }
        
        /* Gaya Pesan Admin Baru */
        .admin-message {
            margin: 8px 0;
            padding: 10px;
            background: #ffffff;
            border-radius: 6px;
            border-left: 4px solid #3498db;
            color: #2c3e50;
            font-style: normal;
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
        }
    </style>
</head>
<body>

<div class="header">
    <div class="user-info">Halo, 👤 (NIS: {{ Auth::user()->nis }})</div>
    <form action="/logout" method="POST" style="margin: 0;">
        @csrf
        <button type="submit" class="btn-logout">Logout</button>
    </form>
</div>

<div class="container">
    <h2>Daftar Laporan Aspirasi Anda</h2>
    
    <table>
        <thead>
            <tr>
                <th style="width: 18%">Waktu Kirim</th>
                <th style="width: 15%">Kategori</th>
                <th style="width: 30%">Keterangan & Lokasi</th>
                <th style="width: 12%">Status</th>
                <th style="width: 25%">Tanggapan Admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($semuaAspirasi as $item)
            <tr>
                <td>
                    <strong style="font-size: 14px; color: #2c3e50;">{{ $item->created_at->translatedFormat('d M Y') }}</strong>
                    <span class="time-text">🕒 {{ $item->created_at->translatedFormat('H:i') }} WIB</span>
                </td>
                
                <td>
                    <span style="background: #ecf0f1; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; color: #34495e;">
                        @if($item->id_kategori == 1) Fasilitas Rusak
                        @elseif($item->id_kategori == 2) Kebersihan
                        @else Keamanan @endif
                    </span>
                </td>

                <td>
                    <p style="margin: 0; color: #2c3e50; line-height: 1.4;">{{ $item->keterangan }}</p>
                    <small style="color: #3498db; font-weight: bold; display: block; margin-top: 5px;">📍 {{ $item->lokasi }}</small>
                </td>

                <td>
                    <span class="badge @if($item->status == 'Menunggu') bg-warning @elseif($item->status == 'Proses') bg-info @else bg-success @endif">
                        {{ $item->status }}
                    </span>
                </td>

                <td>
                    @if($item->feedback || $item->pesan_admin)
                        <div class="feedback-text">
                            {{-- Tampilkan Bintang Jika Ada --}}
                            @if(is_numeric($item->feedback))
                                <span class="stars">@for($i = 0; $i < $item->feedback; $i++) ⭐ @endfor</span>
                                <span class="desc-text">
                                    @if($item->feedback == '1') Urgensi: Rendah
                                    @elseif($item->feedback == '2') Urgensi: Menengah
                                    @elseif($item->feedback == '3') Urgensi: Penting
                                    @elseif($item->feedback == '4') Urgensi: Segera
                                    @elseif($item->feedback == '5') Urgensi: Darurat
                                    @endif
                                </span>
                            @endif

                            {{-- Tampilkan Pesan Tekstual Admin --}}
                            @if($item->pesan_admin)
                                <div class="admin-message">
                                    <strong style="font-size: 11px; color: #3498db; text-transform: uppercase;">💬 Balasan:</strong><br>
                                    <span style="font-size: 13px;">{{ $item->pesan_admin }}</span>
                                </div>
                            @endif

                            {{-- Indikator Waktu Update --}}
                            @if($item->updated_at != $item->created_at)
                            <div class="update-box">
                                <span class="update-label">Update Terakhir:</span>
                                <span class="time-text" style="color: #27ae60; font-weight: bold;">
                                    {{ $item->updated_at->translatedFormat('d M Y, H:i') }} WIB
                                </span>
                                <small style="color: #95a5a6; font-style: italic;">({{ $item->updated_at->diffForHumans() }})</small>
                            </div>
                            @endif
                        </div>
                    @else
                        <div style="text-align: center;">
                            <small style="color: #ccc; font-style: italic;">Menunggu tanggapan admin...</small>
                        </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 30px; display: flex; gap: 15px; align-items: center;">
        <a href="/p-siswa/create" style="text-decoration: none; background: #3498db; color: white; padding: 12px 25px; border-radius: 8px; font-weight: bold; transition: 0.3s; box-shadow: 0 4px 6px rgba(52, 152, 219, 0.2);">+ Buat Laporan Baru</a>
        <a href="/p-siswa" style="text-decoration: none; color: #7f8c8d; font-size: 14px; font-weight: bold;">Kembali ke Beranda</a>
    </div>
</div>

</body>
</html>