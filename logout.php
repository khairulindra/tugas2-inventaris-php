<?php
require_once 'includes/init.php';


unset($_SESSION['user_id'], $_SESSION['nama_lengkap']);
session_regenerate_id(true);

set_flash('success', t('logout_sukses'));
header("Location: login.php");
exit;
