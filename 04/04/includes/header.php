
<?php
/**
 * File: includes/header.php
 * Header dan navigasi aplikasi SIMA.
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= isset($page_title)
            ? htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8')
            : 'Sistem Informasi Data Mahasiswa' ?>
        - Praktikum 4
    </title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <div class="container header-brand">
        <a href="index.php" class="brand-logo" title="Beranda SIMA">
            <img
                src="img/logo-sima.svg"
                alt="Logo SIMA"
                width="48"
                height="48"
            >
        </a>

        <div>
            <h1>Sistem Informasi Data Mahasiswa (SIMA)</h1>
            <p>Aplikasi Pengelolaan Data Akademik Mahasiswa Berbasis Web</p>
        </div>
    </div>
</header>

<nav class="site-nav">
    <div class="container">
        <ul>
            <li><a href="index.php#informasi">Informasi Aplikasi</a></li>
            <li><a href="index.php#daftar-mahasiswa">Daftar Mahasiswa</a></li>
            <li><a href="index.php#form-tambah">Tambah Mahasiswa</a></li>
            <li>
                <a href="https://kampus.ac.id"
                   target="_blank"
                   rel="noopener noreferrer">
                    Portal Kampus ↗
                </a>
            </li>
        </ul>
    </div>
</nav>

<main>
    <div class="container">
