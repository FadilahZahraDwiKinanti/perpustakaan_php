<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sistem Anggota Perpustakaan</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
	<?php
	require_once 'functions_anggota.php';

	$anggota_list = [
		[
			'id' => 'AGT-001',
			'nama' => 'Budi Santoso',
			'email' => 'budi@email.com',
			'telepon' => '081234567890',
			'alamat' => 'Jakarta',
			'tanggal_daftar' => '2024-01-15',
			'status' => 'Aktif',
			'total_pinjaman' => 5
		],
		[
			'id' => 'AGT-002',
			'nama' => 'Siti Rahmawati',
			'email' => 'siti@email.com',
			'telepon' => '081298765432',
			'alamat' => 'Bandung',
			'tanggal_daftar' => '2024-02-01',
			'status' => 'Aktif',
			'total_pinjaman' => 8
		],
		[
			'id' => 'AGT-003',
			'nama' => 'Andi Pratama',
			'email' => 'andi@email.com',
			'telepon' => '081377788899',
			'alamat' => 'Surabaya',
			'tanggal_daftar' => '2024-02-18',
			'status' => 'Non-Aktif',
			'total_pinjaman' => 2
		],
		[
			'id' => 'AGT-004',
			'nama' => 'Dewi Lestari',
			'email' => 'dewi@email.com',
			'telepon' => '081255566677',
			'alamat' => 'Yogyakarta',
			'tanggal_daftar' => '2024-03-05',
			'status' => 'Aktif',
			'total_pinjaman' => 11
		],
		[
			'id' => 'AGT-005',
			'nama' => 'Rizky Hidayat',
			'email' => 'rizky@email.com',
			'telepon' => '081344455566',
			'alamat' => 'Semarang',
			'tanggal_daftar' => '2024-03-21',
			'status' => 'Non-Aktif',
			'total_pinjaman' => 1
		],
		[
			'id' => 'AGT-006',
			'nama' => 'Lina Marlina',
			'email' => 'lina@email.com',
			'telepon' => '081366677788',
			'alamat' => 'Malang',
			'tanggal_daftar' => '2024-04-02',
			'status' => 'Aktif',
			'total_pinjaman' => 6
		]
	];

	$total_anggota = hitung_total_anggota($anggota_list);
	$total_aktif = hitung_anggota_aktif($anggota_list);
	$total_non_aktif = $total_anggota - $total_aktif;
	$persen_aktif = $total_anggota > 0 ? round(($total_aktif / $total_anggota) * 100, 1) : 0;
	$persen_non_aktif = $total_anggota > 0 ? round(($total_non_aktif / $total_anggota) * 100, 1) : 0;
	$rata_pinjaman = round(hitung_rata_rata_pinjaman($anggota_list), 2);

	$anggota_teraktif = cari_anggota_teraktif($anggota_list);
	$anggota_aktif_list = filter_by_status($anggota_list, 'Aktif');
	$anggota_non_aktif_list = filter_by_status($anggota_list, 'Non-Aktif');

	$keyword = $_GET['q'] ?? '';
	$urut_nama = $_GET['sort'] ?? '1';

	$tabel_list = $anggota_list;
	if (trim($keyword) !== '') {
		$tabel_list = search_anggota_by_nama($tabel_list, $keyword);
	}
	if ($urut_nama === '1') {
		$tabel_list = sort_anggota_by_nama($tabel_list);
	}

	$lihat_id = $_GET['id'] ?? '';
	$hasil_cari_id = null;
	if ($lihat_id !== '') {
		$hasil_cari_id = cari_anggota_by_id($anggota_list, $lihat_id);
	}
	?>

	<div class="container mt-5 mb-5">
		<h1 class="mb-4"><i class="bi bi-people"></i> Sistem Anggota Perpustakaan</h1>

		<div class="row mb-4 g-3">
			<div class="col-md-3">
				<div class="card shadow-sm h-100">
					<div class="card-body">
						<h6 class="text-muted">Total Anggota</h6>
						<div class="h3 mb-0 text-primary"><?php echo $total_anggota; ?></div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card shadow-sm h-100">
					<div class="card-body">
						<h6 class="text-muted">Anggota Aktif</h6>
						<div class="h3 mb-0 text-success"><?php echo $total_aktif; ?> (<?php echo $persen_aktif; ?>%)</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card shadow-sm h-100">
					<div class="card-body">
						<h6 class="text-muted">Anggota Non-Aktif</h6>
						<div class="h3 mb-0 text-danger"><?php echo $total_non_aktif; ?> (<?php echo $persen_non_aktif; ?>%)</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card shadow-sm h-100">
					<div class="card-body">
						<h6 class="text-muted">Rata-rata Pinjaman</h6>
						<div class="h3 mb-0 text-warning"><?php echo $rata_pinjaman; ?></div>
					</div>
				</div>
			</div>
		</div>

		<div class="card mb-4 shadow-sm">
			<div class="card-header bg-info text-white">
				<h5 class="mb-0">Pencarian dan Pengurutan</h5>
			</div>
			<div class="card-body">
				<form method="GET" class="row g-3">
					<div class="col-md-5">
						<label class="form-label">Cari nama anggota</label>
						<input type="text" name="q" class="form-control" placeholder="Contoh: budi" value="<?php echo htmlspecialchars($keyword); ?>">
					</div>
					<div class="col-md-4">
						<label class="form-label">Cari anggota by ID</label>
						<input type="text" name="id" class="form-control" placeholder="Contoh: AGT-003" value="<?php echo htmlspecialchars($lihat_id); ?>">
					</div>
					<div class="col-md-3">
						<label class="form-label">Urutkan nama A-Z</label>
						<select name="sort" class="form-select">
							<option value="1" <?php echo $urut_nama === '1' ? 'selected' : ''; ?>>Ya</option>
							<option value="0" <?php echo $urut_nama === '0' ? 'selected' : ''; ?>>Tidak</option>
						</select>
					</div>
					<div class="col-12">
						<button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Terapkan</button>
						<a href="sistem_anggota.php" class="btn btn-outline-secondary">Reset</a>
					</div>
				</form>

				<?php if ($lihat_id !== ''): ?>
					<div class="mt-3 alert <?php echo $hasil_cari_id ? 'alert-success' : 'alert-danger'; ?> mb-0">
						<?php if ($hasil_cari_id): ?>
							Ditemukan: <strong><?php echo $hasil_cari_id['nama']; ?></strong> (<?php echo $hasil_cari_id['id']; ?>)
						<?php else: ?>
							Anggota dengan ID <strong><?php echo htmlspecialchars($lihat_id); ?></strong> tidak ditemukan.
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="card mb-4 shadow-sm">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0">Daftar Anggota</h5>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-hover align-middle">
						<thead class="table-dark">
							<tr>
								<th>No</th>
								<th>ID</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Status Email</th>
								<th>Telepon</th>
								<th>Alamat</th>
								<th>Tanggal Daftar</th>
								<th>Status</th>
								<th>Total Pinjaman</th>
							</tr>
						</thead>
						<tbody>
							<?php if (count($tabel_list) > 0): ?>
								<?php foreach ($tabel_list as $index => $anggota): ?>
									<tr>
										<td><?php echo $index + 1; ?></td>
										<td><?php echo $anggota['id']; ?></td>
										<td><?php echo $anggota['nama']; ?></td>
										<td><?php echo $anggota['email']; ?></td>
										<td>
											<?php if (validasi_email($anggota['email'])): ?>
												<span class="badge bg-success">Valid</span>
											<?php else: ?>
												<span class="badge bg-danger">Tidak Valid</span>
											<?php endif; ?>
										</td>
										<td><?php echo $anggota['telepon']; ?></td>
										<td><?php echo $anggota['alamat']; ?></td>
										<td><?php echo format_tanggal_indo($anggota['tanggal_daftar']); ?></td>
										<td>
											<span class="badge <?php echo $anggota['status'] === 'Aktif' ? 'bg-success' : 'bg-secondary'; ?>">
												<?php echo $anggota['status']; ?>
											</span>
										</td>
										<td><?php echo $anggota['total_pinjaman']; ?> kali</td>
									</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr>
									<td colspan="10" class="text-center text-muted">Data anggota tidak ditemukan.</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="card mb-4 shadow-sm">
			<div class="card-header bg-success text-white">
				<h5 class="mb-0">Anggota Teraktif</h5>
			</div>
			<div class="card-body">
				<?php if ($anggota_teraktif): ?>
					<h4 class="mb-1"><?php echo $anggota_teraktif['nama']; ?> (<?php echo $anggota_teraktif['id']; ?>)</h4>
					<p class="mb-1">Status: <span class="badge bg-success"><?php echo $anggota_teraktif['status']; ?></span></p>
					<p class="mb-1">Total pinjaman: <strong><?php echo $anggota_teraktif['total_pinjaman']; ?> kali</strong></p>
					<p class="mb-0 text-muted">Terdaftar sejak <?php echo format_tanggal_indo($anggota_teraktif['tanggal_daftar']); ?></p>
				<?php else: ?>
					<p class="mb-0">Belum ada data anggota.</p>
				<?php endif; ?>
			</div>
		</div>

		<div class="row g-3">
			<div class="col-lg-6">
				<div class="card shadow-sm h-100">
					<div class="card-header bg-success-subtle">
						<h5 class="mb-0">Daftar Anggota Aktif</h5>
					</div>
					<div class="card-body">
						<?php if (count($anggota_aktif_list) > 0): ?>
							<ul class="list-group list-group-flush">
								<?php foreach ($anggota_aktif_list as $anggota): ?>
									<li class="list-group-item d-flex justify-content-between align-items-center">
										<span><?php echo $anggota['nama']; ?></span>
										<span class="badge bg-success"><?php echo $anggota['id']; ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php else: ?>
							<p class="mb-0">Tidak ada anggota aktif.</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card shadow-sm h-100">
					<div class="card-header bg-secondary text-white">
						<h5 class="mb-0">Daftar Anggota Non-Aktif</h5>
					</div>
					<div class="card-body">
						<?php if (count($anggota_non_aktif_list) > 0): ?>
							<ul class="list-group list-group-flush">
								<?php foreach ($anggota_non_aktif_list as $anggota): ?>
									<li class="list-group-item d-flex justify-content-between align-items-center">
										<span><?php echo $anggota['nama']; ?></span>
										<span class="badge bg-secondary"><?php echo $anggota['id']; ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php else: ?>
							<p class="mb-0">Tidak ada anggota non-aktif.</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
