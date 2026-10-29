<?php
require_once 'includes/init.php';
wajib_login();


$hasil = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY kode_barang ASC");
$total = mysqli_num_rows($hasil);

$judul_halaman = t('daftar_barang');
require 'includes/header.php';
?>

<div class="card">
    <div class="card-head">
        <h2><?= e(t('daftar_barang')) ?></h2>
        <a href="tambah.php" class="btn">+ <?= e(t('tambah_barang')) ?></a>
    </div>

    <?php tampil_flash(); ?>

    <p class="info"><?= e(t('total_jenis')) ?>: <strong><?= $total ?></strong></p>

    <div class="tabel-wrap">
    <table>
        <thead>
            <tr>
                <th><?= e(t('no')) ?></th>
                <th><?= e(t('kode')) ?></th>
                <th><?= e(t('nama')) ?></th>
                <th><?= e(t('kategori')) ?></th>
                <th><?= e(t('jumlah')) ?></th>
                <th><?= e(t('harga')) ?></th>
                <th><?= e(t('lokasi')) ?></th>
                <th><?= e(t('aksi')) ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($total === 0): ?>
            <tr><td colspan="8" class="center"><?= e(t('data_kosong')) ?></td></tr>
        <?php else: ?>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($hasil)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= e($row['kode_barang']) ?></td>
                <td><?= e($row['nama_barang']) ?></td>
                <td><?= e(label_kategori($row['kategori'])) ?></td>
                <td class="right"><?= (int)$row['jumlah'] ?></td>
                <td class="right">Rp <?= number_format((int)$row['harga'], 0, ',', '.') ?></td>
                <td><?= e($row['lokasi']) ?></td>
                <td class="aksi">
                    <a href="edit.php?id=<?= (int)$row['id'] ?>" class="btn btn-small btn-warning"><?= e(t('ubah')) ?></a>
                 
                    <form method="POST" action="hapus.php" class="inline" onsubmit="return confirm('<?= e(t('konfirmasi_hapus')) ?>');">
                        <input type="hidden" name="csrf" value="<?= e(buat_csrf()) ?>">
                        <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                        <button type="submit" class="btn btn-small btn-danger"><?= e(t('hapus')) ?></button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>

<?php require 'includes/footer.php'; ?>


