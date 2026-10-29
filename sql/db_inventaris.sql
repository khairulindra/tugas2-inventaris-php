-- Database untuk Sistem Informasi Inventaris Barang
-- Cara pakai: import file ini lewat phpMyAdmin / HeidiSQL (Laragon)

CREATE DATABASE IF NOT EXISTS db_inventaris
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_inventaris;

DROP TABLE IF EXISTS barang;
DROP TABLE IF EXISTS users;

-- Tabel pengguna (untuk login)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nama_lengkap VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Tabel data barang (CRUD)
CREATE TABLE barang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode_barang VARCHAR(20) NOT NULL UNIQUE,
  nama_barang VARCHAR(100) NOT NULL,
  kategori VARCHAR(30) NOT NULL,
  jumlah INT NOT NULL DEFAULT 0,
  harga INT NOT NULL DEFAULT 0,
  lokasi VARCHAR(100) NOT NULL,
  dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Akun default: username = admin | password = admin123
INSERT INTO users (username, password, nama_lengkap) VALUES
('admin', '$2y$10$/IynmPLQinzn1wngkJROzOy60Vi7a5Qx0bPAxeDKvZCCzcXlAyVKa', 'Administrator');

-- Data contoh
INSERT INTO barang (kode_barang, nama_barang, kategori, jumlah, harga, lokasi) VALUES
('BRG-001', 'Laptop Lenovo ThinkPad', 'elektronik', 5, 9500000, 'Ruang IT'),
('BRG-002', 'Proyektor Epson', 'elektronik', 2, 6200000, 'Ruang Rapat'),
('BRG-003', 'Kursi Kantor Ergonomis', 'furnitur', 20, 850000, 'Lantai 2'),
('BRG-004', 'Spidol Whiteboard (Box)', 'alat_tulis', 15, 45000, 'Gudang ATK'),
('BRG-005', 'Printer Canon', 'peralatan', 3, 1800000, 'Ruang Admin');
