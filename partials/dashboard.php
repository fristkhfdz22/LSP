<div id="layoutSidenav_content">
                <main>
                   
<div class="card mb-4" >
<!-- <form action="index.php" method="get"  class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
      
        <div class="input-group">
                    <input  type="text" name="search" placeholder="Cari kode atau nama barang"  aria-label="Search for..." aria-describedby="btnNavbarSearch" value="<?php echo htmlspecialchars($search_query); ?>">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                    <a href="index.php">Reset</a>


                </div>
    </form> -->
    <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
    <table border="1" id="datatablesSimple">

       <thead>
       <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
       </thead>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['kode_barang']; ?></td>
                <td><?php echo $row['nama_barang']; ?></td>
                <td>Rp. <?php echo number_format($row['harga'], 2); ?></td>
                <td><?php echo $row['stok']; ?></td>
                <td>
                    <a href="edit_barang.php?id=<?php echo $row['id']; ?> " class="btn btn-warning">Edit</a> |
                    <a href="hapus_barang.php?id=<?php echo $row['id']; ?> " class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a> |
                    <a href="tambah_transaksi.php?id=<?php echo $row['id']; ?> " class="btn btn-primary">Beli</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
                </main>