<?php

$host = "localhost";
$user = "root";
$pass = "";
$nama_db = "db_inventaris";

$koneksi = mysqli_connect($host, $user, $pass, $nama_db);


if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, "utf8mb4");
