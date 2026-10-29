<?php
require_once 'includes/init.php';
wajib_login();


$data = [
    'kode_barang' => '',
    'nama_barang' => '',
    'kategori'    => '',
    'jumlah'      => '0',
    'harga'       => '0',
    'lokasi'      => '',
];
$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cek_csrf();

    
    $data['kode_barang'] = trim($_POST['kode_barang'] ?? '');
    $data['nama_barang'] = trim($_POST['nama_barang'] ?? '');
    $data['kategori']    = trim($_POST['kategori'] ?? '');
    $data['jumlah']      = trim($_POST['jumlah'] ?? '');
    $data['harga']       = trim($_POST['harga'] ?? '');
    $data['lokasi']      = trim($_POST['lokasi'] ?? '');

    
    $error = validasi_barang($data, $koneksi);

    
    if (empty($error)) {
        $jumlah = (int)$data['jumlah'];
        $harga  = (int)$data['harga'];

        $stmt = mysqli_prepare($koneksi,
            "INSERT INTO barang (kode_barang, nama_barang, kategori, jumlah, harga, lokasi) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssiis",
            $data['kode_barang'], $data['nama_barang'], $data['kategori'], $jumlah, $harga, $data['lokasi']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        set_flash('success', t('sukses_tambah'));
        header("Location: index.php");
        exit;
    }
}

$judul_halaman = t('tambah_barang');
require 'includes/header.php';
?>

<div class="card card-form">
    <h2><?= e(t('tambah_barang')) ?></h2>
    <?php require 'includes/form_barang.php'; ?>
</div>

<?php require 'includes/footer.php'; ?>
