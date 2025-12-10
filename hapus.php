<?php
session_start();
include 'koneksi.php';

// Cek Login Admin
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit;
}

// Cek apakah ada ID yang dikirim
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Ambil nama gambar dari database (agar file gambar bisa dihapus dari folder)
    $query_cek = mysqli_query($conn, "SELECT bukti_transfer FROM donasi WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query_cek);

    // 2. Hapus file fisik gambar di folder uploads
    if ($data) {
        $file_gambar = "uploads/" . $data['bukti_transfer'];
        if (file_exists($file_gambar)) {
            unlink($file_gambar); 
        }
    }

    // 3. Hapus data baris dari database
    $query_hapus = mysqli_query($conn, "DELETE FROM donasi WHERE id = '$id'");

    if ($query_hapus) {
        echo "<script>
                alert('Data BERHASIL dihapus!');
                document.location.href = 'admin.php';
              </script>";
    } else {
        echo "<script>
                alert('Data GAGAL dihapus!');
                document.location.href = 'admin.php';
              </script>";
    }
} else {
    // Jika tidak ada ID, kembalikan ke admin
    header("Location: admin.php");
}
?>