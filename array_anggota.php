<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Array Anggota Perpustakaan</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
	<?php
	$anggota_list = [
		[
			"id" => "AGT-001",
			"nama" => "Budi Santoso",
			"email" => "budi@email.com",
			"telepon" => "081234567890",
			"alamat" => "Jakarta",
			"tanggal_daftar" => "2024-01-15",
			"status" => "Aktif",
			"total_pinjaman" => 5
		],
		[
			"id" => "AGT-002",
			"nama" => "Siti Rahmawati",
			"email" => "siti@email.com",
			"telepon" => "081298765432",
			"alamat" => "Bandung",
			"tanggal_daftar" => "2024-02-01",
			"status" => "Aktif",
			"total_pinjaman" => 8
		],
		[
			"id" => "AGT-003",
			"nama" => "Andi Pratama",
			"email" => "andi@email.com",
			"telepon" => "081377788899",
			"alamat" => "Surabaya",
			"tanggal_daftar" => "2024-02-18",
			"status" => "Non-Aktif",
			"total_pinjaman" => 2
		],
		[
			"id" => "AGT-004",
			"nama" => "Dewi Lestari",
			"email" => "dewi@email.com",
			"telepon" => "081255566677",
			"alamat" => "Yogyakarta",
			"tanggal_daftar" => "2024-03-05",
			"status" => "Aktif",
			"total_pinjaman" => 11
		],
		[
			"id" => "AGT-005",
			"nama" => "Rizky Hidayat",
			"email" => "rizky@email.com",
			"telepon" => "081344455566",
			"alamat" => "Semarang",
			"tanggal_daftar" => "2024-03-21",
			"status" => "Non-Aktif",
			"total_pinjaman" => 1
		]
	];

	$total_anggota = count($anggota_list);
	$aktif = 0;
	$non_aktif = 0;
	$total_semua_pinjaman = 0;
	$anggota_teraktif = $anggota_list[0];

	foreach ($anggota_list as $anggota) {
		if ($anggota["status"] === "Aktif") {
			$aktif++;
		} else {
			$non_aktif++;
		}

		$total_semua_pinjaman += $anggota["total_pinjaman"];

		if ($anggota["total_pinjaman"] > $anggota_teraktif["total_pinjaman"]) {
			$anggota_teraktif = $anggota;
		}
	}

	$persen_aktif = $total_anggota > 0 ? round(($aktif / $total_anggota) * 100, 1) : 0;
	$persen_non_aktif = $total_anggota > 0 ? round(($non_aktif / $total_anggota) * 100, 1) : 0;
	$rata_rata_pinjaman = $total_anggota > 0 ? round($total_semua_pinjaman / $total_anggota, 2) : 0;

	$filter_status = $_GET["status"] ?? "Semua";
	$filtered_anggota = [];

	foreach ($anggota_list as $anggota) {
		if ($filter_status === "Semua" || $anggota["status"] === $filter_status) {
			$filtered_anggota[] = $anggota;
		}
	}
	?>

	<div class="container py-5">
		<h1 class="mb-4">Data Anggota Perpustakaan</h1>

		<div class="row g-3 mb-4">
			<div class="col-md-4 col-lg-3">
				<div class="card shadow-sm h-100">
					<div class="card-body">
						<h6 class="card-title text-muted">Total Anggota</h6>
						<p class="h3 mb-0 text-primary"><?php echo $total_anggota; ?></p>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-lg-3">
				<div class="card shadow-sm h-100">
					<div class="card-body">
						<h6 class="card-title text-muted">Anggota Aktif</h6>
						<p class="h3 mb-0 text-success"><?php echo $aktif; ?> (<?php echo $persen_aktif; ?>%)</p>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-lg-3">
				<div class="card shadow-sm h-100">
					<div class="card-body">
						<h6 class="card-title text-muted">Anggota Non-Aktif</h6>
						<p class="h3 mb-0 text-danger"><?php echo $non_aktif; ?> (<?php echo $persen_non_aktif; ?>%)</p>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="card shadow-sm h-100">
					<div class="card-body">
						<h6 class="card-title text-muted">Rata-rata Pinjaman</h6>
						<p class="h3 mb-0 text-warning"><?php echo $rata_rata_pinjaman; ?></p>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-6">
				<div class="card shadow-sm h-100 border-primary">
					<div class="card-body">
						<h6 class="card-title text-muted">Anggota Teraktif</h6>
						<p class="h5 mb-1"><?php echo $anggota_teraktif["nama"]; ?> (<?php echo $anggota_teraktif["id"]; ?>)</p>
						<p class="mb-0">Total pinjaman: <strong><?php echo $anggota_teraktif["total_pinjaman"]; ?> kali</strong></p>
					</div>
				</div>
			</div>
		</div>

		<div class="card shadow-sm mb-4">
			<div class="card-body">
				<h5 class="card-title">Filter Anggota Berdasarkan Status</h5>
				<div class="d-flex flex-wrap gap-2 mt-3">
					<a href="?status=Semua" class="btn <?php echo $filter_status === "Semua" ? "btn-primary" : "btn-outline-primary"; ?>">Semua</a>
					<a href="?status=Aktif" class="btn <?php echo $filter_status === "Aktif" ? "btn-success" : "btn-outline-success"; ?>">Aktif</a>
					<a href="?status=Non-Aktif" class="btn <?php echo $filter_status === "Non-Aktif" ? "btn-danger" : "btn-outline-danger"; ?>">Non-Aktif</a>
				</div>
			</div>
		</div>

		<div class="card shadow-sm">
			<div class="card-body">
				<h5 class="card-title mb-3">Daftar Anggota (<?php echo $filter_status; ?>)</h5>
				<div class="table-responsive">
					<table class="table table-striped table-hover align-middle">
						<thead class="table-dark">
							<tr>
								<th>No</th>
								<th>ID</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Telepon</th>
								<th>Alamat</th>
								<th>Tanggal Daftar</th>
								<th>Status</th>
								<th>Total Pinjaman</th>
							</tr>
						</thead>
						<tbody>
							<?php if (count($filtered_anggota) > 0): ?>
								<?php foreach ($filtered_anggota as $index => $anggota): ?>
									<tr>
										<td><?php echo $index + 1; ?></td>
										<td><?php echo $anggota["id"]; ?></td>
										<td><?php echo $anggota["nama"]; ?></td>
										<td><?php echo $anggota["email"]; ?></td>
										<td><?php echo $anggota["telepon"]; ?></td>
										<td><?php echo $anggota["alamat"]; ?></td>
										<td><?php echo date("d M Y", strtotime($anggota["tanggal_daftar"])); ?></td>
										<td>
											<span class="badge <?php echo $anggota["status"] === "Aktif" ? "bg-success" : "bg-secondary"; ?>">
												<?php echo $anggota["status"]; ?>
											</span>
										</td>
										<td><?php echo $anggota["total_pinjaman"]; ?> kali</td>
									</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr>
									<td colspan="9" class="text-center text-muted">Tidak ada data anggota untuk filter ini.</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
