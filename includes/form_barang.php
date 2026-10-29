<?php

?>
<form method="POST" action="" novalidate>
    <input type="hidden" name="csrf" value="<?= e(buat_csrf()) ?>">

    <div class="form-group">
        <label for="kode_barang"><?= e(t('kode')) ?></label>
        <input type="text" id="kode_barang" name="kode_barang" value="<?= e($data['kode_barang']) ?>" placeholder="BRG-006">
        <?php if (isset($error['kode_barang'])): ?><small class="error"><?= e($error['kode_barang']) ?></small><?php endif; ?>
    </div>

    <div class="form-group">
        <label for="nama_barang"><?= e(t('nama')) ?></label>
        <input type="text" id="nama_barang" name="nama_barang" value="<?= e($data['nama_barang']) ?>">
        <?php if (isset($error['nama_barang'])): ?><small class="error"><?= e($error['nama_barang']) ?></small><?php endif; ?>
    </div>

    <div class="form-group">
        <label for="kategori"><?= e(t('kategori')) ?></label>
        <select id="kategori" name="kategori">
            <option value=""><?= e(t('pilih_kategori')) ?></option>
            <?php foreach (daftar_kategori() as $kode => $kunci): ?>
                <option value="<?= e($kode) ?>" <?= $data['kategori'] === $kode ? 'selected' : '' ?>>
                    <?= e(t($kunci)) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($error['kategori'])): ?><small class="error"><?= e($error['kategori']) ?></small><?php endif; ?>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="jumlah"><?= e(t('jumlah')) ?></label>
            <input type="number" id="jumlah" name="jumlah" min="0" value="<?= e($data['jumlah']) ?>">
            <?php if (isset($error['jumlah'])): ?><small class="error"><?= e($error['jumlah']) ?></small><?php endif; ?>
        </div>
        <div class="form-group">
            <label for="harga"><?= e(t('harga')) ?> (Rp)</label>
            <input type="number" id="harga" name="harga" min="0" value="<?= e($data['harga']) ?>">
            <?php if (isset($error['harga'])): ?><small class="error"><?= e($error['harga']) ?></small><?php endif; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="lokasi"><?= e(t('lokasi')) ?></label>
        <input type="text" id="lokasi" name="lokasi" value="<?= e($data['lokasi']) ?>">
        <?php if (isset($error['lokasi'])): ?><small class="error"><?= e($error['lokasi']) ?></small><?php endif; ?>
    </div>

    <button type="submit" class="btn"><?= e(t('simpan')) ?></button>
    <a href="index.php" class="btn btn-gray"><?= e(t('batal')) ?></a>
</form>
