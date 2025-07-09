<?php
session_start();
include '../db.php';

// Cek login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    echo '<script>window.location="../login.php"</script>';
    exit;
}

// Proses simpan produk
if (isset($_POST['submit'])) {
    $kategori_id = mysqli_real_escape_string($conn, $_POST['kategori']);
    $nama        = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga       = mysqli_real_escape_string($conn, $_POST['harga']);
    $deskripsi   = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $status      = 1;

    // Upload gambar
    $gambar      = $_FILES['gambar']['name'];
    $tmp         = $_FILES['gambar']['tmp_name'];
    $ext         = pathinfo($gambar, PATHINFO_EXTENSION);
    $newName     = 'prod_' . time() . '.' . $ext;
    $uploadPath  = '../img/' . $newName;

    // Pastikan folder 'img/' ada
    if (!is_dir('../img')) {
        mkdir('../img', 0777, true);
    }

    if (move_uploaded_file($tmp, $uploadPath)) {
        $insert = mysqli_query($conn, "INSERT INTO alvin_product 
            (category_id, product_name, product_price, product_description, product_image, product_status, product_created)
            VALUES ('$kategori_id', '$nama', '$harga', '$deskripsi', '$newName', '$status', NOW())");

        if ($insert) {
            echo '<script>alert("Produk berhasil ditambahkan!"); window.location="dashboard.php";</script>';
        } else {
            echo '<script>alert("Gagal menyimpan ke database!");</script>';
        }
    } else {
        echo '<script>alert("Upload gambar gagal!");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h3 class="text-center mb-4">Form Tambah Produk</h3>
  <div class="card p-4 shadow">
    <form method="POST" enctype="multipart/form-data">

      <div class="mb-3">
        <label class="form-label">Kategori Produk</label>
        <select name="kategori" class="form-control" required>
          <option value="">-- Pilih Kategori --</option>
          <?php
          $kategori = mysqli_query($conn, "SELECT * FROM alvin_category ORDER BY category_name ASC");
          while ($k = mysqli_fetch_array($kategori)) {
              echo '<option value="'.$k['category_id'].'">'.$k['category_name'].'</option>';
          }
          ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Nama Produk</label>
        <input type="text" name="nama" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Harga Produk (Rp)</label>
        <input type="number" name="harga" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Deskripsi Produk</label>
        <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Gambar Produk</label>
        <input type="file" name="gambar" class="form-control" accept="image/*" required>
        <div class="form-text">Gambar akan disimpan di folder <strong>img/</strong></div>
      </div>

      <button type="submit" name="submit" class="btn btn-primary">Simpan Produk</button>
      <a href="dashboard.php" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>

</body>
</html>
