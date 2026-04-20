<?php
$nama_lengkap = '';
$email = '';
$telepon = '';
$alamat = '';
$jenis_kelamin = '';
$tanggal_lahir = '';
$pekerjaan = '';

$errors = [];
$success = false;
$submitted_data = [];

$pekerjaan_options = ['Pelajar', 'Mahasiswa', 'Pegawai', 'Lainnya'];
$jenis_kelamin_options = ['Laki-laki', 'Perempuan'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$nama_lengkap = trim((string) ($_POST['nama_lengkap'] ?? ''));
	$email = trim((string) ($_POST['email'] ?? ''));
	$telepon = trim((string) ($_POST['telepon'] ?? ''));
	$alamat = trim((string) ($_POST['alamat'] ?? ''));
	$jenis_kelamin = trim((string) ($_POST['jenis_kelamin'] ?? ''));
	$tanggal_lahir = trim((string) ($_POST['tanggal_lahir'] ?? ''));
	$pekerjaan = trim((string) ($_POST['pekerjaan'] ?? ''));

	if ($nama_lengkap === '') {
		$errors['nama_lengkap'] = 'Nama lengkap wajib diisi.';
	} elseif (mb_strlen($nama_lengkap) < 3) {
		$errors['nama_lengkap'] = 'Nama lengkap minimal 3 karakter.';
	}

	if ($email === '') {
		$errors['email'] = 'Email wajib diisi.';
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = 'Format email tidak valid.';
	}

	if ($telepon === '') {
		$errors['telepon'] = 'Telepon wajib diisi.';
	} elseif (!preg_match('/^08\d{8,11}$/', $telepon)) {
		$errors['telepon'] = 'Telepon harus diawali 08 dan memiliki 10-13 digit.';
	}

	if ($alamat === '') {
		$errors['alamat'] = 'Alamat wajib diisi.';
	} elseif (mb_strlen($alamat) < 10) {
		$errors['alamat'] = 'Alamat minimal 10 karakter.';
	}

	if ($jenis_kelamin === '') {
		$errors['jenis_kelamin'] = 'Jenis kelamin wajib dipilih.';
	} elseif (!in_array($jenis_kelamin, $jenis_kelamin_options, true)) {
		$errors['jenis_kelamin'] = 'Pilihan jenis kelamin tidak valid.';
	}

	if ($tanggal_lahir === '') {
		$errors['tanggal_lahir'] = 'Tanggal lahir wajib diisi.';
	} else {
		$tanggal_lahir_obj = DateTime::createFromFormat('Y-m-d', $tanggal_lahir);
		$valid_tanggal_lahir = $tanggal_lahir_obj instanceof DateTime && $tanggal_lahir_obj->format('Y-m-d') === $tanggal_lahir;

		if (!$valid_tanggal_lahir) {
			$errors['tanggal_lahir'] = 'Tanggal lahir tidak valid.';
		} else {
			$today = new DateTime('today');
			$umur = $tanggal_lahir_obj->diff($today)->y;

			if ($tanggal_lahir_obj > $today) {
				$errors['tanggal_lahir'] = 'Tanggal lahir tidak boleh di masa depan.';
			} elseif ($umur < 10) {
				$errors['tanggal_lahir'] = 'Umur minimal 10 tahun.';
			}
		}
	}

	if ($pekerjaan === '') {
		$errors['pekerjaan'] = 'Pekerjaan wajib dipilih.';
	} elseif (!in_array($pekerjaan, $pekerjaan_options, true)) {
		$errors['pekerjaan'] = 'Pilihan pekerjaan tidak valid.';
	}

	if (empty($errors)) {
		$success = true;
		$submitted_data = [
			'nama_lengkap' => $nama_lengkap,
			'email' => $email,
			'telepon' => $telepon,
			'alamat' => $alamat,
			'jenis_kelamin' => $jenis_kelamin,
			'tanggal_lahir' => $tanggal_lahir,
			'pekerjaan' => $pekerjaan,
		];
	}
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Form Registrasi Anggota</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-lg-10 col-xl-8">
				<div class="text-center mb-4">
					<h1 class="fw-bold">Form Registrasi Anggota</h1>
					<p class="text-muted mb-0">Lengkapi data anggota perpustakaan dengan validasi yang lengkap.</p>
				</div>

				<?php if ($success): ?>
					<div class="alert alert-success shadow-sm" role="alert">
						<strong>Registrasi berhasil.</strong> Data anggota telah tervalidasi.
					</div>

					<div class="card shadow-sm mb-4">
						<div class="card-header bg-success text-white">
							<h5 class="mb-0">Data Anggota</h5>
						</div>
						<div class="card-body">
							<div class="row g-3">
								<div class="col-md-6">
									<div class="border rounded p-3 h-100 bg-white">
										<div class="text-muted small">Nama Lengkap</div>
										<div class="fw-semibold"><?php echo htmlspecialchars($submitted_data['nama_lengkap']); ?></div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="border rounded p-3 h-100 bg-white">
										<div class="text-muted small">Email</div>
										<div class="fw-semibold"><?php echo htmlspecialchars($submitted_data['email']); ?></div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="border rounded p-3 h-100 bg-white">
										<div class="text-muted small">Telepon</div>
										<div class="fw-semibold"><?php echo htmlspecialchars($submitted_data['telepon']); ?></div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="border rounded p-3 h-100 bg-white">
										<div class="text-muted small">Jenis Kelamin</div>
										<div class="fw-semibold"><?php echo htmlspecialchars($submitted_data['jenis_kelamin']); ?></div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="border rounded p-3 h-100 bg-white">
										<div class="text-muted small">Tanggal Lahir</div>
										<div class="fw-semibold"><?php echo date('d F Y', strtotime($submitted_data['tanggal_lahir'])); ?></div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="border rounded p-3 h-100 bg-white">
										<div class="text-muted small">Pekerjaan</div>
										<div class="fw-semibold"><?php echo htmlspecialchars($submitted_data['pekerjaan']); ?></div>
									</div>
								</div>
								<div class="col-12">
									<div class="border rounded p-3 bg-white">
										<div class="text-muted small">Alamat</div>
										<div class="fw-semibold"><?php echo nl2br(htmlspecialchars($submitted_data['alamat'])); ?></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<div class="card shadow-sm border-0">
					<div class="card-header bg-primary text-white py-3">
						<h5 class="mb-0">Data Registrasi</h5>
					</div>
					<div class="card-body p-4">
						<form method="POST" novalidate>
							<div class="row g-3">
								<div class="col-md-6">
									<label for="nama_lengkap" class="form-label">Nama Lengkap</label>
									<input type="text" class="form-control <?php echo isset($errors['nama_lengkap']) ? 'is-invalid' : ''; ?>" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($nama_lengkap); ?>" placeholder="Masukkan nama lengkap">
									<div class="invalid-feedback"><?php echo htmlspecialchars($errors['nama_lengkap'] ?? ''); ?></div>
								</div>

								<div class="col-md-6">
									<label for="email" class="form-label">Email</label>
									<input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="nama@email.com">
									<div class="invalid-feedback"><?php echo htmlspecialchars($errors['email'] ?? ''); ?></div>
								</div>

								<div class="col-md-6">
									<label for="telepon" class="form-label">Telepon</label>
									<input type="text" class="form-control <?php echo isset($errors['telepon']) ? 'is-invalid' : ''; ?>" id="telepon" name="telepon" value="<?php echo htmlspecialchars($telepon); ?>" placeholder="08xxxxxxxxxx">
									<div class="invalid-feedback"><?php echo htmlspecialchars($errors['telepon'] ?? ''); ?></div>
								</div>

								<div class="col-md-6">
									<label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
									<input type="date" class="form-control <?php echo isset($errors['tanggal_lahir']) ? 'is-invalid' : ''; ?>" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo htmlspecialchars($tanggal_lahir); ?>">
									<div class="invalid-feedback"><?php echo htmlspecialchars($errors['tanggal_lahir'] ?? ''); ?></div>
								</div>

								<div class="col-12">
									<label for="alamat" class="form-label">Alamat</label>
									<textarea class="form-control <?php echo isset($errors['alamat']) ? 'is-invalid' : ''; ?>" id="alamat" name="alamat" rows="4" placeholder="Masukkan alamat lengkap"><?php echo htmlspecialchars($alamat); ?></textarea>
									<div class="invalid-feedback"><?php echo htmlspecialchars($errors['alamat'] ?? ''); ?></div>
								</div>

								<div class="col-md-6">
									<label class="form-label d-block">Jenis Kelamin</label>
									<div class="d-flex gap-3 flex-wrap">
										<?php foreach ($jenis_kelamin_options as $option): ?>
											<div class="form-check">
												<input class="form-check-input <?php echo isset($errors['jenis_kelamin']) ? 'is-invalid' : ''; ?>" type="radio" name="jenis_kelamin" id="jk_<?php echo strtolower(str_replace(' ', '_', $option)); ?>" value="<?php echo htmlspecialchars($option); ?>" <?php echo $jenis_kelamin === $option ? 'checked' : ''; ?>>
												<label class="form-check-label" for="jk_<?php echo strtolower(str_replace(' ', '_', $option)); ?>"><?php echo htmlspecialchars($option); ?></label>
											</div>
										<?php endforeach; ?>
									</div>
									<?php if (isset($errors['jenis_kelamin'])): ?>
										<div class="invalid-feedback d-block"><?php echo htmlspecialchars($errors['jenis_kelamin']); ?></div>
									<?php endif; ?>
								</div>

								<div class="col-md-6">
									<label for="pekerjaan" class="form-label">Pekerjaan</label>
									<select class="form-select <?php echo isset($errors['pekerjaan']) ? 'is-invalid' : ''; ?>" id="pekerjaan" name="pekerjaan">
										<option value="">Pilih pekerjaan</option>
										<?php foreach ($pekerjaan_options as $option): ?>
											<option value="<?php echo htmlspecialchars($option); ?>" <?php echo $pekerjaan === $option ? 'selected' : ''; ?>><?php echo htmlspecialchars($option); ?></option>
										<?php endforeach; ?>
									</select>
									<div class="invalid-feedback"><?php echo htmlspecialchars($errors['pekerjaan'] ?? ''); ?></div>
								</div>

								<div class="col-12 pt-2">
									<button type="submit" class="btn btn-primary px-4">Daftar Anggota</button>
									<button type="reset" class="btn btn-outline-secondary px-4 ms-2">Reset</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
