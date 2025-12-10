<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Donasi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; padding: 30px; background-color: #f4f6f9; color: #333; }
        
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px; 
            background: white; 
            padding: 20px 30px; 
            border-radius: 12px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.05); 
        }
        .header h2 { margin: 0; color: #2c3e50; }

        .btn-logout { 
            background: #ff6b6b; 
            color: white; 
            padding: 10px 25px; 
            text-decoration: none; 
            border-radius: 30px; 
            font-weight: 600; 
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(255, 107, 107, 0.3);
        }
        .btn-logout:hover { background: #ee5253; transform: translateY(-2px); }

        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        table { width: 100%; border-collapse: collapse; }
        
        th { 
            background-color: #34495e; 
            color: white; 
            text-transform: uppercase; 
            font-size: 13px; 
            letter-spacing: 1px;
            padding: 18px;
            text-align: left;
        }
        
        td { 
            padding: 15px 18px; 
            border-bottom: 1px solid #eee; 
            vertical-align: middle;
        }
        
        tr:last-child td { border-bottom: none; }
        tr:hover { background-color: #f8f9fa; }
        
        .thumb-img { 
            width: 50px; 
            height: 50px; 
            object-fit: cover; 
            border-radius: 8px; 
            border: 2px solid #eef2f7; 
            transition: transform 0.3s; 
            cursor: zoom-in;
        }
        .thumb-img:hover { transform: scale(3.5); z-index: 10; position: relative; border-color: #34495e; }

        .badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .bg-money { background: #d1e7dd; color: #0f5132; }
        .bg-method { background: #cfe2ff; color: #084298; }

        .btn-hapus {
            background: #fff;
            color: #dc3545;
            border: 1px solid #dc3545;
            padding: 6px 15px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            transition: all 0.2s;
        }
        .btn-hapus:hover { background: #dc3545; color: white; }

    </style>
</head>
<body>

    <div class="header">
        <h2>📊 Data Donasi Masuk</h2>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Metode</th>
                    <th width="15%">Jumlah</th>
                    <th width="20%">Nama Pengirim</th>
                    <th width="25%">Pesan / Doa</th>
                    <th width="10%">Bukti</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM donasi ORDER BY id DESC");
                
                if (mysqli_num_rows($query) > 0) {
                    while($row = mysqli_fetch_assoc($query)) {
                        $rupiah = "Rp " . number_format($row['jumlah'],0,',','.');
                        
                        echo "<tr>
                            <td>{$no}</td>
                            <td><span class='badge bg-method'>{$row['metode_pembayaran']}</span></td>
                            <td><span class='badge bg-money'>{$rupiah}</span></td>
                            <td>
                                <strong>{$row['nama']}</strong><br>
                                <small style='color:#888; font-size:11px'>{$row['tanggal']}</small>
                            </td>
                            <td style='font-style:italic; color:#555;'>\"{$row['pesan']}\"</td>
                            <td>
                                <a href='uploads/{$row['bukti_transfer']}' target='_blank'>
                                    <img src='uploads/{$row['bukti_transfer']}' class='thumb-img'>
                                </a>
                            </td>
                            <td>
                                <a href='hapus.php?id={$row['id']}' class='btn-hapus' onclick=\"return confirm('Hapus data dari {$row['nama']}?');\">
                                    Hapus
                                </a>
                            </td>
                        </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align:center; padding: 40px; color:#888;'>Belum ada data donasi masuk.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>