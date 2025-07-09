<?php
session_start();
include '../db.php';

$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Ambil data pesanan
$pesanan = mysqli_query($conn, "SELECT * FROM alvin_pesanan WHERE id_pesanan = '$id'");
$p = mysqli_fetch_object($pesanan);

// Ambil detail produk dalam pesanan
$detail = mysqli_query($conn, "
  SELECT d.*, pr.product_name 
  FROM alvin_detail_pesanan d
  LEFT JOIN alvin_product pr ON d.product_id = pr.product_id
  WHERE d.id_pesanan = '$id'
");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Detail Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
  <h3 class="mb-3">🧾 Detail Pesanan #<?= $p->id_pesanan ?></h3>

  <div class="mb-4">
    <strong>Nama:</strong> <?= $p->nama_pembeli ?><br>
    <strong>No HP:</strong> <?= $p->no_hp ?><br>
    <strong>Alamat:</strong> <?= $p->alamat ?><br>
    <strong>Metode:</strong> <?= $p->metode_pembayaran ?><br>
    <strong>Tanggal:</strong> <?= $p->tanggal_beli ?><br>
    <strong>Status:</strong> <?= $p->status_pesanan ?><br>
  </div>

  <table class="table table-bordered">
    <thead class="table-secondary">
      <tr>
        <th>No</th>
        <th>Nama Produk</th>
        <th>Ukuran</th>
        <th>Warna</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      while($d = mysqli_fetch_array($detail)){
      ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $d['product_name'] ?></td>
        <td><?= $d['ukuran'] ?></td>
        <td><?= $d['warna'] ?></td>
        <td><?= $d['quantity'] ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

  <a href="pesanan.php" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
