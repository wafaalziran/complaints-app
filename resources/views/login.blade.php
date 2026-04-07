<style>
    body { background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; font-family: sans-serif; }
    .login-card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 350px; display: flex; flex-direction: column; }
    .logo-container { text-align: center; margin-bottom: 20px; }
    .logo-container img { max-width: 80px; height: auto; display: inline-block; }
    h2 { text-align: center; color: #333; margin-top: 0; font-size: 20px; margin-bottom: 20px; }
    .form-group { margin-bottom: 15px; }
    label { display: block; margin-bottom: 5px; font-size: 14px; color: #666; }
    input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
    button { width: 100%; padding: 12px; background-color: #3498db; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; margin-top: 10px; }
    button:hover { background-color: #2980b9; }
    .error-box { background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; font-size: 13px; margin-bottom: 15px; border: 1px solid #f5c6cb; }
</style>

<div class="login-card">
    <div class="logo-container">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>

    <title>Sistem Sarana Aplikasi Pengaduan Sekolah</title>
    <h2>Sistem Aplikasi <br> Sarana Pengaduan</h2>

    {{-- Pesan Error Jika Login Gagal --}}
    @if(session()->has('loginError'))
        <div class="error-box">
            {{ session('loginError') }}
        </div>
    @endif

    {{-- Pesan Error Jika Validasi Form Gagal --}}
    @if($errors->any())
        <div class="error-box">
            Email harus berformat alamat email!
        </div>
    @endif

    <form action="/login" method="POST">
        @csrf
        <div style="margin-bottom: 15px;">
            <label>NIS (Siswa) / Username (Admin)</label>
            <input type="text" name="login_identity" class="form-control" placeholder="Masukkan NIS atau Username" required autofocus>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn-login">Login</button>
    </form>
    </div>  