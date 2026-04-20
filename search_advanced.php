<?php
session_start();

function esc($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function highlight_keyword($text, $keyword) {
    $keyword = trim((string) $keyword);

    if ($keyword === '') {
        return esc($text);
    }

    $pattern = '/(' . preg_quote($keyword, '/') . ')/i';
    $parts = preg_split($pattern, (string) $text, -1, PREG_SPLIT_DELIM_CAPTURE);

    if ($parts === false) {
        return esc($text);
    }

    $result = '';

    foreach ($parts as $part) {
        if ($part === '') {
            continue;
        }

        if (preg_match('/^' . preg_quote($keyword, '/') . '$/i', $part)) {
            $result .= '<mark>' . esc($part) . '</mark>';
        } else {
            $result .= esc($part);
        }
    }

    return $result;
}

function build_query($params, $override = [], $remove = []) {
    $query = array_merge($params, $override);

    foreach ($remove as $key) {
        unset($query[$key]);
    }

    foreach ($query as $key => $value) {
        if ($value === '' || $value === null) {
            unset($query[$key]);
        }
    }

    return http_build_query($query);
}

$buku_list = [
    [
        'kode' => 'BK-001',
        'judul' => 'Pemrograman PHP untuk Pemula',
        'kategori' => 'Programming',
        'pengarang' => 'Budi Raharjo',
        'penerbit' => 'Informatika',
        'tahun' => 2021,
        'harga' => 75000,
        'stok' => 10,
    ],
    [
        'kode' => 'BK-002',
        'judul' => 'Mastering MySQL Database',
        'kategori' => 'Database',
        'pengarang' => 'Andi Nugroho',
        'penerbit' => 'Graha Ilmu',
        'tahun' => 2022,
        'harga' => 95000,
        'stok' => 5,
    ],
    [
        'kode' => 'BK-003',
        'judul' => 'Laravel Framework Advanced',
        'kategori' => 'Programming',
        'pengarang' => 'Siti Aminah',
        'penerbit' => 'Informatika',
        'tahun' => 2024,
        'harga' => 125000,
        'stok' => 8,
    ],
    [
        'kode' => 'BK-004',
        'judul' => 'Web Design Principles',
        'kategori' => 'Web Design',
        'pengarang' => 'Dedi Santoso',
        'penerbit' => 'Andi',
        'tahun' => 2020,
        'harga' => 85000,
        'stok' => 0,
    ],
    [
        'kode' => 'BK-005',
        'judul' => 'Network Security Fundamentals',
        'kategori' => 'Networking',
        'pengarang' => 'Rina Wijaya',
        'penerbit' => 'Erlangga',
        'tahun' => 2023,
        'harga' => 110000,
        'stok' => 3,
    ],
    [
        'kode' => 'BK-006',
        'judul' => 'PHP Web Services',
        'kategori' => 'Programming',
        'pengarang' => 'Budi Raharjo',
        'penerbit' => 'Informatika',
        'tahun' => 2024,
        'harga' => 90000,
        'stok' => 12,
    ],
    [
        'kode' => 'BK-007',
        'judul' => 'PostgreSQL Advanced',
        'kategori' => 'Database',
        'pengarang' => 'Ahmad Yani',
        'penerbit' => 'Graha Ilmu',
        'tahun' => 2025,
        'harga' => 115000,
        'stok' => 7,
    ],
    [
        'kode' => 'BK-008',
        'judul' => 'JavaScript Modern',
        'kategori' => 'Programming',
        'pengarang' => 'Siti Aminah',
        'penerbit' => 'Informatika',
        'tahun' => 2023,
        'harga' => 80000,
        'stok' => 0,
    ],
    [
        'kode' => 'BK-009',
        'judul' => 'Data Mining Dasar',
        'kategori' => 'Data Science',
        'pengarang' => 'Rudi Hartono',
        'penerbit' => 'Deepublish',
        'tahun' => 2019,
        'harga' => 99000,
        'stok' => 9,
    ],
    [
        'kode' => 'BK-010',
        'judul' => 'Machine Learning Praktis',
        'kategori' => 'Data Science',
        'pengarang' => 'Nina Marlina',
        'penerbit' => 'Informatika',
        'tahun' => 2024,
        'harga' => 135000,
        'stok' => 6,
    ],
    [
        'kode' => 'BK-011',
        'judul' => 'UI UX untuk Developer',
        'kategori' => 'Web Design',
        'pengarang' => 'Farhan Akbar',
        'penerbit' => 'Andi',
        'tahun' => 2022,
        'harga' => 88000,
        'stok' => 4,
    ],
    [
        'kode' => 'BK-012',
        'judul' => 'Cloud Computing Essentials',
        'kategori' => 'Networking',
        'pengarang' => 'Lia Kurnia',
        'penerbit' => 'Erlangga',
        'tahun' => 2025,
        'harga' => 128000,
        'stok' => 11,
    ],
];

$keyword = trim($_GET['keyword'] ?? '');
$kategori = trim($_GET['kategori'] ?? '');
$min_harga_raw = trim($_GET['min_harga'] ?? '');
$max_harga_raw = trim($_GET['max_harga'] ?? '');
$tahun_raw = trim($_GET['tahun'] ?? '');
$status = strtolower(trim($_GET['status'] ?? 'semua'));
$sort = trim($_GET['sort'] ?? 'judul_asc');
$page_raw = trim($_GET['page'] ?? '1');
$is_export_csv = (($_GET['export'] ?? '') === 'csv');

$allowed_status = ['semua', 'tersedia', 'habis'];
$allowed_sort = ['judul_asc', 'judul_desc', 'harga_asc', 'harga_desc', 'tahun_asc', 'tahun_desc'];

if (!in_array($status, $allowed_status, true)) {
    $status = 'semua';
}

if (!in_array($sort, $allowed_sort, true)) {
    $sort = 'judul_asc';
}

$errors = [];
$current_year = (int) date('Y');
$min_harga = null;
$max_harga = null;
$tahun = null;

if ($min_harga_raw !== '') {
    if (filter_var($min_harga_raw, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) === false) {
        $errors['min_harga'] = 'Harga minimum harus berupa angka dan tidak boleh negatif';
    } else {
        $min_harga = (int) $min_harga_raw;
    }
}

if ($max_harga_raw !== '') {
    if (filter_var($max_harga_raw, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) === false) {
        $errors['max_harga'] = 'Harga maksimum harus berupa angka dan tidak boleh negatif';
    } else {
        $max_harga = (int) $max_harga_raw;
    }
}

if ($min_harga !== null && $max_harga !== null && $min_harga > $max_harga) {
    $errors['range_harga'] = 'Harga minimum tidak boleh lebih besar dari harga maksimum';
}

if ($tahun_raw !== '') {
    if (filter_var($tahun_raw, FILTER_VALIDATE_INT) === false) {
        $errors['tahun'] = 'Tahun harus berupa angka';
    } else {
        $tahun = (int) $tahun_raw;
        if ($tahun < 1900 || $tahun > $current_year) {
            $errors['tahun'] = 'Tahun harus di antara 1900 sampai ' . $current_year;
        }
    }
}

$search_params = [
    'keyword' => $keyword,
    'kategori' => $kategori,
    'min_harga' => $min_harga_raw,
    'max_harga' => $max_harga_raw,
    'tahun' => $tahun_raw,
    'status' => $status,
    'sort' => $sort,
];

$has_search_criteria = (
    $keyword !== '' ||
    $kategori !== '' ||
    $min_harga_raw !== '' ||
    $max_harga_raw !== '' ||
    $tahun_raw !== '' ||
    $status !== 'semua'
);

if (!isset($_SESSION['recent_searches']) || !is_array($_SESSION['recent_searches'])) {
    $_SESSION['recent_searches'] = [];
}

$normalized_recent_searches = [];
foreach ($_SESSION['recent_searches'] as $entry) {
    if (!is_array($entry)) {
        continue;
    }

    $entry_params = $entry['params'] ?? null;
    if (!is_array($entry_params)) {
        continue;
    }

    $normalized_params = [
        'keyword' => trim((string) ($entry_params['keyword'] ?? '')),
        'kategori' => trim((string) ($entry_params['kategori'] ?? '')),
        'min_harga' => trim((string) ($entry_params['min_harga'] ?? '')),
        'max_harga' => trim((string) ($entry_params['max_harga'] ?? '')),
        'tahun' => trim((string) ($entry_params['tahun'] ?? '')),
        'status' => trim((string) ($entry_params['status'] ?? 'semua')),
        'sort' => trim((string) ($entry_params['sort'] ?? 'judul_asc')),
    ];

    if (!in_array($normalized_params['status'], $allowed_status, true)) {
        $normalized_params['status'] = 'semua';
    }
    if (!in_array($normalized_params['sort'], $allowed_sort, true)) {
        $normalized_params['sort'] = 'judul_asc';
    }

    $signature = (string) ($entry['signature'] ?? '');
    if ($signature === '') {
        $signature = md5(json_encode($normalized_params));
    }

    $normalized_recent_searches[] = [
        'signature' => $signature,
        'params' => $normalized_params,
        'created_at' => trim((string) ($entry['created_at'] ?? '')),
    ];
}

$_SESSION['recent_searches'] = array_slice($normalized_recent_searches, 0, 5);

if (count($errors) === 0 && $has_search_criteria) {
    $signature = md5(json_encode($search_params));
    $latest_signature = '';

    if (isset($_SESSION['recent_searches'][0]) && is_array($_SESSION['recent_searches'][0])) {
        $latest_signature = (string) ($_SESSION['recent_searches'][0]['signature'] ?? '');
    }

    if ($signature !== $latest_signature) {
        array_unshift($_SESSION['recent_searches'], [
            'signature' => $signature,
            'params' => $search_params,
            'created_at' => date('d-m-Y H:i'),
        ]);

        $_SESSION['recent_searches'] = array_slice($_SESSION['recent_searches'], 0, 5);
    }
}

$hasil = [];

if (count($errors) === 0) {
    foreach ($buku_list as $buku) {
        $match = true;

        if ($keyword !== '') {
            if (stripos($buku['judul'], $keyword) === false && stripos($buku['pengarang'], $keyword) === false) {
                $match = false;
            }
        }

        if ($match && $kategori !== '' && $buku['kategori'] !== $kategori) {
            $match = false;
        }

        if ($match && $min_harga !== null && $buku['harga'] < $min_harga) {
            $match = false;
        }

        if ($match && $max_harga !== null && $buku['harga'] > $max_harga) {
            $match = false;
        }

        if ($match && $tahun !== null && (int) $buku['tahun'] !== $tahun) {
            $match = false;
        }

        if ($match && $status === 'tersedia' && (int) $buku['stok'] <= 0) {
            $match = false;
        }

        if ($match && $status === 'habis' && (int) $buku['stok'] > 0) {
            $match = false;
        }

        if ($match) {
            $hasil[] = $buku;
        }
    }

    usort($hasil, function ($a, $b) use ($sort) {
        switch ($sort) {
            case 'judul_desc':
                return strcasecmp($b['judul'], $a['judul']);
            case 'harga_asc':
                return $a['harga'] <=> $b['harga'];
            case 'harga_desc':
                return $b['harga'] <=> $a['harga'];
            case 'tahun_asc':
                return $a['tahun'] <=> $b['tahun'];
            case 'tahun_desc':
                return $b['tahun'] <=> $a['tahun'];
            case 'judul_asc':
            default:
                return strcasecmp($a['judul'], $b['judul']);
        }
    });
}

if ($is_export_csv && count($errors) === 0) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="hasil_pencarian_buku_' . date('Ymd_His') . '.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Kode', 'Judul', 'Kategori', 'Pengarang', 'Penerbit', 'Tahun', 'Harga', 'Stok', 'Status']);

    foreach ($hasil as $buku) {
        fputcsv($output, [
            $buku['kode'],
            $buku['judul'],
            $buku['kategori'],
            $buku['pengarang'],
            $buku['penerbit'],
            $buku['tahun'],
            $buku['harga'],
            $buku['stok'],
            ((int) $buku['stok'] > 0) ? 'Tersedia' : 'Habis',
        ]);
    }

    fclose($output);
    exit;
}

