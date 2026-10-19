
<?php
/**
 * File: includes/functions.php
 * Fungsi untuk mengelola data mahasiswa menggunakan session.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Inisialisasi data mahasiswa awal.
 */
function init_mahasiswa_session() {
    if (!isset($_SESSION['daftar_mahasiswa'])) {
        $_SESSION['daftar_mahasiswa'] = [
            [
                'npm' => '230101001',
                'nama' => 'Ahmad Fauzi',
                'program_studi' => 'Teknik Informatika',
                'angkatan' => 2023,
                'email' => 'ahmad.fauzi@example.com'
            ],
            [
                'npm' => '230101002',
                'nama' => 'Siti Nurhaliza',
                'program_studi' => 'Sistem Informasi',
                'angkatan' => 2023,
                'email' => 'siti.nurhaliza@example.com'
            ],
            [
                'npm' => '230101015',
                'nama' => 'Budi Santoso',
                'program_studi' => 'Teknologi Informasi',
                'angkatan' => 2023,
                'email' => 'budi.santoso@example.com'
            ]
        ];
    }
}

/**
 * Membersihkan input untuk ditampilkan dengan aman.
 */
function sanitize($data) {
    return htmlspecialchars(trim((string) $data), ENT_QUOTES, 'UTF-8');
}

/**
 * Mengambil data mahasiswa dan melakukan pencarian.
 */
function get_all_mahasiswa($keyword = '') {
    init_mahasiswa_session();

    $data = $_SESSION['daftar_mahasiswa'];
    $keyword = trim((string) $keyword);

    if ($keyword === '') {
        return $data;
    }

    $filtered = [];

    foreach ($data as $mhs) {
        if (
            stripos($mhs['npm'], $keyword) !== false ||
            stripos($mhs['nama'], $keyword) !== false ||
            stripos($mhs['program_studi'], $keyword) !== false
        ) {
            $filtered[] = $mhs;
        }
    }

    return $filtered;
}

/**
 * Menghitung jumlah mahasiswa.
 */
function count_total_mahasiswa() {
    init_mahasiswa_session();
    return count($_SESSION['daftar_mahasiswa']);
}

/**
 * Menambahkan mahasiswa baru.
 */
function tambah_mahasiswa($npm, $nama, $program_studi, $angkatan, $email) {
    init_mahasiswa_session();

    // Bersihkan input.
    $npm = trim((string) $npm);
    $nama = trim((string) $nama);
    $program_studi = trim((string) $program_studi);
    $angkatan = trim((string) $angkatan);
    $email = trim((string) $email);

    // Validasi kolom wajib.
    if (
        $npm === '' ||
        $nama === '' ||
        $program_studi === '' ||
        $angkatan === '' ||
        $email === ''
    ) {
        return [
            'status' => false,
            'message' => 'Semua kolom formulir wajib diisi!'
        ];
    }

    // Validasi NPM.
    if (!preg_match('/^[0-9]{8,12}$/', $npm)) {
        return [
            'status' => false,
            'message' => 'NPM harus berupa angka 8 hingga 12 digit!'
        ];
    }

    // Periksa duplikasi NPM.
    foreach ($_SESSION['daftar_mahasiswa'] as $mhs) {
        if ($mhs['npm'] === $npm) {
            return [
                'status' => false,
                'message' => 'NPM sudah terdaftar. Gunakan NPM lain!'
            ];
        }
    }

    // Validasi nama.
    if (strlen($nama) < 3) {
        return [
            'status' => false,
            'message' => 'Nama lengkap minimal 3 karakter!'
        ];
    }

    // Validasi program studi.
    $prodi_valid = [
        'Teknik Informatika',
        'Sistem Informasi',
        'Teknologi Informasi',
        'Rekayasa Perangkat Lunak'
    ];

    if (!in_array($program_studi, $prodi_valid, true)) {
        return [
            'status' => false,
            'message' => 'Program studi tidak valid!'
        ];
    }

    // Validasi tahun angkatan.
    if (
        !ctype_digit($angkatan) ||
        (int) $angkatan < 2018 ||
        (int) $angkatan > 2026
    ) {
        return [
            'status' => false,
            'message' => 'Tahun angkatan harus berada antara 2018 hingga 2026!'
        ];
    }

    // Validasi email.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [
            'status' => false,
            'message' => 'Format alamat email tidak valid!'
        ];
    }

    // Simpan data ke session.
    $_SESSION['daftar_mahasiswa'][] = [
        'npm' => $npm,
        'nama' => $nama,
        'program_studi' => $program_studi,
        'angkatan' => (int) $angkatan,
        'email' => $email
    ];

    return [
        'status' => true,
        'message' => 'Data mahasiswa ' . $nama . ' berhasil ditambahkan!'
    ];
}

/**
 * Menghapus mahasiswa berdasarkan NPM.
 */
function hapus_mahasiswa($npm) {
    init_mahasiswa_session();

    $npm = trim((string) $npm);

    foreach ($_SESSION['daftar_mahasiswa'] as $index => $mhs) {
        if ($mhs['npm'] === $npm) {
            $nama = $mhs['nama'];

            unset($_SESSION['daftar_mahasiswa'][$index]);

            // Susun ulang indeks array.
            $_SESSION['daftar_mahasiswa'] =
                array_values($_SESSION['daftar_mahasiswa']);

            return [
                'status' => true,
                'message' => 'Data mahasiswa ' . $nama . ' berhasil dihapus.'
            ];
        }
    }

    return [
        'status' => false,
        'message' => 'Data mahasiswa tidak ditemukan!'
    ];
}

/**
 * Menyimpan notifikasi sementara.
 */
function set_flash_message($type, $message) {
    $_SESSION['flash_message'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Mengambil notifikasi lalu menghapusnya.
 */
function get_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $flash;
    }

    return null;
}

// Inisialisasi data ketika file fungsi dipanggil.
init_mahasiswa_session();
