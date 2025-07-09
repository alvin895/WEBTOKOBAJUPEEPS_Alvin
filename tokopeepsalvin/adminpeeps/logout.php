<?php
session_start();
session_destroy(); // Hapus semua session
echo '<script>alert("Berhasil logout"); window.location="../login.php";</script>';
exit;
?>
