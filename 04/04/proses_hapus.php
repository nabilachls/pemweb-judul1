
<?php
/**
 * File: proses_hapus.php
 * Memproses penghapusan data mahasiswa.
 */

require_once __DIR__ . '/includes/functions.php';

// Pastikan permintaan menggunakan POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    set_flash_message(
        'danger',
        'Akses tidak valid untuk menghapus data mahasiswa.'
    );

    header('Location: index.php#daftar-mahasiswa');
    exit;
}

// Ambil NPM dari formulir.
$npm = $_POST['npm'] ?? '';

if (trim((string) $npm) === '') {
    set_flash_message(
        'danger',
        'NPM mahasiswa yang akan dihapus tidak ditentukan!'
    );
} else {
    $hasil = hapus_mahasiswa($npm);

    if ($hasil['status']) {
        set_flash_message('success', $hasil['message']);
    } else {
        set_flash_message('danger', $hasil['message']);
    }
}

// Kembali ke halaman utama.
header('Location: index.php#daftar-mahasiswa');
exit;
