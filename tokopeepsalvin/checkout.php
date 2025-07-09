<?php
include 'db.php';

// Ambil ID produk dari parameter
$id_produk = isset($_GET['id']) ? intval($_GET['id']) : 0;
$produk = mysqli_query($conn, "SELECT * FROM alvin_product WHERE product_id = $id_produk");
$p = mysqli_fetch_object($produk);

if (!$p) {
    echo "Produk tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Checkout Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Form Pemesanan Produk</h2>

  <form action="proses-checkout.php" method="post">
    <input type="hidden" name="product_id" value="<?= $p->product_id ?>">
    <input type="hidden" name="product_name" value="<?= $p->product_name ?>">

    <div class="mb-3">
      <label>Nama Produk</label>
      <input type="text" class="form-control" value="<?= $p->product_name ?>" readonly>
    </div>

    <div class="mb-3">
      <label>Nama Pembeli</label>
      <input type="text" name="nama_pembeli" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Alamat</label>
      <textarea name="alamat" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
      <label>Jumlah</label>
      <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
    </div>

    <button type="submit" class="btn btn-success">Checkout Sekarang</button>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>
</body>
</html>
