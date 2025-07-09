<?php
include 'db.php';

// Ambil data pesanan + detail + produk
$query = mysqli_query($conn, "
    SELECT 
        p.id_pesanan, p.nama_pembeli, p.total_harga, p.metode_pembayaran, p.tanggal_beli, p.status_pesanan,
        d.id_detail, d.quantity, d.ukuran, d.warna,
        pr.product_name, pr.product_image
    FROM alvin_pesanan p
    LEFT JOIN alvin_detail_pesanan d ON p.id_pesanan = d.id_pesanan
    LEFT JOIN alvin_product pr ON d.product_id = pr.product_id
    ORDER BY p.tanggal_beli DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pesanan Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('img/kadai.jpg'); /* Ganti sesuai nama file bg */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.2); /* Semi transparan */
            border-radius: 15px;
            padding: 20px;
        }

        img.thumbnail {
            width: 80px;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
            background-color:rgba(10, 26, 194, 0.53);
            padding: 5px;
            border: 1px solid #ccc;
        }

        h3 {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <h3 class="mb-4 text-center">🛒 Riwayat Pesanan Anda</h3>

    <?php if (mysqli_num_rows($query) > 0): ?>
    <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Nama Pembeli</th>
                <th>Gambar</th>
                <th>Jumlah</th>
                <th>Ukuran</th>
                <th>Warna</th>
                <th>Total</th>
                <th>Pembayaran</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= $row['product_name'] ?: '(Produk Promo)' ?></td>
                <td class="text-center"><?= $row['nama_pembeli'] ?></td>
                <td class="text-center">
                    <?php if (!empty($row['product_image'])): ?>
                        <img src="img/<?= $row['product_image'] ?>" alt="Produk" class="thumbnail">
                    <?php else: ?>
                        <span class="text-muted">-</span>
                    <?php endif; ?>
                </td>
                <td class="text-center"><?= $row['quantity'] ?: '-' ?></td>
                <td class="text-center"><?= $row['ukuran'] ?: '-' ?></td>
                <td class="text-center"><?= $row['warna'] ?: '-' ?></td>
                <td>Rp<?= number_format($row['total_harga']) ?></td>
                <td><?= $row['metode_pembayaran'] ?></td>
                <td><?= $row['tanggal_beli'] ?></td>
                <td class="text-center">
                    <span class="badge bg-warning text-dark"><?= $row['status_pesanan'] ?></span>
                </td>
                <td class="text-center">
                    <a href="edit-pesanan.php?id=<?= $row['id_detail'] ?>" class="btn btn-sm btn-primary">Edit</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
    <?php else: ?>
        <div class="alert alert-info text-center">Belum ada pesanan.</div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-secondary">← Kembali ke Home</a>
    </div>
</div>
</body>
</html>
