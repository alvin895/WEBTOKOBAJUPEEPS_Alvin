<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja | Toko Peeps Alvin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">🛒 Daftar Produk di Keranjang</h3>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Nama Pembeli</th>
                <th>Ukuran</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $keranjang = mysqli_query($conn, "
                SELECT k.*, p.product_name 
                FROM alvin_keranjang k
                LEFT JOIN alvin_product p ON k.id_produk = p.product_id
            ");
            while($row = mysqli_fetch_array($keranjang)){
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['product_name'] ?></td>
                <td><?= $row['nama_pembeli'] ?></td>
                <td><?= $row['ukuran'] ?></td>
                <td><?= $row['jumlah'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-primary">← Kembali ke Beranda</a>
</div>
</body>
</html>
