<?php

session_start();

// Bahasa bawaan: Indonesia
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'id';
}

require_once __DIR__ . '/koneksi.php';
require_once __DIR__ . '/bahasa.php';


function e($teks) {
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}

function wajib_login() {
    if (!isset($_SESSION['user_id'])) {
        set_flash('error', t('harus_login'));
        header("Location: login.php");
        exit;
    }
}

function set_flash($tipe, $pesan) {
    $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

function tampil_flash() {
    if (isset($_SESSION['flash'])) {
        $tipe  = $_SESSION['flash']['tipe'];
        $pesan = $_SESSION['flash']['pesan'];
        echo '<div class="alert alert-' . e($tipe) . '">' . e($pesan) . '</div>';
        unset($_SESSION['flash']);
    }
}

function buat_csrf() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function cek_csrf() {
    $token = $_POST['csrf'] ?? '';
    if (empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $token)) {
        die(t('err_csrf'));
    }
}

function daftar_kategori() {
    return [
        'elektronik' => 'kat_elektronik',
        'furnitur'   => 'kat_furnitur',
        'alat_tulis' => 'kat_alat_tulis',
        'peralatan'  => 'kat_peralatan',
        'lainnya'    => 'kat_lainnya',
    ];
}


function label_kategori($kode) {
    switch ($kode) {
        case 'elektronik': return t('kat_elektronik');
        case 'furnitur':   return t('kat_furnitur');
        case 'alat_tulis': return t('kat_alat_tulis');
        case 'peralatan':  return t('kat_peralatan');
        case 'lainnya':    return t('kat_lainnya');
        default:           return $kode;
    }
}

function validasi_barang($data, $koneksi, $id_abaikan = 0) {
    $error = [];

    if ($data['kode_barang'] === '') {
        $error['kode_barang'] = t('err_kode_kosong');
    } elseif (!preg_match('/^[A-Za-z0-9-]{3,20}$/', $data['kode_barang'])) {
        $error['kode_barang'] = t('err_kode_format');
    } else {
        $stmt = mysqli_prepare($koneksi, "SELECT id FROM barang WHERE kode_barang = ? AND id <> ?");
        mysqli_stmt_bind_param($stmt, "si", $data['kode_barang'], $id_abaikan);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error['kode_barang'] = t('err_kode_ada');
        }
        mysqli_stmt_close($stmt);
    }


    if ($data['nama_barang'] === '') {
        $error['nama_barang'] = t('err_nama_kosong');
    } elseif (mb_strlen($data['nama_barang']) > 100) {
        $error['nama_barang'] = t('err_nama_panjang');
    }

    switch ($data['kategori']) {
        case 'elektronik':
        case 'furnitur':
        case 'alat_tulis':
        case 'peralatan':
        case 'lainnya':
            break; // valid
        default:
            $error['kategori'] = t('err_kategori');
    }

    $opsi = ['options' => ['min_range' => 0]];
    if (filter_var($data['jumlah'], FILTER_VALIDATE_INT, $opsi) === false) {
        $error['jumlah'] = t('err_jumlah');
    }
    if (filter_var($data['harga'], FILTER_VALIDATE_INT, $opsi) === false) {
        $error['harga'] = t('err_harga');
    }


    if ($data['lokasi'] === '') {
        $error['lokasi'] = t('err_lokasi_kosong');
    }

    return $error;
}
