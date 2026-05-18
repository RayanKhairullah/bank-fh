<?php require_once 'setting.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $site_name ?></title>
    <link rel="stylesheet" href="layout.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <!-- Ganti src dengan logo asli Anda -->
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Favicon_font_awesome.svg/1200px-Favicon_font_awesome.svg.png" alt="Logo">
            <h1><?= $site_name ?></h1>
        </div>
    </header>

    <div class="container">
        <!-- Menu Kiri -->
        <aside class="sidebar-left">
            <h3>Menu</h3>
            <nav>
                <a href="?page=home" class="<?= $page == 'home' ? 'active' : '' ?>">Beranda</a>
                <a href="?page=baru" class="<?= $page == 'baru' ? 'active' : '' ?>">Rekening Baru</a>
                <a href="?page=cetak-nasabah">Daftar Nasabah</a>
                <a href="?page=saldo">Cek Saldo</a>
                <a href="?page=setoran">Setoran</a>
                <a href="?page=penarikan">Penarikan</a>
                <a href="?page=transfer">Transfer</a>
                <a href="?page=riwayat">Riwayat Transaksi</a>
            </nav>
        </aside>

        <!-- Konten Utama (Dinamis) -->
        <main class="main-content">
            <h2><?= $view_title ?></h2>
            <?php if (file_exists($view_file)): ?>
                <?php include $view_file; ?>
            <?php else: ?>
                <p style="color:red;">Halaman tidak ditemukan.</p>
            <?php endif; ?>
        </main>

        <!-- Sidebar Kanan -->
        <aside class="sidebar-right">
            <div class="card">
                <h3>Tentang Kami</h3>
                <p>Kami merupakan bank kampus terbesar di Indonesia. Saat ini kami sudah memiliki lebih dari 100 kantor cabang di seluruh Indonesia.</p>
            </div>
            <div class="card">
                <h3>Kantor Pusat</h3>
                <p>Gedung Fakultas Hukum Universitas Bengkulu<br>Jalan W.R. Supratman Kandang Limun, Bengkulu</p>
            </div>
            <div class="card">
                <h3>Hubungi Kami</h3>
                <p>📧 bankfhunib@gmail.com<br>📞 085188085088</p>
            </div>
        </aside>
    </div>
</body>
</html>