$per_page = 10;
$total_hasil = count($hasil);
$total_pages = (int) ceil(max($total_hasil, 1) / $per_page);
$page = (int) $page_raw;

if ($page < 1) {
    $page = 1;
}

if ($page > $total_pages) {
    $page = $total_pages;
}

$offset = ($page - 1) * $per_page;
$hasil_page = array_slice($hasil, $offset, $per_page);

$kategori_options = [];
foreach ($buku_list as $item) {
    if (!in_array($item['kategori'], $kategori_options, true)) {
        $kategori_options[] = $item['kategori'];
    }
}
sort($kategori_options);

$csv_query = build_query($search_params, ['export' => 'csv'], ['page']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Buku Lanjutan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5 mb-5">
        <h2 class="mb-4"><i class="bi bi-search"></i> Sistem Pencarian Buku Lanjutan</h2>

        <?php if (count($errors) > 0): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="bi bi-exclamation-triangle-fill"></i> Validasi gagal:</strong>
            <ul class="mb-0 mt-2">
                <?php foreach ($errors as $error): ?>
                <li><?php echo esc($error); ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-funnel"></i> Form Pencarian & Filter</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="keyword" class="form-label">Keyword (Judul/Pengarang)</label>
                            <input
                                type="text"
                                class="form-control"
                                id="keyword"
                                name="keyword"
                                value="<?php echo esc($keyword); ?>"
                                placeholder="Masukkan judul atau pengarang"
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori" name="kategori">
                                <option value="">-- Semua Kategori --</option>
                                <?php foreach ($kategori_options as $option): ?>
                                <option value="<?php echo esc($option); ?>" <?php echo ($kategori === $option) ? 'selected' : ''; ?>>
                                    <?php echo esc($option); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="min_harga" class="form-label">Harga Minimum</label>
                            <input
                                type="number"
                                class="form-control <?php echo isset($errors['min_harga']) || isset($errors['range_harga']) ? 'is-invalid' : ''; ?>"
                                id="min_harga"
                                name="min_harga"
                                value="<?php echo esc($min_harga_raw); ?>"
                                min="0"
                                placeholder="Contoh: 50000"
                            >
                            <?php if (isset($errors['min_harga'])): ?>
                            <div class="invalid-feedback"><?php echo esc($errors['min_harga']); ?></div>
                            <?php elseif (isset($errors['range_harga'])): ?>
                            <div class="invalid-feedback"><?php echo esc($errors['range_harga']); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="max_harga" class="form-label">Harga Maksimum</label>
                            <input
                                type="number"
                                class="form-control <?php echo isset($errors['max_harga']) || isset($errors['range_harga']) ? 'is-invalid' : ''; ?>"
                                id="max_harga"
                                name="max_harga"
                                value="<?php echo esc($max_harga_raw); ?>"
                                min="0"
                                placeholder="Contoh: 150000"
                            >
                            <?php if (isset($errors['max_harga'])): ?>
                            <div class="invalid-feedback"><?php echo esc($errors['max_harga']); ?></div>
                            <?php elseif (isset($errors['range_harga'])): ?>
                            <div class="invalid-feedback"><?php echo esc($errors['range_harga']); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="tahun" class="form-label">Tahun Terbit</label>
                            <input
                                type="number"
                                class="form-control <?php echo isset($errors['tahun']) ? 'is-invalid' : ''; ?>"
                                id="tahun"
                                name="tahun"
                                value="<?php echo esc($tahun_raw); ?>"
                                min="1900"
                                max="<?php echo esc($current_year); ?>"
                                placeholder="<?php echo esc($current_year); ?>"
                            >
                            <?php if (isset($errors['tahun'])): ?>
                            <div class="invalid-feedback"><?php echo esc($errors['tahun']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">Status Ketersediaan</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_semua" value="semua" <?php echo ($status === 'semua') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="status_semua">Semua</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_tersedia" value="tersedia" <?php echo ($status === 'tersedia') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="status_tersedia">Tersedia</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_habis" value="habis" <?php echo ($status === 'habis') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="status_habis">Habis</label>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sort" class="form-label">Sorting Hasil</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="judul_asc" <?php echo ($sort === 'judul_asc') ? 'selected' : ''; ?>>Judul (A-Z)</option>
                                <option value="judul_desc" <?php echo ($sort === 'judul_desc') ? 'selected' : ''; ?>>Judul (Z-A)</option>
                                <option value="harga_asc" <?php echo ($sort === 'harga_asc') ? 'selected' : ''; ?>>Harga (Termurah)</option>
                                <option value="harga_desc" <?php echo ($sort === 'harga_desc') ? 'selected' : ''; ?>>Harga (Termahal)</option>
                                <option value="tahun_asc" <?php echo ($sort === 'tahun_asc') ? 'selected' : ''; ?>>Tahun (Terlama)</option>
                                <option value="tahun_desc" <?php echo ($sort === 'tahun_desc') ? 'selected' : ''; ?>>Tahun (Terbaru)</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Cari Buku
                        </button>
                        <a href="search_advanced.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                        <?php if (count($errors) === 0 && $total_hasil > 0): ?>
                        <a href="search_advanced.php?<?php echo esc($csv_query); ?>" class="btn btn-success">
                            <i class="bi bi-download"></i> Export CSV
                        </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <?php if (!empty($_SESSION['recent_searches'])): ?>
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-clock-history"></i> Recent Searches (Session)</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php foreach ($_SESSION['recent_searches'] as $item): ?>
                    <li class="list-group-item px-0">
                        <?php
                        $recent_params = is_array($item['params'] ?? null) ? $item['params'] : [];
                        $recent_query = build_query($recent_params);
                        $recent_keyword = trim((string) ($recent_params['keyword'] ?? '')) !== '' ? trim((string) ($recent_params['keyword'] ?? '')) : '-';
                        $recent_kategori = trim((string) ($recent_params['kategori'] ?? '')) !== '' ? trim((string) ($recent_params['kategori'] ?? '')) : 'Semua';
                        $recent_status = trim((string) ($recent_params['status'] ?? 'semua'));
                        if (!in_array($recent_status, $allowed_status, true)) {
                            $recent_status = 'semua';
                        }
                        ?>
                        <a href="search_advanced.php?<?php echo esc($recent_query); ?>" class="text-decoration-none">
                            Keyword: <strong><?php echo esc($recent_keyword); ?></strong>
                            | Kategori: <?php echo esc($recent_kategori); ?>
                            | Status: <?php echo esc(ucfirst($recent_status)); ?>
                        </a>
                        <div class="small text-muted">Disimpan: <?php echo esc($item['created_at']); ?></div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-table"></i> Hasil Pencarian</h5>
                <span class="badge bg-light text-dark"><?php echo (int) $total_hasil; ?> buku ditemukan</span>
            </div>
            <div class="card-body">
                <?php if (count($errors) > 0): ?>
                <div class="alert alert-warning mb-0">
                    Perbaiki input filter terlebih dahulu untuk menampilkan hasil.
                </div>
                <?php elseif ($total_hasil === 0): ?>
                <div class="alert alert-secondary mb-0">
                    Tidak ada data buku yang sesuai dengan filter.
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($hasil_page as $index => $buku): ?>
                            <tr>
                                <td><?php echo (int) ($offset + $index + 1); ?></td>
                                <td><code><?php echo esc($buku['kode']); ?></code></td>
                                <td><?php echo highlight_keyword($buku['judul'], $keyword); ?></td>
                                <td><span class="badge bg-primary"><?php echo esc($buku['kategori']); ?></span></td>
                                <td><?php echo highlight_keyword($buku['pengarang'], $keyword); ?></td>
                                <td><?php echo esc($buku['penerbit']); ?></td>
                                <td><?php echo (int) $buku['tahun']; ?></td>
                                <td>Rp <?php echo number_format((int) $buku['harga'], 0, ',', '.'); ?></td>
                                <td class="text-center"><?php echo (int) $buku['stok']; ?></td>
                                <td>
                                    <?php if ((int) $buku['stok'] > 0): ?>
                                        <span class="badge bg-success">Tersedia</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Habis</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($total_pages > 1): ?>
                <nav aria-label="Pagination hasil pencarian">
                    <ul class="pagination justify-content-center mt-3 mb-0">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="search_advanced.php?<?php echo esc(build_query($search_params, ['page' => $page - 1], ['export'])); ?>">Previous</a>
                        </li>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i === $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="search_advanced.php?<?php echo esc(build_query($search_params, ['page' => $i], ['export'])); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                        <?php endfor; ?>

                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="search_advanced.php?<?php echo esc(build_query($search_params, ['page' => $page + 1], ['export'])); ?>">Next</a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>