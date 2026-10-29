<?php
require_once 'includes/init.php';
wajib_login();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

cek_csrf();

$id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($id === false) {
    set_flash('error', t('err_id'));
    header("Location: index.php");
    exit;
}


$stmt = mysqli_prepare($koneksi, "DELETE FROM barang WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    set_flash('success', t('sukses_hapus'));
} else {
    set_flash('error', t('err_tidak_ada'));
}
mysqli_stmt_close($stmt);

header("Location: index.php");
exit;
