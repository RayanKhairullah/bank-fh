<?php
require_once 'config.php';

// Ambil parameter dari URL, default ke 'home'
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Mapping URL ke file view (sesuaikan dengan screenshot)
$route = [
    'home'       => 'home.php',
    'baru'       => 'rek-baru.php', // ?page=baru akan load rek-baru.php
    'cetak-nasabah' => 'cetak-nasabah.php',
    'saldo'      => 'saldo.php',
    'setoran'    => 'setoran.php',
    'penarikan'  => 'penarikan.php',
    'transfer'   => 'transfer.php',
    'riwayat'    => 'riwayat.php'
];

// Keamanan: cegah directory traversal
$file = isset($route[$page]) ? $route[$page] : 'home.php';
$view_file = "view/{$file}";

// Tentukan judul halaman
$titles = [
    'home' => 'Selamat datang',
    'baru' => 'Tambah Rekening Baru',
    'cetak-nasabah' => 'Daftar Nasabah',
    'saldo' => 'Cek Saldo',
    'setoran' => 'Setor Tunai',
    'penarikan' => 'Tarik Tunai',
    'transfer' => 'Transfer Antar Rekening',
    'riwayat' => 'Riwayat Transaksi'
];
$view_title = $titles[$page] ?? ucfirst(str_replace('-', ' ', $page));
?>