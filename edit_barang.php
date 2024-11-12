<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM barang WHERE id = $id";
    $result = $conn->query($sql);
    $barang = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $kode_barang = $_POST['kode_barang'];
        $nama_barang = $_POST['nama_barang'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];

        $sql_update = "UPDATE barang SET kode_barang = '$kode_barang', nama_barang = '$nama_barang', harga = '$harga', stok = '$stok' WHERE id = $id";
        if ($conn->query($sql_update) === TRUE) {
            header("Location: index.php");
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    echo "Barang tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
</head>
<body>
    <h1>Edit Barang - <?php echo $barang['nama_barang']; ?></h1>
    <form action="" method="post">
        <label>Kode Barang:</label><br>
        <input type="text" name="kode_barang" value="<?php echo $barang['kode_barang']; ?>" required><br><br>

        <label>Nama Barang:</label><br>
        <input type="text" name="nama_barang" value="<?php echo $barang['nama_barang']; ?>" required><br><br>

        <label>Harga:</label><br>
        <input type="number" name="harga" value="<?php echo $barang['harga']; ?>" required><br><br>

        <label>Stok:</label><br>
        <input type="number" name="stok" value="<?php echo $barang['stok']; ?>" required><br><br>

        <button type="submit">Update</button>
    </form>
    <a href="index.php">Kembali ke Daftar Barang</a>
</body>
</html>
