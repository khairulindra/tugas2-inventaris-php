<?php

$lang_aktif = $_SESSION['lang'];
?>
<!DOCTYPE html>
<html lang="<?= e($lang_aktif) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judul_halaman ?? t('judul_app')) ?> | <?= e(t('judul_app')) ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<nav class="navbar">
    <div class="brand"><?= e(t('judul_app')) ?></div>
    <div class="nav-right">
        <span class="lang">
            <a href="ganti_bahasa.php?lang=id" class="<?= $lang_aktif === 'id' ? 'aktif' : '' ?>">ID</a> |
            <a href="ganti_bahasa.php?lang=en" class="<?= $lang_aktif === 'en' ? 'aktif' : '' ?>">EN</a>
        </span>
        <?php if (isset($_SESSION['user_id'])): ?>
            <span><?= e(t('halo')) ?>, <strong><?= e($_SESSION['nama_lengkap']) ?></strong></span>
            <a href="logout.php" class="btn btn-small btn-gray"><?= e(t('logout')) ?></a>
        <?php endif; ?>
    </div>
</nav>
<main class="container">