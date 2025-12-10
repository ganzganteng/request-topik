<?php
session_start();
include 'koneksi.php';

// Jika sudah login, langsung lempar ke admin.php
if (isset($_SESSION['status']) && $_SESSION['status'] == "login") {
    header("Location: admin.php");
    exit;
}

$pesan_error = "";

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = $_POST['password'];

    $cek = mysqli_query($conn, "SELECT * FROM admins WHERE email = '$email'");
    $data = mysqli_fetch_assoc($cek);

    if ($data) {
        // Cek Password
        if (password_verify($pass, $data['password'])) {
            $_SESSION['status'] = "login";
            $_SESSION['admin_email'] = $email;
            header("Location: admin.php");
            exit;
        } else {
            $pesan_error = "Password Salah!";
        }
    } else {
        $pesan_error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; height: 100vh; align-items: center; background: #eee; }
        .kotak { background: white; padding: 20px; width: 300px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 10px; margin: 5px 0 15px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: blue; color: white; border: none; cursor: pointer; }
        .error { color: red; font-size: 14px; text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="kotak">
        <h3 style="text-align:center">Login Admin</h3>
        <?php if($pesan_error) { echo "<div class='error'>$pesan_error</div>"; } ?>
        
        <form method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <br>
        <center><a href="index.php">Kembali ke Home</a></center>
    </div>
</body>
</html>