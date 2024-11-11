<?php
include 'config.php';

$sql = "SELECT transaksi.*, barang.kode_barang, barang.nama_barang FROM transaksi
        JOIN barang ON transaksi.id_barang = barang.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Transaksi</title>
</head>
<body>
    <h1>Daftar Transaksi</h1>
    <table border="1">
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Tanggal</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['kode_barang']; ?></td>
                <td><?php echo $row['nama_barang']; ?></td>
                <td><?php echo $row['jumlah']; ?></td>
                <td>Rp. <?php echo number_format($row['total'], 2); ?></td>
                <td><?php echo $row['tanggal']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="index.php">Kembali ke Daftar Barang</a>
</body>
</html>
