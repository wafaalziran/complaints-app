<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pusat Laporan Siswa</title>
    <style>
        /* Reset & Font */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; margin: 0; padding: 20px; }

        /* Header Area */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background: white;
            padding: 15px 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .top-bar h2 { margin: 0; color: #2c3e50; font-size: 1.4rem; }

        /* Area Filter */
        .filter-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
        }
        .filter-group { display: flex; flex-direction: column; gap: 5px; }
        .filter-group label { font-size: 12px; font-weight: bold; color: #7f8c8d; text-transform: uppercase; }

        input, select {
            padding: 10px;
            border: 1px solid #dfe6e9;
            border-radius: 6px;
            outline: none;
            transition: 0.3s;
        }
        input:focus, select:focus { border-color: #3498db; box-shadow: 0 0 5px rgba(52,152,219,0.2); }

        /* Tabel Box */
        .table-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            overflow-x: auto;
        }
        table { width: 100%; border-collapse: collapse; min-width: 900px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #f1f2f6; }
        th { background-color: #f8f9fa; color: #2c3e50; font-size: 13px; text-transform: uppercase; }

        /* Badge & Button */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            display: inline-block;
            margin-bottom: 10px;
        }
        .status-menunggu { background: #fff9db; color: #f1c40f; border: 1px solid #f1c40f; }
        .status-proses { background: #e3f2fd; color: #3498db; border: 1px solid #3498db; }
        .status-selesai { background: #e8f5e9; color: #2ecc71; border: 1px solid #2ecc71; }

        .btn-logout { background: #ff4757; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; }
        .btn-filter { background: #3498db; color: white; border: none; padding: 10px 25px; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-save { background: #2ecc71; color: white; border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-weight: bold; }

        /* Update Box Styling */
        .update-indicator {
            border-left: 3px solid #2ecc71;
            padding-left: 12px;
            background: #f0fff4;
            padding: 8px 12px;
            border-radius: 0 8px 8px 0;
        }
    </style>
</head>
<body>

<div class="top-bar">
    <div>
        <h2>Pusat Laporan Siswa (Admin)</h2>
        <small style="color: #7f8c8d;">Selamat datang, <strong>{{ Auth::user()->name }}</strong></small>
    </div>
    <form action="/logout" method="POST">
        @csrf
        <button type="submit" class="btn-logout">Keluar Sistem</button>
    </form>
</div>

<div class="filter-card">
    <form action="{{ route('admin.index') }}" method="GET" class="filter-form">
        
        <div class="filter-group">
            <label>Cari NIS</label>
            <input type="text" name="search_nis" placeholder="Contoh: 2324101..." value="{{ request('search_nis') }}">
        </div>

        <div class="filter-group">
            <label>Kategori</label>
            <select name="kategori">
                <option value="">Semua Kategori</option>
                @foreach($semuaKategori as $kat)
                    <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                        {{ $kat->ket_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label>Bulan</label>
            <select name="bulan">
                <option value="">Semua Bulan</option>
                @for($i=1; $i<=12; $i++)
                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="filter-group">
            <label>Tanggal</label>
            <input type="date" name="hari" value="{{ request('hari') }}">
        </div>

        <div style="display: flex; gap: 10px; align-items: center; margin-top: 5px;">
            <button type="submit" class="btn-filter">Terapkan Filter</button>
            <a href="{{ route('admin.index') }}" style="font-size: 13px; color: #e74c3c; text-decoration: none; font-weight: bold;">
                Reset
            </a>
        </div>
    </form>
</div>

<div class="table-card">
    @if(session('success'))
        <div style="color: #27ae60; padding: 15px; font-weight: bold; background: #ebfaef; border-radius: 8px; margin-bottom: 20px; border: 1px solid #2ecc71;">
        {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 25%">Laporan & Detail</th>
                <th style="width: 15%">Kategori</th>
                <th style="width: 20%">Update Terakhir</th>
                <th style="width: 35%">Aksi & Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $l)
            <tr>
                <td>{{ $index + 1 }}</td>

                <td>
                    <small style="color: #95a5a6; font-weight: bold;">📅 {{ $l->created_at->translatedFormat('d M Y, H:i') }} WIB</small><br>
                    <strong style="color: #34495e;">NIS: {{ $l->nis }}</strong><br>
                    <p style="margin: 8px 0; color: #555; font-size: 14px; line-height: 1.5;">{{ $l->keterangan }}</p>
                </td>

                <td>
                    @php $kat = $semuaKategori->where('id_kategori', $l->id_kategori)->first(); @endphp
                    <span style="color: #2c3e50; font-weight: bold; background: #f1f2f6; padding: 5px 10px; border-radius: 6px; font-size: 12px;">
                        {{ $kat ? $kat->ket_kategori : 'Umum' }}
                    </span>
                </td>

                <td>
                    @if($l->updated_at != $l->created_at)
                        <div class="update-indicator">
                            <small style="color: #27ae60; font-weight: 800; font-size: 10px; text-transform: uppercase;">Sudah Ditanggapi</small><br>
                            <span style="font-size: 13px; color: #2c3e50; display: block; margin-top: 2px;">
                                {{ $l->updated_at->translatedFormat('d M Y, H:i') }} WIB
                            </span>
                            <small style="color: #7f8c8d; font-style: italic;">({{ $l->updated_at->diffForHumans() }})</small>
                        </div>
                    @else
                        <span style="color: #bdc3c7; font-size: 12px; font-style: italic;">Belum ada tanggapan</span>
                    @endif
                </td>
                
                <td>
                    <span class="badge 
                        @if($l->status == 'Menunggu') status-menunggu 
                        @elseif($l->status == 'Proses') status-proses 
                        @else status-selesai @endif">
                        ● {{ strtoupper($l->status) }}
                    </span>

                    <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; border: 1px solid #edf2f7; margin-top: 5px;">
                        <form action="{{ route('admin.update', $l->id) }}" method="POST">
                            @csrf
                            <div style="display: flex; gap: 8px; margin-bottom: 10px;">
                                <select name="status" style="flex: 2; font-size: 13px;">
                                    <option value="Menunggu" {{ $l->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Proses" {{ $l->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                    <option value="Selesai" {{ $l->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                <button type="submit" class="btn-save" style="flex: 1;">Simpan</button>
                            </div>

                            <div style="margin-top: 10px;">
    <label style="font-size: 11px; font-weight: bold; color: #7f8c8d; display: block; margin-bottom: 5px;">PESAN BALASAN:</label>
    <textarea name="pesan_admin" rows="2" 
              placeholder="Tulis pesan untuk siswa..." 
              style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 12px; box-sizing: border-box;">{{ $l->pesan_admin }}</textarea>
</div>

                            <div style="display: flex; align-items: center; gap: 10px;">
                                <label style="font-size: 11px; font-weight: bold; color: #7f8c8d;">URGENSI:</label>
                                <select name="feedback" required style="flex: 1; padding: 5px; font-size: 12px;">
                                    <option value="1" {{ $l->feedback == '1' ? 'selected' : '' }}>⭐ (Rendah)</option>
                                    <option value="2" {{ $l->feedback == '2' ? 'selected' : '' }}>⭐⭐ (Normal)</option>
                                    <option value="3" {{ $l->feedback == '3' ? 'selected' : '' }}>⭐⭐⭐ (Penting)</option>
                                    <option value="4" {{ $l->feedback == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (Sangat Penting)</option>
                                    <option value="5" {{ $l->feedback == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (Darurat)</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 40px; color: #95a5a6;">
                    <strong>Data laporan tidak ditemukan.</strong><br>Silakan coba filter atau kata kunci lain.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>