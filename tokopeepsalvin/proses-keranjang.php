<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $id_produk = $_POST['id_produk'];
    $nama_pembeli = $_POST['nama_pembeli'];
    $alamat = $_POST['alamat'];
    $ukuran = $_POST['ukuran'];
    $jumlah = $_POST['jumlah'];

    $insert = mysqli_query($conn, "INSERT INTO alvin_keranjang 
        (id_produk, nama_pembeli, alamat, ukuran, jumlah)
        VALUES ('$id_produk', '$nama_pembeli', '$alamat', '$ukuran', '$jumlah')");

    if($insert){
        echo "<script>alert('Berhasil dimasukkan ke keranjang');window.location='keranjang.php';</script>";
    } else {
        echo "<script>alert('Gagal');history.back();</script>";
    }
}
?>
