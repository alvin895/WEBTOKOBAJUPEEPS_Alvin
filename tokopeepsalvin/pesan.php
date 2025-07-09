<?php
include 'db.php';

$product_id = isset($_GET['id']) ? $_GET['id'] : null;
$nama_url   = isset($_GET['nama']) ? urldecode($_GET['nama']) : null;

if ($product_id) {
    // Produk dari database
    $produk = mysqli_query($conn, "SELECT * FROM alvin_product WHERE product_id = '$product_id'");
    $p = mysqli_fetch_object($produk);

    // Gunakan default jika tidak tersedia
    if (empty($p->product_size)) $p->product_size = 'M,L,XL';
    if (empty($p->product_color)) $p->product_color = 'Hitam,Putih,Coklat,Sage,Army';

} elseif ($nama_url) {
    // Produk promo manual
    $p = (object)[
        'product_name' => $nama_url,
        'product_price' => isset($_GET['harga']) ? $_GET['harga'] : 0,
        'product_size'  => isset($_GET['ukuran']) ? $_GET['ukuran'] : 'M,L,XL',
        'product_color' => isset($_GET['warna']) ? $_GET['warna'] : 'Putih,Hitam,Abu'
    ];
    $product_id = 0; // produk promo tidak ada di database
} else {
    echo "<script>alert('Produk tidak ditemukan'); window.location='home.php';</script>";
    exit;
}

if (isset($_POST['submit'])) {
    $nama   = $_POST['nama'];
    $nohp   = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $ukuran = $_POST['ukuran'];
    $warna  = $_POST['warna'];
    $jumlah = $_POST['jumlah'];
    $metode = $_POST['metode'];
    $tanggal = date('Y-m-d');
    $status = 'Pending';

    $total = $p->product_price * $jumlah;

    // Simpan ke alvin_pesanan
    $simpanPesanan = mysqli_query($conn, "INSERT INTO alvin_pesanan SET
        nama_pembeli = '$nama',
        no_hp = '$nohp',
        alamat = '$alamat',
        total_harga = '$total',
        metode_pembayaran = '$metode',
        tanggal_beli = '$tanggal',
        status_pesanan = '$status'
    ");

    $last_id = mysqli_insert_id($conn);

    // Hanya simpan ke alvin_detail_pesanan jika product_id valid
    if ($product_id != 0) {
        mysqli_query($conn, "INSERT INTO alvin_detail_pesanan SET
            id_pesanan = '$last_id',
            product_id = '$product_id',
            quantity = '$jumlah',
            ukuran = '$ukuran',
            warna = '$warna'
        ");
    }

    echo "<script>alert('Pesanan berhasil!'); window.location='pesanan.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Pemesanan Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card p-4 shadow">
        <h3>Form Pemesanan Produk</h3>
        <form method="POST">
            <div class="mb-2"><strong>Produk:</strong> <?= $p->product_name ?> (Rp<?= number_format($p->product_price) ?>)</div>
            <div class="mb-3">
                <label>Nama Pembeli</label>
                <input type="text" name="nama" required class="form-control">
            </div>
            <div class="mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" required class="form-control">
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" required class="form-control"></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Ukuran</label>
                    <select name="ukuran" class="form-control" required>
                        <?php
                        $ukuran_list = explode(',', $p->product_size);
                        foreach($ukuran_list as $u){
                            echo "<option value='".trim($u)."'>".trim($u)."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Warna</label>
                    <select name="warna" class="form-control" required>
                        <?php
                        $warna_list = explode(',', $p->product_color);
                        foreach($warna_list as $w){
                            echo "<option value='".trim($w)."'>".trim($w)."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="jumlah" value="1" min="1" required class="form-control">
            </div>
            <div class="mb-3">
                <label>Metode Pembayaran</label>
                <select name="metode" class="form-control" required>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="COD (Bayar Ditempat)">COD (Bayar Ditempat)</option>
                    <option value="QRIS / E-wallet">QRIS / E-wallet</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-success">Kirim Pesanan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
</body>
</html>
