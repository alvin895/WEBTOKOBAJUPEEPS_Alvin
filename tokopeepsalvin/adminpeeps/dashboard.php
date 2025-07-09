<?php
session_start();
include '../db.php';

// Cek login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    echo '<script>window.location="../login.php"</script>';
    exit;
}

// Ambil data admin
$admin = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM alvin_admin WHERE admin_id = '" . $_SESSION['id'] . "'"));

// Hitung jumlah pesanan
$jml_pesanan = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM alvin_pesanan"));

// ========== HANDLE TAMBAH PRODUK ==========
if (isset($_POST['submit'])) {
    $kategori_id = mysqli_real_escape_string($conn, $_POST['kategori']);
    $nama        = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga       = mysqli_real_escape_string($conn, $_POST['harga']);
    $deskripsi   = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $status      = 1;

    $gambar      = $_FILES['gambar']['name'];
    $tmp         = $_FILES['gambar']['tmp_name'];

    $ext = pathinfo($gambar, PATHINFO_EXTENSION);
    $newName = 'prod_' . time() . '.' . $ext;
    $uploadPath = '../img/' . $newName;

    if (!file_exists('../img')) {
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

// ========== HANDLE EDIT PRODUK ==========
$edit_produk = null;
if (isset($_GET['edit_produk'])) {
    $id = $_GET['edit_produk'];
    $edit_produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM alvin_product WHERE product_id = '$id'"));
}

// ========== HANDLE UPDATE PRODUK ==========
if (isset($_POST['update_produk'])) {
    $id         = $_POST['id_produk'];
    $kategori   = $_POST['kategori'];
    $nama       = $_POST['nama'];
    $harga      = $_POST['harga'];
    $deskripsi  = $_POST['deskripsi'];
    $status     = 1;

    if ($_FILES['gambar']['name'] != '') {
        $gambar = $_FILES['gambar']['name'];
        $tmp    = $_FILES['gambar']['tmp_name'];
        $ext    = pathinfo($gambar, PATHINFO_EXTENSION);
        $newName = 'prod_' . time() . '.' . $ext;
        $uploadPath = '../img/' . $newName;

        if (move_uploaded_file($tmp, $uploadPath)) {
            $old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM alvin_product WHERE product_id = '$id'"));
            if ($old && file_exists('../img/' . $old['product_image'])) {
                unlink('../img/' . $old['product_image']);
            }
            $gambar_update = ", product_image = '$newName'";
        } else {
            echo "<script>alert('Gagal upload gambar baru!');</script>";
            $gambar_update = "";
        }
    } else {
        $gambar_update = "";
    }

    mysqli_query($conn, "UPDATE alvin_product SET 
        category_id = '$kategori',
        product_name = '$nama',
        product_price = '$harga',
        product_description = '$deskripsi',
        product_status = '$status'
        $gambar_update
        WHERE product_id = '$id'");

    echo "<script>alert('Produk diperbarui!'); window.location='dashboard.php';</script>";
    exit;
}

// ========== HANDLE HAPUS PRODUK ==========
if (isset($_GET['hapus_produk'])) {
    $id = $_GET['hapus_produk'];
    $produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM alvin_product WHERE product_id = '$id'"));
    if ($produk && file_exists('../img/' . $produk['product_image'])) {
        unlink('../img/' . $produk['product_image']);
    }
    mysqli_query($conn, "DELETE FROM alvin_product WHERE product_id = '$id'");
    echo "<script>alert('Produk dihapus!'); window.location='dashboard.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.6)), url('../img/metro.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      font-family: 'Segoe UI', sans-serif;
      color: #fff;
      min-height: 100vh;
    }
    .card {
      border-radius: 15px;
      background: #fff;
      color: #333;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }
    .form-popup, .pesanan-form {
      display: none;
      background: #fff;
      color: #000;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Selamat datang, <?= $admin->admin_name ?></h2>
    <a href="logout.php" class="btn btn-outline-light">Logout</a>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-md-4">
      <div class="card text-center p-4 h-100">
        <i class="bi bi-plus-square-fill"></i>
        <h5 class="card-title mt-3">Tambah Produk</h5>
        <p>Masukkan produk baru agar muncul di halaman home.</p>
        <button onclick="document.getElementById('formProduk').style.display='block'" class="btn btn-sm btn-primary mt-2">Form Tambah</button>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center p-4 h-100">
        <i class="bi bi-bag-check-fill"></i>
        <h5 class="card-title mt-3">Total Pesanan</h5>
        <h3><?= $jml_pesanan ?></h3>
        <button onclick="showPesanan()" class="btn btn-sm btn-primary mt-2">Lihat Pesanan</button>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center p-4 h-100">
        <i class="bi bi-person-badge-fill"></i>
        <h5 class="card-title mt-3">Data Admin</h5>
        <p><?= $admin->username ?></p>
        <p><?= $admin->admin_email ?></p>
        <a href="profil.php" class="btn btn-sm btn-primary">Lihat Profil</a>
      </div>
    </div>
  </div>

  <!-- Form Tambah/Edit Produk -->
  <div id="formProduk" class="form-popup mt-4" style="display: <?= $edit_produk ? 'block' : 'none' ?>">
    <h4><?= $edit_produk ? 'Edit Produk' : 'Form Tambah Produk' ?></h4>
    <form method="POST" enctype="multipart/form-data">
      <?php if ($edit_produk): ?>
        <input type="hidden" name="id_produk" value="<?= $edit_produk['product_id'] ?>">
      <?php endif; ?>
      <div class="row">
        <div class="col-md-12 mb-3">
          <label>Kategori Produk</label>
          <select name="kategori" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            <?php
            $kategori = mysqli_query($conn, "SELECT * FROM alvin_category ORDER BY category_name ASC");
            while ($k = mysqli_fetch_array($kategori)) {
              $selected = ($edit_produk && $edit_produk['category_id'] == $k['category_id']) ? 'selected' : '';
              echo "<option value='$k[category_id]' $selected>$k[category_name]</option>";
            }
            ?>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label>Nama Produk</label>
          <input type="text" name="nama" value="<?= $edit_produk['product_name'] ?? '' ?>" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label>Harga Produk</label>
          <input type="number" name="harga" value="<?= $edit_produk['product_price'] ?? '' ?>" class="form-control" required>
        </div>
        <div class="col-md-12 mb-3">
          <label>Deskripsi Produk</label>
          <textarea name="deskripsi" class="form-control" required><?= $edit_produk['product_description'] ?? '' ?></textarea>
        </div>
        <div class="col-md-12 mb-3">
          <label>Gambar Produk <?= $edit_produk ? '(kosongkan jika tidak diubah)' : '' ?></label>
          <input type="file" name="gambar" class="form-control" accept="image/*" <?= $edit_produk ? '' : 'required' ?>>
        </div>
        <div class="col-md-12">
          <button type="submit" name="<?= $edit_produk ? 'update_produk' : 'submit' ?>" class="btn btn-success">
            <?= $edit_produk ? 'Update Produk' : 'Simpan' ?>
          </button>
          <a href="dashboard.php" class="btn btn-danger">Batal</a>
        </div>
      </div>
    </form>
  </div>

  <!-- Tabel Produk -->
  <div class="card mt-5 p-3">
    <h4>Daftar Produk</h4>
    <table class="table table-bordered table-striped table-hover mt-3 bg-white">
      <thead class="table-primary">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Harga</th>
          <th>Kategori</th>
          <th>Gambar</th>
          <th>Dibuat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $produk = mysqli_query($conn, "
            SELECT p.*, c.category_name 
            FROM alvin_product p 
            LEFT JOIN alvin_category c ON p.category_id = c.category_id 
            ORDER BY p.product_created DESC
        ");
        $no = 1;
        while ($row = mysqli_fetch_array($produk)) {
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $row['product_name'] ?></td>
          <td>Rp<?= number_format($row['product_price']) ?></td>
          <td><?= $row['category_name'] ?></td>
          <td><img src="../img/<?= $row['product_image'] ?>" width="60"></td>
          <td><?= $row['product_created'] ?></td>
          <td>
            <a href="dashboard.php?edit_produk=<?= $row['product_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="dashboard.php?hapus_produk=<?= $row['product_id'] ?>" onclick="return confirm('Hapus produk ini?')" class="btn btn-sm btn-danger">Hapus</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <!-- Tabel Pesanan -->
  <div id="pesananForm" class="pesanan-form mt-5">
    <h4>Detail Pesanan</h4>
    <table class="table table-bordered table-striped mt-3">
      <thead class="table-primary">
        <tr>
          <th>No</th>
          <th>Nama Pembeli</th>
          <th>Produk</th>
          <th>Jumlah</th>
          <th>Total</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $pesanan = mysqli_query($conn, "
          SELECT 
            p.nama_pembeli, p.total_harga, p.tanggal_beli,
            d.quantity, pr.product_name
          FROM alvin_pesanan p
          LEFT JOIN alvin_detail_pesanan d ON p.id_pesanan = d.id_pesanan
          LEFT JOIN alvin_product pr ON d.product_id = pr.product_id
          ORDER BY p.id_pesanan DESC
        ");
        $no = 1;
        while ($row = mysqli_fetch_array($pesanan)) {
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $row['nama_pembeli'] ?></td>
          <td><?= $row['product_name'] ?? '-' ?></td>
          <td><?= $row['quantity'] ?? '-' ?></td>
          <td>Rp<?= number_format($row['total_harga']) ?></td>
          <td><?= $row['tanggal_beli'] ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <button class="btn btn-danger mt-3" onclick="document.getElementById('pesananForm').style.display='none'">Tutup</button>
  </div>

  <div class="text-center mt-5 text-white">
    <p>&copy; <?= date('Y') ?> Toko Peeps Alvin | Dashboard</p>
  </div>
</div>

<script>
  function showPesanan() {
    const form = document.getElementById('pesananForm');
    form.style.display = 'block';
    setTimeout(() => {
      form.scrollIntoView({ behavior: 'smooth' });
    }, 100);
  }
</script>
</body>
</html>
