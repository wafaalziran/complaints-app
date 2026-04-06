<style>
    /* 1. Reset & Font Dasar */
    * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    body { background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }

    /* 2. Container Utama */
    .card { background: white; padding: 30px; border-radius: 12px; shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 400px; border: 1px solid #eee; }
    h2 { text-align: center; color: #333; margin-bottom: 20px; font-size: 24px; }

    /* 3. Styling Form */
    .form-group { margin-bottom: 15px; }
    label { display: block; margin-bottom: 5px; font-weight: 600; color: #555; font-size: 14px; }

    input, select, textarea {
        width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; transition: border-color 0.3s;
    }

    /* Efek biru saat kotak diklik */
    input:focus, select:focus, textarea:focus {
        outline: none; border-color: #3498db; box-shadow: 0 0 5px rgba(52,152,219,0.2);
    }

    /* 4. Tombol Kirim */
    button {
        width: 100%; padding: 12px; background-color: #3498db; color: white; border: none; border-radius: 6px;
        font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.3s; margin-top: 10px;
    }
    button:hover { background-color: #2980b9; }
</style>

<div class="card">
    <h2>Pengaduan Sarana Sekolah</h2>

    <form method="POST" action="/aspirasi">
        @csrf

        <div class="form-group">
            <label>NIS</label>
            <input type="number" name="nis" oninput="if (this.value.length > 10) this.value = this.value.slice(0, 10);" placeholder="Masukkan NIS Anda" required>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="1">Kebersihan</option>
                <option value="2">Keamanan</option>
                <option value="3">Fasilitas</option>
            </select>
        </div>

        <div class="form-group">
            <label>Lokasi</label>
            <input type="text" name="lokasi" placeholder="Contoh: Kelas 10A, Ruang Guru, Perpustakaan" required>
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" rows="3" placeholder="Apa masalahnya?" required></textarea>
        </div>

        <div class="form-group">
            <label>Rating Feedback</label>
            <select name="feedback" required>
                <option value="1">⭐</option>
                <option value="2">⭐⭐⭐</option>
                <option value="3">⭐⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐⭐</option>
                <option value="5">⭐⭐⭐⭐⭐</option>
            </select>
        </div>

        <button type="submit">Kirim Laporan</button>
    </form>
</div>