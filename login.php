<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventori Lab</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-container { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); padding: 40px; border-radius: 15px; box-shadow: 0 8px 32px rgba(0,0,0,0.3); width: 100%; max-width: 400px; border: 1px solid rgba(255,255,255,0.1); color: white; }
        h2 { text-align: center; margin-bottom: 30px; letter-spacing: 2px; }
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; font-size: 0.9em; }
        .input-group input { width: 100%; padding: 12px; border: none; border-radius: 5px; background: rgba(255,255,255,0.2); color: white; outline: none; transition: 0.3s; }
        .input-group input:focus { background: rgba(255,255,255,0.3); box-shadow: 0 0 10px rgba(255,255,255,0.1); }
        .btn-login { width: 100%; padding: 12px; border: none; border-radius: 5px; background: #00d2ff; color: #fff; font-weight: bold; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        .btn-login:hover { background: #009bc2; transform: translateY(-2px); }
        .register-link { text-align: center; margin-top: 20px; font-size: 0.85em; }
        .register-link a { color: #00d2ff; text-decoration: none; }
        .error-msg { background: rgba(255,0,0,0.2); padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.8em; text-align: center; border: 1px solid red; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>INVENTORI LAB</h2>
        
        <?php if(isset($_GET['pesan']) && $_GET['pesan'] == "gagal"): ?>
            <div class="error-msg">Username atau Password Salah!</div>
        <?php endif; ?>

        <form action="cek_login.php" method="POST">
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan Username" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan Password" required>
            </div>
            <button type="submit" class="btn-login">LOGIN</button>
        </form>
        
        <div class="register-link">
            Belum punya akun? <a href="register.php">Daftar di sini</a>
        </div>
    </div>
</body>
</html>