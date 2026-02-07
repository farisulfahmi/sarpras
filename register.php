<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Inventori Lab</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); height: 100vh; display: flex; align-items: center; justify-content: center; }
        .reg-container { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); padding: 30px; border-radius: 15px; box-shadow: 0 8px 32px rgba(0,0,0,0.3); width: 100%; max-width: 450px; border: 1px solid rgba(255,255,255,0.1); color: white; }
        h2 { text-align: center; margin-bottom: 20px; letter-spacing: 1px; }
        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; margin-bottom: 5px; font-size: 0.9em; }
        .input-group input, .input-group select { width: 100%; padding: 10px; border: none; border-radius: 5px; background: rgba(255,255,255,0.2); color: white; outline: none; }
        .input-group select option { background: #1e3c72; }
        .btn-reg { width: 100%; padding: 12px; border: none; border-radius: 5px; background: #2ecc71; color: #fff; font-weight: bold; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        .btn-reg:hover { background: #27ae60; transform: translateY(-2px); }
        .login-link { text-align: center; margin-top: 15px; font-size: 0.85em; }
        .login-link a { color: #2ecc71; text-decoration: none; }
    </style>
</head>
<body>
    <div class="reg-container">
        <h2>BUAT AKUN BARU</h2>
        <form action="proses_register.php" method="POST">
            <div class="input-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" placeholder="Nama Lengkap Anda" required>
            </div>
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Buat Username" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Buat Password Kuat" required>
            </div>
            <div class="input-group">
                <label>Daftar Sebagai</label>
                <select name="role">
                    <option value="user">User / Mahasiswa</option>
                    <option value="admin">Admin Lab</option>
                </select>
            </div>
            <button type="submit" class="btn-reg">DAFTAR SEKARANG</button>
        </form>
        <div class="login-link">
            Sudah punya akun? <a href="login.php">Login di sini</a>
        </div>
    </div>
</body>
</html>