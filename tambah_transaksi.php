<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id_barang = $_GET['id'];

    // Dapatkan data barang yang dipilih
    $sql_barang = "SELECT * FROM barang WHERE id = $id_barang";
    $result_barang = $conn->query($sql_barang);
    $barang = $result_barang->fetch_assoc();

    if (!$barang) {
        echo "Barang tidak ditemukan!";
        exit;
    }

    // Jika form disubmit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $jumlah = $_POST['jumlah'];
        $total = $barang['harga'] * $jumlah;

        // Cek apakah stok cukup
        if ($jumlah > $barang['stok']) {
            echo "Stok tidak mencukupi!";
            exit;
        }

        // Masukkan transaksi ke tabel transaksi
        $sql_transaksi = "INSERT INTO transaksi (id_barang, jumlah, total, tanggal) VALUES ('$id_barang', '$jumlah', '$total', NOW())";
        if ($conn->query($sql_transaksi) === TRUE) {
            // Ambil ID transaksi yang baru saja dimasukkan
            $id_transaksi = $conn->insert_id;

            // Kurangi stok barang
            $stok_baru = $barang['stok'] - $jumlah;
            $sql_update_stok = "UPDATE barang SET stok = $stok_baru WHERE id = $id_barang";
            $conn->query($sql_update_stok);

            // Ambil data transaksi yang baru saja dimasukkan
            $sql_transaksi_detail = "SELECT t.id, t.jumlah, t.total, t.tanggal, b.nama_barang, b.harga 
                                     FROM transaksi t 
                                     JOIN barang b ON t.id_barang = b.id 
                                     WHERE t.id = $id_transaksi";
            $result_transaksi = $conn->query($sql_transaksi_detail);
            if ($result_transaksi) {
                $transaksi = $result_transaksi->fetch_assoc();
                if (!$transaksi) {
                    echo "Tidak ada transaksi ditemukan!";
                    exit;
                }
            } else {
                echo "Error mengambil detail transaksi: " . $conn->error;
                exit;
            }

            // Menampilkan struk
            echo "<h1>Struk Transaksi</h1>";
            echo "<p><strong>No. Transaksi:</strong> " . $transaksi['id'] . "</p>";
            echo "<p><strong>Barang:</strong> " . $transaksi['nama_barang'] . "</p>";
            echo "<p><strong>Harga:</strong> Rp " . number_format($transaksi['harga'], 2) . "</p>";
            echo "<p><strong>Jumlah:</strong> " . $transaksi['jumlah'] . "</p>";
            echo "<p><strong>Total:</strong> Rp " . number_format($transaksi['total'], 2) . "</p>";
            echo "<p><strong>Tanggal:</strong> " . $transaksi['tanggal'] . "</p>";
            
            // Tombol untuk mencetak struk
            echo "<button onclick='window.print()'>Cetak Struk</button><br><br>";

            // Tombol untuk kembali ke halaman transaksi atau daftar barang
            echo "<a href='index.php'>Kembali ke Daftar Barang</a>";
            echo "<br>";
            echo "<a href='tambah_transaksi.php?id=$id_barang'>Kembali ke Transaksi</a>";

            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    echo "ID Barang tidak valid!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Transaksi</title>
</head>
<body>
    <h1>Beli Barang - <?php echo $barang['nama_barang']; ?></h1>
    <form action="" method="post">
        <label>Harga per unit:</label><br>
        <input type="text" value="<?php echo number_format($barang['harga'], 2); ?>" disabled><br><br>

        <label>Jumlah Beli:</label><br>
        <input type="number" name="jumlah" min="1" max="<?php echo $barang['stok']; ?>" required><br><br>

        <p>Stok Tersedia: <?php echo $barang['stok']; ?></p>
        <button type="submit">Beli</button>
    </form>
    <a href="index.php">Kembali ke Daftar Barang</a>
</body>
</html>
