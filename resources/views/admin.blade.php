<style>
    /* Reset & Font */
    body { font-family: 'Arial', sans-serif; background-color: #f0f2f5; margin: 0; padding: 20px; }

    /* Header Area */
    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        background: white;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .top-bar h2 { margin: 0; color: #333; font-size: 1.2rem; }

    /* Area Filter */
    .filter-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: flex-end;
    }
    .filter-group { display: flex; flex-direction: column; gap: 5px; }
    .filter-group label { font-size: 12px; font-weight: bold; color: #666; }

    input, select {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
        outline: none;
    }

    /* Tabel Box */
    .table-card {
        background: white;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        overflow-x: auto;
    }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
    th { background-color: #f8f9fa; color: #555; font-size: 13px; }

    /* Badge & Button */
    /* Badge Status */
    .badge {
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 11px;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 10px; /* Biar ada jarak dengan form di bawahnya */
    }
    .status-menunggu { background: #ffeaa7; color: #d6a312; }
    .status-proses { background: #81ecec; color: #008b8b; }
    .status-selesai { background: #55efc4; color: #00b894; }

    /* Styling area update */
    .update-box {
        background: #f9f9f9;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #eee;
    }

    .input-feedback {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 12px;
        box-sizing: border-box; /* Agar tidak lewat batas */
    }

    .btn-logout { background: #ff4757; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; }
    .btn-filter { background: #3498db; color: white; border: none; padding: 8px 20px; border-radius: 5px; cursor: pointer; }
    .btn-save { background: #2ecc71; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; }

    .input-feedback { width: 100%; margin-top: 5px; font-size: 12px; }
</style>

<div class="top-bar">
    <h2>Pusat Laporan Siswa (Admin)</h2>
    <form action="/logout" method="POST">
        @csrf
        <button type="submit" class="btn-logout">Logout</button>
    </form>
</div>

<div class="filter-card">
    <form action="{{ route('admin.index') }}" method="GET" class="filter-form">

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
            <label>Tanggal Spesifik</label>
            <input type="date" name="hari" value="{{ request('hari') }}"
                   style="padding: 7px; border: 1px solid #ddd; border-radius: 5px;">
        </div>

        <div style="display: flex; gap: 10px; align-items: center; margin-top: 5px;">
            <button type="submit" class="btn-filter">Cari Laporan</button>
            <a href="{{ route('admin.index') }}" class="btn-reset" style="font-size: 13px; color: #e74c3c; text-decoration: none; font-weight: bold;">
                Reset Filter
            </a>
        </div>
    </form>
</div>

<div class="table-card">
    @if(session('success'))
        <div style="color: #27ae60; padding: 10px; font-weight: bold; background: #ebfaef; border-radius: 5px; margin-bottom: 10px;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 35%">Laporan & Detail</th>
                <th style="width: 20%">Kategori</th>
                <th style="width: 40%">Status & Update Admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $index => $l)
            <tr>
                <td>{{ $index + 1 }}</td>

                <td>
                    <small style="color: #888;">📅 {{ $l->created_at->format('d M Y') }}</small><br>
                    <strong>🆔 NIS: {{ $l->nis }}</strong><br>
                    <p style="margin: 5px 0; color: #555; line-height: 1.4;">{{ $l->keterangan }}</p>
                </td>

                <td>
                    @php
                        $kat = $semuaKategori->where('id_kategori', $l->id_kategori)->first();
                    @endphp
                    <span style="color: #34495e; font-weight: bold; background: #f0f2f5; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                        {{ $kat ? $kat->ket_kategori : '-' }}
                    </span>
                </td>

                <td>
                    <span class="badge
                        @if($l->status == 'Menunggu') status-menunggu
                        @elseif($l->status == 'Proses') status-proses
                        @else status-selesai
                        @endif">
                        {{ strtoupper($l->status) }}
                    </span>

                    <div style="background: #fdfdfd; padding: 12px; border: 1px solid #eee; border-radius: 8px; margin-top: 8px;">
                        <form action="{{ route('admin.update', $l->id) }}" method="POST">
                            @csrf

                            <div style="display: flex; gap: 5px; margin-bottom: 8px;">
                                <select name="status" style="flex: 2; padding: 6px;">
                                    <option value="Menunggu" {{ $l->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Proses" {{ $l->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                    <option value="Selesai" {{ $l->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                <button type="submit" class="btn-save" style="flex: 1;">Update</button>
                            </div>

                            <div style="display: flex; align-items: center; gap: 10px;">
                                <label style="font-size: 11px; font-weight: bold; color: #7f8c8d;">RATING:</label>
                                <select name="feedback" required style="flex: 1; padding: 5px; border: 1px dashed #cbd5e0;">
                                    <option value="1" {{ $l->feedback == '1' ? 'selected' : '' }}>⭐ (Masih Aman)</option>
                                    <option value="2" {{ $l->feedback == '2' ? 'selected' : '' }}>⭐⭐ (Survei)</option>
                                    <option value="3" {{ $l->feedback == '3' ? 'selected' : '' }}>⭐⭐⭐ (Dipertimbangkan)</option>
                                    <option value="4" {{ $l->feedback == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (Segera)</option>
                                    <option value="5" {{ $l->feedback == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (Ditindaklanjuti)</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>