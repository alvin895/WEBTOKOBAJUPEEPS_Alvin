<?php
include 'db.php';

// ====== HANDLE HAPUS ======
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $id = $_GET['id'];

    mysqli_query($conn, "DELETE FROM alvin_detail_pesanan WHERE id_pesanan = '$id'");
    mysqli_query($conn, "DELETE FROM alvin_pesanan WHERE id_pesanan = '$id'");

    echo "<script>alert('Pesanan dihapus'); window.location='pesanan.php';</script>";
    exit;
}

// ====== HANDLE UPDATE ======
if (isset($_POST['update'])) {
    $id     = $_POST['id_pesanan'];
    $nama   = $_POST['nama'];
    $no_hp  = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $jumlah = $_POST['jumlah'];
    $ukuran = $_POST['ukuran'];
    $warna  = $_POST['warna'];
    $metode = $_POST['metode'];
    $status = $_POST['status'];

    mysqli_query($conn, "UPDATE alvin_pesanan SET 
        nama_pembeli = '$nama',
        no_hp = '$no_hp',
        alamat = '$alamat',
        metode_pembayaran = '$metode',
        status_pesanan = '$status'
        WHERE id_pesanan = '$id'");

    mysqli_query($conn, "UPDATE alvin_detail_pesanan SET 
        quantity = '$jumlah',
        ukuran = '$ukuran',
        warna = '$warna'
        WHERE id_pesanan = '$id'");

    echo "<script>alert('Pesanan diperbarui'); window.location='pesanan.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h3 class="mb-4">📋 Daftar Pesanan Masuk</h3>

    <?php if (isset($_GET['aksi']) && $_GET['aksi'] == 'edit'):
        $id = $_GET['id'];
        $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM alvin_pesanan WHERE id_pesanan = '$id'"));
        $d = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM alvin_detail_pesanan WHERE id_pesanan = '$id'"));
    ?>
        <div class="card mb-4 p-3 shadow">
            <h5>Edit Pesanan</h5>
            <form method="POST">
                <input type="hidden" name="id_pesanan" value="<?= $id ?>">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" value="<?= $p['nama_pembeli'] ?>" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>No HP</label>
                        <input type="text" name="no_hp" value="<?= $p['no_hp'] ?>" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Alamat</label>
                        <input type="text" name="alamat" value="<?= $p['alamat'] ?>" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" value="<?= $d['quantity'] ?>" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Ukuran</label>
                        <input type="text" name="ukuran" value="<?= $d['ukuran'] ?>" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Warna</label>
                        <input type="text" name="warna" value="<?= $d['warna'] ?>" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option <?= $p['status_pesanan']=='Pending'?'selected':'' ?>>Pending</option>
                            <option <?= $p['status_pesanan']=='Diproses'?'selected':'' ?>>Diproses</option>
                            <option <?= $p['status_pesanan']=='Dikirim'?'selected':'' ?>>Dikirim</option>
                            <option <?= $p['status_pesanan']=='Selesai'?'selected':'' ?>>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Metode Pembayaran</label>
                        <select name="metode" class="form-control">
                            <option <?= $p['metode_pembayaran']=='Transfer Bank'?'selected':'' ?>>Transfer Bank</option>
                            <option <?= $p['metode_pembayaran']=='COD (Bayar Ditempat)'?'selected':'' ?>>COD (Bayar Ditempat)</option>
                            <option <?= $p['metode_pembayaran']=='QRIS / E-wallet'?'selected':'' ?>>QRIS / E-wallet</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button name="update" class="btn btn-success me-2">Simpan Perubahan</button>
                        <a href="pesanan.php" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Ukuran</th>
                <th>Warna</th>
                <th>Total</th>
                <th>Bayar</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $query = mysqli_query($conn, "
            SELECT p.id_pesanan, p.nama_pembeli, p.no_hp, p.alamat, p.total_harga, p.metode_pembayaran, p.tanggal_beli, p.status_pesanan,
                   d.quantity, d.ukuran, d.warna,
                   pr.product_name
            FROM alvin_pesanan p
            LEFT JOIN alvin_detail_pesanan d ON p.id_pesanan = d.id_pesanan
            LEFT JOIN alvin_product pr ON d.product_id = pr.product_id
            ORDER BY p.tanggal_beli DESC
        ");
        $no = 1;
        while($row = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_pembeli'] ?></td>
                <td><?= $row['product_name'] ?: '(Promo)' ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['ukuran'] ?></td>
                <td><?= $row['warna'] ?></td>
                <td>Rp<?= number_format($row['total_harga']) ?></td>
                <td><?= $row['metode_pembayaran'] ?></td>
                <td><?= $row['tanggal_beli'] ?></td>
                <td><span class="badge bg-warning"><?= $row['status_pesanan'] ?></span></td>
                <td>
                    <a href="?aksi=edit&id=<?= $row['id_pesanan'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="?aksi=hapus&id=<?= $row['id_pesanan'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus pesanan ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
