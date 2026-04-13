<?php
// 1. Function untuk hitung total anggota
function hitung_total_anggota($anggota_list) {
	return count($anggota_list);
}

// 2. Function untuk hitung anggota aktif
function hitung_anggota_aktif($anggota_list) {
	$total_aktif = 0;

	foreach ($anggota_list as $anggota) {
		if (($anggota['status'] ?? '') === 'Aktif') {
			$total_aktif++;
		}
	}

	return $total_aktif;
}

// 3. Function untuk hitung rata-rata pinjaman
function hitung_rata_rata_pinjaman($anggota_list) {
	$total_anggota = count($anggota_list);
	if ($total_anggota === 0) {
		return 0;
	}

	$total_pinjaman = 0;
	foreach ($anggota_list as $anggota) {
		$total_pinjaman += (int) ($anggota['total_pinjaman'] ?? 0);
	}

	return $total_pinjaman / $total_anggota;
}

// 4. Function untuk cari anggota by ID
function cari_anggota_by_id($anggota_list, $id) {
	foreach ($anggota_list as $anggota) {
		if (($anggota['id'] ?? '') === $id) {
			return $anggota;
		}
	}

	return null;
}

// 5. Function untuk cari anggota teraktif
function cari_anggota_teraktif($anggota_list) {
	if (empty($anggota_list)) {
		return null;
	}

	$teraktif = $anggota_list[0];
	foreach ($anggota_list as $anggota) {
		if ((int) ($anggota['total_pinjaman'] ?? 0) > (int) ($teraktif['total_pinjaman'] ?? 0)) {
			$teraktif = $anggota;
		}
	}

	return $teraktif;
}

// 6. Function untuk filter by status
function filter_by_status($anggota_list, $status) {
	$hasil = [];

	foreach ($anggota_list as $anggota) {
		if (($anggota['status'] ?? '') === $status) {
			$hasil[] = $anggota;
		}
	}

	return $hasil;
}

// 7. Function untuk validasi email
function validasi_email($email) {
	$email = trim((string) $email);
	if ($email === '') {
		return false;
	}

	if (strpos($email, '@') === false || strpos($email, '.') === false) {
		return false;
	}

	return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// 8. Function untuk format tanggal Indonesia
function format_tanggal_indo($tanggal) {
	$timestamp = strtotime($tanggal);
	if ($timestamp === false) {
		return '-';
	}

	$bulan = [
		1 => 'Januari',
		2 => 'Februari',
		3 => 'Maret',
		4 => 'April',
		5 => 'Mei',
		6 => 'Juni',
		7 => 'Juli',
		8 => 'Agustus',
		9 => 'September',
		10 => 'Oktober',
		11 => 'November',
		12 => 'Desember'
	];

	$hari = date('d', $timestamp);
	$bulan_angka = (int) date('m', $timestamp);
	$tahun = date('Y', $timestamp);

	return $hari . ' ' . $bulan[$bulan_angka] . ' ' . $tahun;
}

// Bonus: Sort anggota berdasarkan nama A-Z
function sort_anggota_by_nama($anggota_list) {
	usort($anggota_list, function ($a, $b) {
		return strcasecmp($a['nama'] ?? '', $b['nama'] ?? '');
	});

	return $anggota_list;
}

// Bonus: Search anggota berdasarkan nama (partial match)
function search_anggota_by_nama($anggota_list, $keyword) {
	$keyword = trim((string) $keyword);
	if ($keyword === '') {
		return $anggota_list;
	}

	$hasil = [];
	foreach ($anggota_list as $anggota) {
		if (stripos($anggota['nama'] ?? '', $keyword) !== false) {
			$hasil[] = $anggota;
		}
	}

	return $hasil;
}
?>
