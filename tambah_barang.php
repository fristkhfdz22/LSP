<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $sql = "INSERT INTO barang (kode_barang, nama_barang, harga, stok) VALUES ('$kode_barang', '$nama_barang', '$harga', '$stok')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
</head>
<body>
    <h1>Tambah Barang</h1>
    <form action="" method="post">
        <label>Kode Barang:</label><br>
        <input type="text" name="kode_barang" required><br><br>

        <label>Nama Barang:</label><br>
        <input type="text" name="nama_barang" required><br><br>

        <label>Harga:</label><br>
        <input type="number" name="harga" required><br><br>

        <label>Stok:</label><br>
        <input type="number" name="stok" required><br><br>

        <button type="submit">Tambah</button>
    </form>
    <a href="index.php">Kembali ke Daftar Barang</a>
</body>
</html>
