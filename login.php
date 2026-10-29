<?php
require_once 'includes/init.php';


if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cek_csrf();

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';


    if ($username === '') {
        $error['username'] = t('username_kosong');
    }
    if ($password === '') {
        $error['password'] = t('password_kosong');
    }

    // Kalau lengkap, cek ke database
    if (empty($error)) {
        $stmt = mysqli_prepare($koneksi, "SELECT id, password, nama_lengkap FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($hasil);
        mysqli_stmt_close($stmt);

        if ($user && password_verify($password, $user['password'])) {

            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            header("Location: index.php");
            exit;
        } else {
            $error['umum'] = t('login_gagal');
        }
    }
}

$judul_halaman = t('login');
require 'includes/header.php';
?>

<div class="card card-login">
    <h2><?= e(t('judul_login')) ?></h2>

    <?php tampil_flash(); ?>
    <?php if (isset($error['umum'])): ?>
        <div class="alert alert-error"><?= e($error['umum']) ?></div>
    <?php endif; ?>

    <form method="POST" action="" novalidate>
        <input type="hidden" name="csrf" value="<?= e(buat_csrf()) ?>">

        <div class="form-group">
            <label for="username"><?= e(t('username')) ?></label>
            <input type="text" id="username" name="username" value="<?= e($username) ?>" autofocus>
            <?php if (isset($error['username'])): ?><small class="error"><?= e($error['username']) ?></small><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password"><?= e(t('password')) ?></label>
            <input type="password" id="password" name="password">
            <?php if (isset($error['password'])): ?><small class="error"><?= e($error['password']) ?></small><?php endif; ?>
        </div>

        <button type="submit" class="btn btn-full"><?= e(t('login')) ?></button>
    </form>
</div>

<?php require 'includes/footer.php'; ?>
