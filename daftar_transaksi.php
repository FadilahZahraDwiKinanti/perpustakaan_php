<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Transaksi Peminjaman</h1>
        
        <?php
        // TODO: Hitung statistik dengan loop
        $total_transaksi = 0;
        $total_dipinjam = 0;
        $total_dikembalikan = 0;
        
        // TODO: Loop pertama untuk hitung statistik
        for ($i = 1; $i <= 10; $i++) {
            if ($i == 8) {
                break;
            }

            if ($i % 2 == 0) {
                continue;
            }

            $status = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";

            $total_transaksi++;

            if ($status === "Dikembalikan") {
                $total_dikembalikan++;
            } else {
                $total_dipinjam++;
            }
        }
        ?>
        
        <!-- TODO: Tampilkan statistik dalam cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total transaksi yang ditampilkan</h5>
                        <p class="h3 mb-0 text-primary"><?php echo $total_transaksi; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah masih dipinjam</h5>
                        <p class="h3 mb-0 text-warning"><?php echo $total_dipinjam; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah sudah dikembalikan</h5>
                        <p class="h3 mb-0 text-success"><?php echo $total_dikembalikan; ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- TODO: Tampilkan tabel transaksi -->
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Hari</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // TODO: Loop untuk tampilkan data
                // Gunakan continue untuk skip genap
                // Gunakan break untuk stop di transaksi 8
                $no = 1;
                for ($i = 1; $i <= 10; $i++) {
                    if ($i == 8) {
                        break;
                    }

                    if ($i % 2 == 0) {
                        continue;
                    }

                    // Generate data transaksi
                    $id_transaksi = "TRX-" . str_pad($i, 4, "0", STR_PAD_LEFT);
                    $nama_peminjam = "Anggota " . $i;
                    $judul_buku = "Buku Teknologi Vol. " . $i;
                    $tanggal_pinjam = date('Y-m-d', strtotime("-$i days"));
                    $tanggal_kembali = date('Y-m-d', strtotime("+7 days", strtotime($tanggal_pinjam)));
                    $status = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";

                    $hari = (new DateTime())->diff(new DateTime($tanggal_pinjam))->days;
                    $badge_status = ($status === "Dikembalikan") ? "bg-success" : "bg-warning text-dark";
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $id_transaksi; ?></td>
                    <td><?php echo $nama_peminjam; ?></td>
                    <td><?php echo $judul_buku; ?></td>
                    <td><?php echo $tanggal_pinjam; ?></td>
                    <td><?php echo $tanggal_kembali; ?></td>
                    <td><?php echo $hari; ?> hari</td>
                    <td><span class="badge <?php echo $badge_status; ?>"><?php echo $status; ?></span></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>