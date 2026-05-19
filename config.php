<?php
$site_name = "Bank FH - Universitas Bengkulu";
$base_url  = "http://localhost/coding/";

// Database Configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'bankfh';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Koneksi Database Gagal: " . $conn->connect_error);
}

// Auto Create Tables if not exist
$sql_nasabah = "CREATE TABLE IF NOT EXISTS nasabah (
    nomor_rekening VARCHAR(20) PRIMARY KEY,
    nama_nasabah VARCHAR(100) NOT NULL,
    nomor_identitas VARCHAR(20) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    tanggal_lahir DATE NOT NULL,
    alamat TEXT NOT NULL,
    nomor_telepon VARCHAR(15) NOT NULL,
    pekerjaan VARCHAR(50) NOT NULL,
    saldo DECIMAL(15,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql_nasabah);

$sql_transaksi = "CREATE TABLE IF NOT EXISTS transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor_rekening VARCHAR(20) NOT NULL,
    jenis_transaksi ENUM('Setoran', 'Penarikan', 'Transfer Masuk', 'Transfer Keluar') NOT NULL,
    keterangan VARCHAR(255),
    jumlah DECIMAL(15,2) NOT NULL,
    saldo_akhir DECIMAL(15,2) NOT NULL,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nomor_rekening) REFERENCES nasabah(nomor_rekening) ON DELETE CASCADE
)";
$conn->query($sql_transaksi);
?>