<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content ="width=device-width, initial-scale=1.0">
    <title>Info Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Informasi Buku</h1>
        
        <?php
        // Data buku 1
        $judul1 = "Laravel: From Beginner to Advanced";
        $kategori1 = "Pemrograman";
        $pengarang1 = "Budi Raharjo";
        $penerbit1 = "Informatika";
        $tahun_terbit1 = 2023;
        $harga1 = 1250000;
        $stok1 = 8;
        $isbn1 = "978-602-1234-56-7";
        $bahasa1 = "Indonesia";
        $jumlah_halaman1 = 450;
        $berat1 = 800; // dalam gram

        // Data buku 2
        $judul2 = "Web Design with HTML and CSS";
        $kategori2 = "Desain Web";
        $pengarang2 = "Riyadi Santoso";
        $penerbit2 = "Penerbit Indonesia";
        $tahun_terbit2 = 2022;
        $harga2 = 950000;
        $stok2 = 15;
        $isbn2 = "978-602-1234-57-4";
        $bahasa2 = "Indonesia";
        $jumlah_halaman2 = 380;
        $berat2 = 700; // dalam gram


        // Data buku 3
        $judul3 = "Database Management with MySQL";
        $kategori3 = "Database";
        $pengarang3 = "Siti Elizabeth";
        $penerbit3 = "Tech Books";
        $tahun_terbit3 = 2023;
        $harga3 = 1100000;
        $stok3 = 12;
        $isbn3 = "978-602-1234-58-1";
        $bahasa3 = "Indonesia";
        $jumlah_halaman3 = 420;
        $berat3 = 900; // dalam gram

        // Data buku 4
        $judul4 = "Python Programming for Absolute Beginners";
        $kategori4 = "Pemrograman";
        $pengarang4 = "Slamet Michael";
        $penerbit4 = "Programming Press";
        $tahun_terbit4 = 2023;
        $harga4 = 1000000;
        $stok4 = 10;
        $isbn4 = "978-602-1234-59-8";
        $bahasa4 = "Indonesia";
        $jumlah_halaman4 = 350;
        $berat4 = 600; // dalam gram

        ?>
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <?php echo $judul1; ?>
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Pengarang</th>
                        <td><?php echo $pengarang1; ?></td>
                    </tr>
                    <tr>
                        <th>Penerbit</th>
                        <td><?php echo $penerbit1; ?></td>
                    </tr>
                    <tr>
                        <th>Tahun Terbit</th>
                        <td><?php echo $tahun_terbit1; ?></td>
                    </tr>
                    <tr>
                        <th>ISBN</th>
                        <td><?php echo $isbn1; ?></td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>Rp <?php echo number_format($harga1, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td><?php echo $stok1; ?> buku</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>: <span class="badge bg-primary"><?php echo $kategori1; ?></span></td>
                    </tr>
                    <tr>
                        <th>Bahasa</th>
                        <td><?php echo $bahasa1; ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Halaman</th>
                        <td><?php echo $jumlah_halaman1; ?></td>
                    </tr>
                    <tr>
                        <th>Berat</th>
                        <td><?php echo $berat1; ?> gram</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">
                    <?php echo $judul2; ?>
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Pengarang</th>
                        <td><?php echo $pengarang2; ?></td>
                    </tr>
                    <tr>
                        <th>Penerbit</th>
                        <td><?php echo $penerbit2; ?></td>
                    </tr>
                    <tr>
                        <th>Tahun Terbit</th>
                        <td><?php echo $tahun_terbit2; ?></td>
                    </tr>
                    <tr>
                        <th>ISBN</th>
                        <td><?php echo $isbn2; ?></td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>Rp <?php echo number_format($harga2, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td><?php echo $stok2; ?> buku</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>: <span class="badge bg-warning"><?php echo $kategori2; ?></span></td>
                    </tr>
                    <tr>
                        <th>Jumlah Halaman</th>
                        <td><?php echo $jumlah_halaman2; ?></td>
                    </tr>
                    <tr>
                        <th>Berat</th>
                        <td><?php echo $berat2; ?> gram</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><?php echo $judul3; ?></h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Pengarang</th>
                        <td><?php echo $pengarang3; ?></td>
                    </tr>
                    <tr>
                        <th>Penerbit</th>
                        <td><?php echo $penerbit3; ?></td>
                    </tr>
                    <tr>
                        <th>Tahun Terbit</th>
                        <td><?php echo $tahun_terbit3; ?></td>
                    </tr>
                    <tr>
                        <th>ISBN</th>
                        <td><?php echo $isbn3; ?></td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>Rp <?php echo number_format($harga3, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td><?php echo $stok3; ?> buku</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>: <span class="badge bg-success"><?php echo $kategori3; ?></span></td>
                    </tr>
                    <tr>
                        <th>Jumlah Halaman</th>
                        <td><?php echo $jumlah_halaman3; ?></td>
                    </tr>
                    <tr>
                        <th>Berat</th>
                        <td><?php echo $berat3; ?> gram</td>
                    </tr>
                </table>
            </div>
        </div>
  

        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><?php echo $judul4; ?></h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Pengarang</th>
                        <td><?php echo $pengarang4; ?></td>
                    </tr>
                    <tr>
                        <th>Penerbit</th>
                        <td><?php echo $penerbit4; ?></td>
                    </tr>
                    <tr>
                        <th>Tahun Terbit</th>
                        <td><?php echo $tahun_terbit4; ?></td>
                    </tr>
                    <tr>
                        <th>ISBN</th>
                        <td><?php echo $isbn4; ?></td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>Rp <?php echo number_format($harga4, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td><?php echo $stok4; ?> buku</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td> <span class="badge bg-primary"><?php echo $kategori4; ?></span></td>
                    </tr>
                    <tr>
                        <th>Bahasa</th>
                        <td><?php echo $bahasa4; ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Halaman</th>
                        <td><?php echo $jumlah_halaman4; ?></td>
                    </tr>
                    <tr>
                        <th>Berat</th>
                        <td><?php echo $berat4; ?> gram</td>
                    </tr>
                </table>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>