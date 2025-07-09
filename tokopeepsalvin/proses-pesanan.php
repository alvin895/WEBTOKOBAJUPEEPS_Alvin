<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_pembeli'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $metode = $_POST['metode_pembayaran'];
    $tanggal = $_POST['tanggal_beli'];
    
    $product_id = $_POST['product_id'] ?? null;
    $ukuran = $_POST['ukuran'];
    $warna = $_POST['warna'];
    $harga = $_POST['harga'];
    $jumlah = 1; // default jumlah 1
    $total = $harga * $jumlah;

    // Simpan ke alvin_pesanan
    $insert_pesanan = mysqli_query($conn, "INSERT INTO alvin_pesanan (
        nama_pembeli, no_hp, alamat, metode_pembayaran, tanggal_beli
    ) VALUES (
        '$nama', '$no_hp', '$alamat', '$metode', '$tanggal'
    )");

    if ($insert_pesanan) {
        $id_pesanan = mysqli_insert_id($conn);

        // Simpan ke alvin_detail_pesanan jika produk valid
        if ($product_id !== null) {
            $insert_detail = mysqli_query($conn, "INSERT INTO alvin_detail_pesanan (
                id_pesanan, product_id, ukuran, warna, jumlah, total_harga
            ) VALUES (
                '$id_pesanan', '$product_id', '$ukuran', '$warna', '$jumlah', '$total'
            )");
        }

        echo "<script>alert('Pesanan berhasil dikirim!'); window.location='pesanan.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan pesanan.'); window.history.back();</script>";
    }
} else {
    header('Location: home.php');
    exit;
}
?>