<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perhitungan Diskon - Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Sistem Perhitungan Diskon Bertingkat</h1>
        
        <?php
        // Data pembeli dan buku
        $nama_pembeli = "Budi Santoso";
        $judul_buku = "Laravel Advanced";
        $harga_satuan = 150000;
        $jumlah_beli = 4;
        $is_member = true;

        // Hitung subtotal
        $subtotal = $harga_satuan * $jumlah_beli;

        // Tentukan persentase diskon berdasarkan jumlah buku
        if ($jumlah_beli >= 1 && $jumlah_beli <= 2) {
            $persentase_diskon = 0;
        } elseif ($jumlah_beli >= 3 && $jumlah_beli <= 5) {
            $persentase_diskon = 10;
        } elseif ($jumlah_beli >= 6 && $jumlah_beli <= 10) {
            $persentase_diskon = 15;
        } else {
            $persentase_diskon = 20;
        }

        // Hitung diskon
        $diskon = $subtotal * ($persentase_diskon / 100);

        // Total setelah diskon pertama
        $total_setelah_diskon1 = $subtotal - $diskon;

        // Hitung diskon member 5%
        $diskon_member = 0;
        if ($is_member) {
            $diskon_member = $total_setelah_diskon1 * 0.05;
        }

        // Total setelah semua diskon
        $total_setelah_diskon = $total_setelah_diskon1 - $diskon_member;

        // Hitung PPN 11%
        $ppn = $total_setelah_diskon * 0.11;

        // Total akhir
        $total_akhir = $total_setelah_diskon + $ppn;

        // Total penghematan
        $total_hemat = $diskon + $diskon_member;
        ?>

        <!-- Card: Info Pembeli -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <strong>Informasi Pembeli</strong>
                <?php if ($is_member): ?>
                    <span class="badge bg-warning text-dark">MEMBER</span>
                <?php else: ?>
                    <span class="badge bg-secondary">NON-MEMBER</span>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Nama Pembeli:</strong> <?= $nama_pembeli ?></p>
            </div>
        </div>

        <!-- Card: Detail Buku -->
        <div class="card mb-3">
            <div class="card-header bg-secondary text-white">
                <strong>Detail Buku</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Judul Buku</th>
                            <th class="text-end">Harga Satuan</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $judul_buku ?></td>
                            <td class="text-end">Rp <?= number_format($harga_satuan, 0, ',', '.') ?></td>
                            <td class="text-center"><?= $jumlah_beli ?> buku</td>
                            <td class="text-end">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card: Rincian Perhitungan -->
        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                <strong>Rincian Perhitungan</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <tbody>
                        <tr>
                            <td>Subtotal</td>
                            <td class="text-end">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td>
                                Diskon Pembelian
                                <span class="badge bg-danger ms-1"><?= $persentase_diskon ?>%</span>
                            </td>
                            <td class="text-end text-danger">- Rp <?= number_format($diskon, 0, ',', '.') ?></td>
                        </tr>
                        <?php if ($is_member): ?>
                        <tr>
                            <td>
                                Diskon Member
                                <span class="badge bg-warning text-dark ms-1">5%</span>
                            </td>
                            <td class="text-end text-danger">- Rp <?= number_format($diskon_member, 0, ',', '.') ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td>Total Setelah Diskon</td>
                            <td class="text-end">Rp <?= number_format($total_setelah_diskon, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td>PPN <span class="badge bg-secondary ms-1">11%</span></td>
                            <td class="text-end">+ Rp <?= number_format($ppn, 0, ',', '.') ?></td>
                        </tr>
                        <tr class="table-success fw-bold">
                            <td>Total Akhir</td>
                            <td class="text-end">Rp <?= number_format($total_akhir, 0, ',', '.') ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Alert: Total Penghematan -->
        <div class="alert alert-success d-flex justify-content-between">
            <strong>Total Penghematan:</strong>
            <strong>Rp <?= number_format($total_hemat, 0, ',', '.') ?></strong>
        </div>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>