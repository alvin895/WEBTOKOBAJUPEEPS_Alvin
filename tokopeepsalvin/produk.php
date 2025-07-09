<?php
session_start();
include '../db.php';

// Cek login admin
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    echo '<script>window.location="../login.php"</script>';
    exit;
}

$produk = mysqli_query($conn, "SELECT * FROM alvin_product");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <h2 class="mb-4">Kelola Produk</h2>
  <a href="tambah-produk.php" class="btn btn-success mb-3">+ Tambah Produk</a>
  <table class="table table-striped table-bordered">
    <thead class="table-primary">
      <tr>
        <th>No</th>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Ukuran</th>
        <th>Warna</th>
        <th>Gambar</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; while($p = mysqli_fetch_array($produk)) { ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $p['product_name'] ?></td>
        <td>Rp<?= number_format($p['product_price']) ?></td>
        <td><?= $p['product_size'] ?></td>
        <td><?= $p['product_color'] ?></td>
        <td><img src="../image/<?= $p['product_image'] ?>" width="80"></td>
        <td><?= $p['product_status'] == 1 ? 'Tampil' : 'Tidak Tampil' ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
