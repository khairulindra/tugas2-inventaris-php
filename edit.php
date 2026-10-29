<?php
require_once 'includes/init.php';
wajib_login();


$id = filter_var($_GET['id'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($id === false) {
    set_flash('error', t('err_id'));
    header("Location: index.php");
    exit;
}


$stmt = mysqli_prepare($koneksi, "SELECT kode_barang, nama_barang, kategori, jumlah, harga, lokasi FROM barang WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$data) {
    set_flash('error', t('err_tidak_ada'));
    header("Location: index.php");
    exit;
}

$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cek_csrf();

    $data['kode_barang'] = trim($_POST['kode_barang'] ?? '');
    $data['nama_barang'] = trim($_POST['nama_barang'] ?? '');
    $data['kategori']    = trim($_POST['kategori'] ?? '');
    $data['jumlah']      = trim($_POST['jumlah'] ?? '');
    $data['harga']       = trim($_POST['harga'] ?? '');
    $data['lokasi']      = trim($_POST['lokasi'] ?? '');

    $error = validasi_barang($data, $koneksi, $id);

    // UPDATE
    if (empty($error)) {
        $jumlah = (int)$data['jumlah'];
        $harga  = (int)$data['harga'];

        $stmt = mysqli_prepare($koneksi,
            "UPDATE barang SET kode_barang = ?, nama_barang = ?, kategori = ?, jumlah = ?, harga = ?, lokasi = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssiisi",
            $data['kode_barang'], $data['nama_barang'], $data['kategori'], $jumlah, $harga, $data['lokasi'], $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        set_flash('success', t('sukses_ubah'));
        header("Location: index.php");
        exit;
    }
}

$judul_halaman = t('edit_barang');
require 'includes/header.php';
?>

<div class="card card-form">
    <h2><?= e(t('edit_barang')) ?></h2>
    <?php require 'includes/form_barang.php'; ?>
</div>

<?php require 'includes/footer.php'; ?>
