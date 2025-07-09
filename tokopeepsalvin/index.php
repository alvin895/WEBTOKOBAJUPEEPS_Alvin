<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Home | Toko Peeps Alvin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Fonts & Bootstrap -->
  <link href="https://fonts.googleapis.com/css2?family=Quicksand&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    * {
      margin: 0; padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }

    .bg-slideshow {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      z-index: -1;
    }

    .bg-slideshow img {
      position: absolute;
      width: 100%; height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }

    .bg-slideshow img.active {
      opacity: 1;
    }

    .navbar {
      background-color: rgba(15, 15, 239, 0.7);
      z-index: 1000;
    }

    .navbar-brand, .nav-link {
      color: white !important;
      font-weight: 600;
    }

    .welcome-title {
      font-size: 2.5rem;
      font-weight: bold;
      color: #ffffff;
      text-shadow: 2px 2px 6px rgba(0,0,0,0.5);
      border-bottom: 3px solid #3d5afe;
      display: inline-block;
      padding-bottom: 10px;
    }

    .welcome-title span {
      color: rgb(21, 0, 255);
      font-style: italic;
    }

    .welcome-sub {
      font-size: 1.5rem;
      color: rgb(14, 33, 243);
      margin-top: 10px;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
    }

    .img-promosi {
      height: 380px;
      object-fit: cover;
      border-radius: 15px;
      border: 4px solid #0f0fec;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .img-promosi:hover {
      transform: scale(1.03);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
    }

    .card-title {
      font-weight: 600;
      color: #0f0fec;
    }

    .card-text {
      font-family: 'Quicksand', sans-serif;
      color: #3d5afe;
    }

    .btn-success {
      background-color: #00c853;
      border: none;
      font-weight: bold;
    }

    .btn-success:hover {
      background-color: #009624;
    }

    footer {
      background-color: rgba(15, 15, 239, 0.8);
      color: white;
      text-align: center;
      padding: 12px 8px;
      font-size: 14px;
      text-shadow: 1px 1px 2px black;
    }

    @media (max-width: 768px) {
      .welcome-title {
        font-size: 1.8rem;
      }

      .welcome-sub {
        font-size: 1.1rem;
      }

      .card-title {
        font-size: 1.1rem;
      }

      .card-text {
        font-size: 0.95rem;
      }

      .btn {
        font-size: 0.9rem;
        padding: 8px 14px;
      }

      .img-promosi {
        height: 240px;
      }
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

<!-- Slideshow Background -->
<div class="bg-slideshow">
  <img src="img/peeps.jpg" class="active">
  <img src="img/kaos.jpg">
  <img src="img/jaket.jpg">
  <img src="img/warna.jpg">
  <img src="img/dob.jpg">
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#"><i class="bi bi-shop"></i> TOKOPEEPSALVIN</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="profil.php"><i class="bi bi-person-circle"></i> Profil</a></li>
        <li class="nav-item"><a class="nav-link" href="#produk"><i class="bi bi-shop-window"></i> Produk</a></li>
        <li class="nav-item"><a class="nav-link" href="pesanan.php"><i class="bi bi-bag-check"></i> Pesanan</a></li>
        <li class="nav-item"><a class="nav-link" href="#kontak"><i class="bi bi-telephone"></i> Kontak</a></li>
        <li class="nav-item"><a class="nav-link text-warning" href="login.php"><i class="bi bi-person-lock"></i> Login Admin</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Konten Utama -->
<main class="flex-grow-1">
  <div class="container text-center pt-5 mt-5 px-3">
    <div class="welcome-box">
      <h2 class="welcome-title">Selamat Datang di <span>Toko Peeps Alvin</span></h2>
      <p class="welcome-sub">Temukan koleksi terbaik kami dan beli sekarang!</p>
    </div>

    <!-- Promosi -->
    <div class="row justify-content-center my-4">
      <?php
      $promo_images = [
        "jaket.jpg" => "Jaket Parasut Bergaya",
        "warna.jpg" => "Warna Cerah, Energi Ceria",
        "kaos.jpg" => "Kaos Nyaman Harian",
        "kaos10.jpg" => "Mari Pilih Kaos PEEPS",
        "kaos11.jpg" => "Mari Pilih Kaos PEEPS",
        "kaos12.jpg" => "Mari Pilih Kaos PEEPS",
        "promo1.jpg" => "PEEPS More Fit Your Style",
        "promo2.jpg" => "PEEPS More Fit Your Style",
        "promo3.jpg" => "PEEPS More Fit Your Style"
      ];
      foreach($promo_images as $img => $title){
      ?>
        <div class="col-md-4 mb-3">
          <div class="card border-0 shadow-sm">
            <img src="img/<?= $img ?>" class="card-img-top img-promosi img-fluid" alt="<?= $title ?>">
            <div class="card-body">
              <h5 class="card-title"><?= $title ?></h5>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>

    <!-- Produk dari Database -->
    <div id="produk" class="my-5 pt-5 mt-5">
      <h3 class="mb-4 title-keren">🛍️ Daftar Produk Terbaru</h3>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <?php
          $produk = mysqli_query($conn, "SELECT * FROM alvin_product WHERE product_status = 1 ORDER BY product_created DESC");
          while($p = mysqli_fetch_array($produk)){
        ?>
        <div class="col">
          <div class="card h-100 border-0 shadow-sm">
            <img src="img/<?php echo $p['product_image'] ?>" class="card-img-top img-promosi img-fluid" alt="<?php echo $p['product_name'] ?>">
            <div class="card-body text-center">
              <h5 class="card-title"><?php echo $p['product_name'] ?></h5>
              <p class="card-text">Rp<?php echo number_format($p['product_price']) ?></p>
              <a href="pesan.php?id=<?php echo $p['product_id'] ?>" class="btn btn-success">Pesan Sekarang</a>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</main>

<!-- Footer -->
<footer id="kontak">
  &copy; 2025 - Toko Peeps Alvin | Hubungi: 0853-8166-4788
</footer>

<!-- Slideshow Script -->
<script>
  const images = document.querySelectorAll('.bg-slideshow img');
  let current = 0;
  setInterval(() => {
    images[current].classList.remove('active');
    current = (current + 1) % images.length;
    images[current].classList.add('active');
  }, 5000);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
