
<?php
/**
 * File: proses_tambah.php
 * Memproses penambahan data mahasiswa.
 */

require_once __DIR__ . '/includes/functions.php';

// Pastikan formulir dikirim menggunakan POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    set_flash_message(
        'danger',
        'Akses tidak valid! Formulir harus dikirim melalui POST.'
    );

    header('Location: index.php#form-tambah');
    exit;
}

// Ambil data dari formulir.
$npm = $_POST['npm'] ?? '';
$nama = $_POST['nama'] ?? '';
$program_studi = $_POST['program_studi'] ?? '';
$angkatan = $_POST['angkatan'] ?? '';
$email = $_POST['email'] ?? '';

// Validasi dan simpan data.
$hasil = tambah_mahasiswa(
    $npm,
    $nama,
    $program_studi,
    $angkatan,
    $email
);

// Simpan notifikasi.
if ($hasil['status']) {
    set_flash_message('success', $hasil['message']);
} else {
    set_flash_message('danger', $hasil['message']);
}

// Kembali ke halaman utama.
header('Location: index.php#daftar-mahasiswa');
exit;
