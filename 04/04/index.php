
<?php
/**
 * File: index.php
 * Halaman utama Sistem Informasi Data Mahasiswa.
 */

require_once __DIR__ . '/includes/functions.php';

// Judul halaman.
$page_title = 'Beranda - Sistem Informasi Data Mahasiswa';

// Ambil kata kunci pencarian.
$keyword = isset($_GET['search'])
    ? trim((string) $_GET['search'])
    : '';

// Ambil data mahasiswa.
$daftar_mahasiswa = get_all_mahasiswa($keyword);

// Hitung total data.
$total_semua = count_total_mahasiswa();
$total_tampil = count($daftar_mahasiswa);

// Ambil notifikasi.
$flash = get_flash_message();

// Tampilkan header.
require_once __DIR__ . '/includes/header.php';
?>

<?php if ($flash): ?>
    <div class="alert-box alert-<?= htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8') ?>">
        <?= htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<!-- Informasi aplikasi -->
<section id="informasi" class="content-section">
    <div class="section-header">
        <h2>Tentang Aplikasi</h2>
        <p>
            Pemrosesan server-side dinamis menggunakan PHP,
            array, perulangan, dan fungsi modular.
        </p>
    </div>

    <p>
        Aplikasi Sistem Informasi Data Mahasiswa (SIMA) digunakan
        untuk menampilkan, mencari, menambahkan, dan menghapus
        data mahasiswa. Data pada praktikum ini disimpan sementara
        menggunakan session PHP.
    </p>

    <div class="info-grid">
        <article class="info-card">
            <h3>Total Mahasiswa</h3>
            <p class="counter-highlight"><?= $total_semua ?></p>
        </article>

        <article class="info-card">
            <h3>Tahun Akademik</h3>
            <p>2025/2026</p>
        </article>

        <article class="info-card">
            <h3>Teknologi Aktif</h3>
            <p>HTML5 + CSS + PHP</p>
        </article>
    </div>
</section>

<!-- Daftar mahasiswa -->
<section id="daftar-mahasiswa" class="content-section">
    <div class="section-header">
        <h2>Daftar Mahasiswa Aktif</h2>
        <p>Data mahasiswa ditampilkan secara dinamis oleh PHP.</p>
    </div>

    <!-- Form pencarian -->
    <div class="table-toolbar">
        <form action="index.php#daftar-mahasiswa"
              method="get"
              class="search-form">

            <input
                type="search"
                name="search"
                class="search-input"
                placeholder="Cari NPM, nama, atau program studi..."
                value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>"
            >

            <button type="submit" class="btn btn-primary btn-sm">
                Cari
            </button>

            <?php if ($keyword !== ''): ?>
                <a href="index.php#daftar-mahasiswa"
                   class="btn btn-secondary btn-sm">
                    Reset
                </a>
            <?php endif; ?>
        </form>

        <div class="status-summary">
            <?php if ($keyword !== ''): ?>
                Ditemukan <?= $total_tampil ?>
                dari <?= $total_semua ?> mahasiswa.
            <?php else: ?>
                Menampilkan <?= $total_semua ?> mahasiswa.
            <?php endif; ?>
        </div>
    </div>

    <!-- Tabel mahasiswa -->
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>NPM</th>
                    <th>Nama Lengkap</th>
                    <th>Program Studi</th>
                    <th>Angkatan</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($daftar_mahasiswa)): ?>
                    <tr>
                        <td colspan="8" class="empty-row">
                            <?php if ($keyword !== ''): ?>
                                Data dengan kata kunci
                                "<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>"
                                tidak ditemukan.
                            <?php else: ?>
                                Belum ada data mahasiswa.
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php else: ?>

                    <?php foreach ($daftar_mahasiswa as $index => $mhs): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>

                            <td>
                                <img
                                    src="img/avatar-default.svg"
                                    alt="Foto mahasiswa"
                                    class="avatar-img"
                                    width="36"
                                    height="36"
                                >
                            </td>

                            <td>
                                <strong>
                                    <?= htmlspecialchars($mhs['npm'], ENT_QUOTES, 'UTF-8') ?>
                                </strong>
                            </td>

                            <td>
                                <?= htmlspecialchars($mhs['nama'], ENT_QUOTES, 'UTF-8') ?>
                            </td>

                            <td>
                                <span class="badge">
                                    <?= htmlspecialchars($mhs['program_studi'], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </td>

                            <td><?= (int) $mhs['angkatan'] ?></td>

                            <td>
                                <a
                                    href="mailto:<?= htmlspecialchars($mhs['email'], ENT_QUOTES, 'UTF-8') ?>"
                                    class="link-email"
                                >
                                    <?= htmlspecialchars($mhs['email'], ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            </td>

                            <td>
                                <form
                                    action="proses_hapus.php"
                                    method="post"
                                    onsubmit="return confirm('Yakin ingin menghapus data mahasiswa ini?');"
                                >
                                    <input
                                        type="hidden"
                                        name="npm"
                                        value="<?= htmlspecialchars($mhs['npm'], ENT_QUOTES, 'UTF-8') ?>"
                                    >

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                    >
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Form tambah mahasiswa -->
<section id="form-tambah" class="content-section">
    <div class="section-header">
        <h2>Tambah Mahasiswa Baru</h2>
        <p>Lengkapi formulir berikut untuk menambahkan data mahasiswa.</p>
    </div>

    <form action="proses_tambah.php"
          method="post"
          class="app-form">

        <fieldset>
            <legend>Data Identitas Mahasiswa</legend>

            <div class="form-grid">
                <div class="form-group">
                    <label for="npm" class="form-label">
                        Nomor Induk Mahasiswa (NPM)
                    </label>

                    <input
                        type="text"
                        id="npm"
                        name="npm"
                        class="form-input"
                        placeholder="Contoh: 230101003"
                        required
                        pattern="[0-9]{8,12}"
                    >

                    <span class="form-help">NPM harus terdiri dari 8–12 digit angka.</span>
                </div>

                <div class="form-group">
                    <label for="nama" class="form-label">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        class="form-input"
                        placeholder="Contoh: Ahmad Fauzi"
                        required
                        minlength="3"
                    >
                </div>

                <div class="form-group">
                    <label for="program_studi" class="form-label">
                        Program Studi
                    </label>

                    <select
                        id="program_studi"
                        name="program_studi"
                        class="form-select"
                        required
                    >
                        <option value="">-- Pilih Program Studi --</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Sistem Informasi">Sistem Informasi</option>
                        <option value="Teknologi Informasi">Teknologi Informasi</option>
                        <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="angkatan" class="form-label">
                        Tahun Angkatan
                    </label>

                    <input
                        type="number"
                        id="angkatan"
                        name="angkatan"
                        class="form-input"
                        placeholder="Contoh: 2024"
                        required
                        min="2018"
                        max="2026"
                    >
                </div>

                <div class="form-group full-width">
                    <label for="email" class="form-label">
                        Alamat Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input"
                        placeholder="Contoh: mahasiswa@example.com"
                        required
                    >
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Simpan Data Mahasiswa
                </button>

                <button type="reset" class="btn btn-secondary">
                    Reset Formulir
                </button>
            </div>
        </fieldset>
    </form>
</section>

<?php
// Tampilkan footer.
require_once __DIR__ . '/includes/footer.php';
?>
