<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Toko Peeps Alvin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand&family=Montserrat:wght@700&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Quicksand', sans-serif;
    }

    body, html {
      height: 100%;
      background: url('img/kadai.jpg') no-repeat center center fixed;
      background-size: cover;
    }

    .login-wrapper {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  /* backdrop-filter: blur(3px); <-- hapus atau komentar baris ini */
  background-color: rgba(7, 27, 91, 0); /* bisa beri opasitas lebih tinggi agar tetap terlihat */
}


    .card {
      width: 350px;
      background-color: rgba(96, 164, 232, 0);
      backdrop-filter: blur(6px);
      border: none;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 12px rgba(0,0,0,0.4);
    }

    .form-control {
      background-color: rgba(255, 255, 255, 0.9);
      border: none;
    }

    .form-control:focus {
      background-color: rgba(255, 255, 255, 1);
      box-shadow: 0 0 0 0.25rem hsl(210, 14.3%, 94.5%);
    }

    .eye-toggle {
      cursor: pointer;
      color: #555;
    }

    .btn-kembali {
      margin-top: 15px;
    }

    .alert {
      font-size: 14px;
    }
  </style>
</head>
<body>

<div class="login-wrapper">
  <div class="card">
    <h3 class="text-black text-center mb-3">Login Admin</h3>
    <form action="" method="POST">
      <div class="mb-3">
        <input type="text" name="user" class="form-control" placeholder="Username" required>
      </div>
      <div class="mb-3 position-relative">
        <input type="password" name="pass" id="pass" class="form-control" placeholder="Password" required>
        <span class="position-absolute top-50 end-0 translate-middle-y me-3 eye-toggle" onclick="togglePassword()">👁</span>
      </div>
      <button type="submit" name="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
      $user = mysqli_real_escape_string($conn, $_POST['user']);
      $pass = mysqli_real_escape_string($conn, $_POST['pass']);

      $cek = mysqli_query($conn, "SELECT * FROM alvin_admin WHERE username = '$user' AND password = '" . MD5($pass) . "'");
      if (mysqli_num_rows($cek) > 0) {
        $d = mysqli_fetch_object($cek);
        $_SESSION['status_login'] = true;
        $_SESSION['a_global'] = $d;
        $_SESSION['id'] = $d->admin_id;
        echo '<script>window.location="adminpeeps/dashboard.php"</script>';
      } else {
        echo '<div class="alert alert-danger mt-3 text-center">Username atau password salah!</div>';
      }
    }
    ?>

    <div class="text-center btn-kembali">
      <a href="index.php" class="btn btn-outline-light w-100">← Kembali ke Halaman Home</a>
    </div>
  </div>
</div>

<script>
function togglePassword() {
  const pass = document.getElementById("pass");
  pass.type = pass.type === "password" ? "text" : "password";
}
</script>

</body>
</html>