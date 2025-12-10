<?php
include 'koneksi.php';
$pesan_status = "";

if (isset($_POST['kirim'])) {
    $nama   = htmlspecialchars($_POST['nama']);
    $jumlah = $_POST['jumlah'];
    $metode = htmlspecialchars($_POST['metode']);
    $pesan  = htmlspecialchars($_POST['pesan']);

    // --- PERUBAHAN DI SINI (Validasi PHP) ---
    // Cek apakah donasi kurang dari 5000
    if ($jumlah < 5000) {
        $pesan_status = "<div class='alert error'>Maaf, minimal donasi adalah Rp 5.000</div>";
    } else {
        // Proses Upload Gambar
        $nama_file = $_FILES['bukti']['name'];
        $tmp_file  = $_FILES['bukti']['tmp_name'];
        $ext       = pathinfo($nama_file, PATHINFO_EXTENSION);
        $nama_baru = time() . "." . $ext; 
        $tujuan    = "uploads/" . $nama_baru;

        $cek_gambar = getimagesize($tmp_file);
        if ($cek_gambar !== false) {
            if (move_uploaded_file($tmp_file, $tujuan)) {
                $sql = "INSERT INTO donasi (nama, jumlah, metode_pembayaran, pesan, bukti_transfer) 
                        VALUES ('$nama', '$jumlah', '$metode', '$pesan', '$nama_baru')";
                if (mysqli_query($conn, $sql)) {
                    $pesan_status = "<div class='alert success'>Terima kasih! Donasi Anda berhasil dikirim.</div>";
                } else {
                    $pesan_status = "<div class='alert error'>Error Database.</div>";
                }
            } else {
                $pesan_status = "<div class='alert error'>Gagal upload gambar.</div>";
            }
        } else {
            $pesan_status = "<div class='alert error'>File harus berupa gambar (JPG/PNG).</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Donasi</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; background: white; margin: auto; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .info-rek { background: #e7f3fe; border-left: 6px solid #2196F3; padding: 15px; margin-bottom: 20px; }
        input, select, textarea { width: 100%; padding: 10px; margin: 5px 0 15px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #28a745; color: white; border: none; cursor: pointer; font-size: 16px; }
        button:hover { background: #218838; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Formulir Donasi</h2>
        
        <div class="info-rek">
            <strong>Silakan Transfer ke:</strong><br>
            DANA: 0895619148643<br>
        </div>

        <?php echo $pesan_status; ?>

        <form method="post" enctype="multipart/form-data">
            <label>Nama Pengirim</label>
            <input type="text" name="nama" required placeholder="Nama Lengkap">

            <label>Metode Pembayaran</label>
            <select name="metode" required>
                <option value="">-- Pilih --</option>
                <option value="DANA">DANA</option>
            </select>

            <label>Jumlah Donasi (Min Rp 5.000)</label>
            <input type="number" name="jumlah" min="5000" required placeholder="Contoh: 5000">

            <label>request topik</label>
            <textarea name="pesan" rows="3" placeholder="Tulis topik kamu..."></textarea>

            <label>Bukti Transfer</label>
            <input type="file" name="bukti" required accept="image/*">

            <button type="submit" name="kirim">Kirim Donasi</button>
        </form>
        <br>
        <center><a href="login.php" style="color: grey; text-decoration: none; font-size: 12px;">Login Admin</a></center>
    </div>
</body>
</html>