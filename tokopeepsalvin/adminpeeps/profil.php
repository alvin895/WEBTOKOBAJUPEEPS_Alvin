<?php
include '../db.php';

// Ambil data admin
$query = mysqli_query($conn, "SELECT * FROM alvin_admin WHERE admin_id = 1");
$data = mysqli_fetch_assoc($query);
if (!$data) {
    die("Data admin tidak ditemukan.");
}

// Ambil jumlah pesanan
$pesanan_query = mysqli_query($conn, "SELECT COUNT(*) AS total_pesanan FROM alvin_pesanan");
$pesanan_data = mysqli_fetch_assoc($pesanan_query);
$total_pesanan = $pesanan_data['total_pesanan'] ?? 0;

// Ambil total uang masuk
$uang_query = mysqli_query($conn, "SELECT SUM(total_harga) AS total_uang FROM alvin_pesanan");
$uang_data = mysqli_fetch_assoc($uang_query);
$total_uang = $uang_data['total_uang'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Profil Admin | Toko Peeps Alvin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      background: url('../img/metro.jpg');
      background-size: cover;
      background-attachment: fixed;
      background-position: center;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card-profile {
      width: 100%;
      max-width: 580px;
      background: rgba(1, 4, 11, 0.43);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 2rem;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }
    .profile-image {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      overflow: hidden;
      border: 5px solid #1877f2;
      box-shadow: 0 2px 10px rgba(242, 78, 24, 0.62);
    }
    .profile-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .profile-name {
      font-size: 2rem;
      font-weight: 700;
      color: #ffffff;
    }
    .profile-username {
      color: #ffffff;
      font-weight: 500;
      margin-bottom: 1rem;
    }
    .stats {
      display: flex;
      gap: 2rem;
      margin-top: 1rem;
      flex-wrap: wrap;
    }
    .stat {
      text-align: center;
      flex: 1;
    }
    .stat-number {
      font-weight: 700;
      font-size: 1.6rem;
      color: greenyellow;
    }
    .stat-label {
      font-size: 0.9rem;
      color: #ffffff;
    }
    .profile-details p {
      margin-bottom: 0.6rem;
      color: #ffffff;
    }
    .btn-back {
      display: inline-block;
      margin-top: 2rem;
      color: #00c0ff;
      text-decoration: none;
      font-weight: 600;
    }
    .btn-back:hover {
      color: #69e3ff;
    }
  </style>
</head>
<body>

<div class="card-profile">
  <div class="d-flex flex-wrap align-items-center gap-4">
    <div class="profile-image">
      <img src="../img/vins.jpg" alt="Foto Profil" />
    </div>
    <div>
      <div class="profile-name">ALVIN SATRIA GHAZA</div>
      <div class="profile-username">@<?= htmlspecialchars($data['username']) ?></div>
      <div class="stats">
        <div class="stat">
          <div class="stat-number"><?= $total_pesanan ?></div>
          <div class="stat-label">Pesanan</div>
        </div>
        <div class="stat">
          <div class="stat-number">Rp<?= number_format($total_uang, 0, ',', '.') ?></div>
          <div class="stat-label">Uang Masuk</div>
        </div>
      </div>
    </div>
  </div>

  <hr class="my-4" />

  <div class="profile-details">
    <p><strong>Email:</strong> <?= htmlspecialchars($data['admin_email']) ?></p>
    <p><strong>No HP:</strong> <?= htmlspecialchars($data['admin_telp']) ?></p>
    <p><strong>Alamat:</strong><br><?= nl2br(htmlspecialchars($data['admin_address'])) ?></p>
  </div>

  <a href="dashboard.php" class="btn-back"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
