<?php
include 'config.php';

// Cek apakah ada input pencarian
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $sql = "SELECT * FROM barang WHERE kode_barang LIKE '%$search_query%' OR nama_barang LIKE '%$search_query%'";
} else {
    $sql = "SELECT * FROM barang";
}
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Barang</title>
</head>
<body>
    <h1>Daftar Barang</h1>

    <!-- Form Pencarian -->
    <form action="index.php" method="get">
        <input type="text" name="search" placeholder="Cari kode atau nama barang" value="<?php echo htmlspecialchars($search_query); ?>">
        <button type="submit">Cari</button>
        <a href="index.php">Reset</a> <!-- Tombol reset untuk menghapus pencarian -->
    </form>

    <a href="barang/tambah_barang.php">Tambah Barang</a>
    <table border="1">
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['kode_barang']; ?></td>
                <td><?php echo $row['nama_barang']; ?></td>
                <td>Rp. <?php echo number_format($row['harga'], 2); ?></td>
                <td><?php echo $row['stok']; ?></td>
                <td>
                    <a href="barang/edit_barang.php?id=<?php echo $row['id']; ?>">Edit</a> |
                    <a href="barang/hapus_barang.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a> |
                    <a href="transaksi/tambah_transaksi.php?id=<?php echo $row['id']; ?>">Beli</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="logout.php">Logout</a>

</body>
</html>
