<?php
include 'db.php';

// Cek ID Detail
$id_detail = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_detail <= 0) {
    echo "<script>alert('ID tidak valid'); window.location='pesanan.php';</script>";
    exit;
}

// Ambil data detail + pesanan
$detail = mysqli_query($conn, "
    SELECT d.*, p.nama_pembeli, p.metode_pembayaran, p.id_pesanan, pr.product_name
    FROM alvin_detail_pesanan d
    LEFT JOIN alvin_pesanan p ON d.id_pesanan = p.id_pesanan
    LEFT JOIN alvin_product pr ON d.product_id = pr.product_id
    WHERE d.id_detail = $id_detail
");

if (mysqli_num_rows($detail) == 0) {
    echo "<script>alert('Data tidak ditemukan'); window.location='pesanan.php';</script>";
    exit;
}

$data = mysqli_fetch_object($detail);

// Update data jika disubmit
if (isset($_POST['submit'])) {
    $ukuran  = $_POST['ukuran'];
    $warna   = $_POST['warna'];
    $jumlah  = $_POST['jumlah'];
    $metode  = $_POST['metode'];

    // Update detail pesanan
    $update_detail = mysqli_query($conn, "
        UPDATE alvin_detail_pesanan SET
            ukuran = '$ukuran',
            warna = '$warna',
            quantity = '$jumlah'
        WHERE id_detail = $id_detail
    ");

    // Update metode pembayaran (di tabel utama pesanan)
    $update_pesanan = mysqli_query($conn, "
        UPDATE alvin_pesanan SET
            metode_pembayaran = '$metode'
        WHERE id_pesanan = '$data->id_pesanan'
    ");

    if ($update_detail && $update_pesanan) {
        echo "<script>alert('Pesanan berhasil diubah!'); window.location='pesanan.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan perubahan');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('img/tabang.jpg'); /* Ganti nama sesuai file background kamu */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .container {
            background-color: rgba(26, 14, 253, 0.92); /* Semi transparan agar tetap terlihat */
            border-radius: 15px;
            padding: 20px;
            max-width: 600px;
        }

        h3 {
            font-weight: bold;
            text-align: center;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn {
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-light">
<div class="container my-5 shadow">
    <h3>Edit Pesanan: <?= $data->product_name ?></h3>
    <form method="POST">
        <div class="mb-3">
            <label>Ukuran</label>
            <input type="text" name="ukuran" value="<?= $data->ukuran ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Warna</label>
            <input type="text" name="warna" value="<?= $data->warna ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" value="<?= $data->quantity ?>" min="1" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Metode Pembayaran</label>
            <select name="metode" class="form-control" required>
                <option value="Transfer Bank" <?= $data->metode_pembayaran == 'Transfer Bank' ? 'selected' : '' ?>>Transfer Bank</option>
                <option value="COD (Bayar Ditempat)" <?= $data->metode_pembayaran == 'COD (Bayar Ditempat)' ? 'selected' : '' ?>>COD (Bayar Ditempat)</option>
                <option value="QRIS / E-wallet" <?= $data->metode_pembayaran == 'QRIS / E-wallet' ? 'selected' : '' ?>>QRIS / E-wallet</option>
            </select>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="pesanan.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
