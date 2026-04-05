<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-size: 1.12rem;
        }

        h1 {
            font-size: 2.1rem;
            font-weight: 700;
        }

        .card-header,
        .alert,
        .badge {
            font-size: 1.1rem;
        }

        .card-body p {
            font-size: 1.08rem;
        }

        .badge-bronze {
            background-color: #cd7f32;
            color: #ffffff;
        }

        .badge-silver {
            background-color: #c0c0c0;
            color: #1f2937;
        }

        .badge-gold {
            background-color: #ffd700;
            color: #1f2937;
        }

        .bi {
            font-size: 1.45rem;
            vertical-align: -0.12em;
        }

        @media (max-width: 576px) {
            body {
                font-size: 1.02rem;
            }

            h1 {
                font-size: 1.65rem;
            }

            .bi {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body class="bg-light">
    <?php
    // Data anggota dan transaksi
    $nama_anggota = "Budi Santoso";
    $pinjaman_saat_ini = 2;
    $total_pinjaman = 16; // Total riwayat peminjaman untuk level member
    $buku_terlambat = 0;
    $hari_keterlambatan = 0;

    // Aturan bisnis
    $maksimal_pinjaman = 3;
    $tarif_denda_harian = 1000;
    $maksimal_denda = 50000;

    // IF-ELSEIF-ELSE: cek apakah member bisa meminjam lagi
    if ($buku_terlambat > 0) {
        $status_pinjaman = "Tidak bisa pinjam lagi karena masih ada buku terlambat.";
        $status_class = "danger";
    } elseif ($pinjaman_saat_ini >= $maksimal_pinjaman) {
        $status_pinjaman = "Tidak bisa pinjam lagi karena sudah mencapai batas maksimal 3 buku.";
        $status_class = "warning";
    } else {
        $sisa_kuota = $maksimal_pinjaman - $pinjaman_saat_ini;
        $status_pinjaman = "Bisa pinjam lagi. Sisa kuota: {$sisa_kuota} buku.";
        $status_class = "success";
    }

    // IF-ELSEIF-ELSE: hitung total denda
    $estimasi_denda = $buku_terlambat * $hari_keterlambatan * $tarif_denda_harian;
    if ($buku_terlambat <= 0 || $hari_keterlambatan <= 0) {
        $total_denda = 0;
        $keterangan_denda = "Tidak ada denda.";
    } elseif ($estimasi_denda > $maksimal_denda) {
        $total_denda = $maksimal_denda;
        $keterangan_denda = "Denda mencapai batas maksimal Rp " . number_format($maksimal_denda, 0, ",", ".") . ".";
    } else {
        $total_denda = $estimasi_denda;
        $keterangan_denda = "Denda dihitung Rp 1.000 x {$hari_keterlambatan} hari x {$buku_terlambat} buku.";
    }

    // IF-ELSEIF-ELSE: tampilkan peringatan keterlambatan
    if ($buku_terlambat > 0 && $hari_keterlambatan > 0) {
        $peringatan = "Perhatian: Anda memiliki {$buku_terlambat} buku terlambat selama {$hari_keterlambatan} hari.";
        $peringatan_class = "warning";
    } elseif ($buku_terlambat > 0 && $hari_keterlambatan <= 0) {
        $peringatan = "Ada data buku terlambat, tetapi belum ada hari keterlambatan.";
        $peringatan_class = "secondary";
    } else {
        $peringatan = "Tidak ada keterlambatan. Anda dapat menjaga status pinjaman tetap baik.";
        $peringatan_class = "success";
    }

    // SWITCH: level member berdasarkan total_pinjaman
    switch (true) {
        case ($total_pinjaman >= 0 && $total_pinjaman <= 5):
            $level_member = "Bronze";
            $level_member_class = "badge-bronze";
            break;
        case ($total_pinjaman >= 6 && $total_pinjaman <= 15):
            $level_member = "Silver";
            $level_member_class = "badge-silver";
            break;
        default:
            $level_member = "Gold";
            $level_member_class = "badge-gold";
            break;
    }
    ?>

    <div class="container py-5">
        <h1 class="mb-4">Status Peminjaman Anggota</h1>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-person-badge me-2"></i> Informasi Anggota
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Nama:</strong> <?php echo $nama_anggota; ?></p>
                <p class="mb-2"><strong>Pinjaman Saat Ini:</strong> <?php echo $pinjaman_saat_ini; ?> buku</p>
                <p class="mb-2"><strong>Total Peminjaman:</strong> <?php echo $total_pinjaman; ?> kali</p>
                <p class="mb-2"><strong>Buku Terlambat:</strong> <?php echo $buku_terlambat; ?> buku</p>
                <p class="mb-2"><strong>Hari Keterlambatan:</strong> <?php echo $hari_keterlambatan; ?> hari</p>
                <p class="mb-0"><strong>Level Member:</strong> <span class="badge <?php echo $level_member_class; ?>"><?php echo $level_member; ?></span></p>
            </div>
        </div>

        <div class="alert alert-<?php echo $status_class; ?>" role="alert">
            <strong>Status Peminjaman Saat Ini:</strong> <?php echo $status_pinjaman; ?>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-warning-subtle">
                <i class="bi bi-cash-stack me-2"></i> Informasi Denda
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Total Denda:</strong> Rp <?php echo number_format($total_denda, 0, ",", "."); ?></p>
                <p class="mb-0 text-muted"><?php echo $keterangan_denda; ?></p>
            </div>
        </div>

        <div class="alert alert-<?php echo $peringatan_class; ?> mb-0" role="alert">
            <strong>Peringatan:</strong> <?php echo $peringatan; ?>
        </div>
    </div>
</body>
</html>