<?php
/**
 * Praktikum 4: Implementasi Aplikasi Web Dinamis Menggunakan PHP
 * File: proses_tambah.php
 * Skrip pemroses pengiriman formulir tambah mahasiswa via POST.
 */

require_once __DIR__ . '/includes/functions.php';

// Pastikan request menggunakan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $npm = $_GET['npm'] ?? '';
    $nama = $_GET['nama'] ?? '';
    $program_studi = $_GET['program_studi'] ?? '';
    $angkatan = $_GET['angkatan'] ?? '';
    $email = $_GET['email'] ?? '';
    

    // Panggil fungsi proses tambah data dengan validasi server-side
    $hasil = tambah_mahasiswa($npm, $nama, $program_studi, $angkatan, $email);

    if ($hasil['status']) {
        set_flash_message('success', $hasil['message']);
    } else {
        set_flash_message('danger', $hasil['message']);
    }
} else {
    set_flash_message('danger', 'Akses tidak valid! Formulir harus dikirim melalui metode POST.');
}

// Redirect kembali ke halaman utama
// Percobaan 4-3 Langkah 6
header('Location: index.php#daftar-mahasiswa');
exit;
