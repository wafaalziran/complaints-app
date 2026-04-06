<style>
    body { background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; font-family: sans-serif; }
    .login-card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 350px; }
    h2 { text-align: center; color: #333; }
    .form-group { margin-bottom: 15px; }
    input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
    button { width: 100%; padding: 12px; background-color: #3498db; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
    .error { color: red; font-size: 13px; margin-bottom: 10px; }
</style>

<div class="login-card">
    <h2>Login Admin</h2>

    @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form action="/login" method="POST">
        @csrf
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</div>