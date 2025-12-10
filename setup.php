<?php
include 'koneksi.php';

// Data Admin Baru
$email = "adityaalhudha366@gmail.com";
$password_asli = "delviadit27";

// Enkripsi Password
$password_hash = password_hash($password_asli, PASSWORD_DEFAULT);

// Cek apakah admin sudah ada
$cek = mysqli_query($conn, "SELECT * FROM admins WHERE email = '$email'");
if (mysqli_num_rows($cek) == 0) {
    $sql = "INSERT INTO admins (email, password) VALUES ('$email', '$password_hash')";
    if (mysqli_query($conn, $sql)) {
        echo "<h3>Sukses! Akun Admin Dibuat.</h3>";
        echo "Email: $email <br>";
        echo "Password: $password_asli <br>";
        echo "<br><a href='login.php'>Ke Halaman Login >></a>";
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
} else {
    echo "<h3>Admin sudah terdaftar sebelumnya.</h3>";
    echo "<a href='login.php'>Langsung Login Saja >></a>";
}
?>