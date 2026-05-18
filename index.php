<?php require_once 'setting.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $site_name ?></title>
    <link rel="icon" href="images/logo.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="images/logo.png" alt="Logo Bank FH" class="logo">
        <h1>Bank FH - Universitas Bengkulu</h1>
    </div>

    <!-- Container Utama -->
    <div class="container">
        <!-- Menu Kiri -->
        <aside class="sidebar-left">
            <h3>Menu</h3>
            <nav>
                <a href="?page=home" class="<?= $page == 'home' ? 'active' : '' ?>">Beranda</a>
                <a href="?page=baru" class="<?= $page == 'baru' ? 'active' : '' ?>">Rekening Baru</a>
                <a href="?page=cetak-nasabah" class="<?= $page == 'cetak-nasabah' ? 'active' : '' ?>">Daftar Nasabah</a>
                <a href="?page=saldo" class="<?= $page == 'saldo' ? 'active' : '' ?>">Cek Saldo</a>
                <a href="?page=setoran" class="<?= $page == 'setoran' ? 'active' : '' ?>">Setoran</a>
                <a href="?page=penarikan" class="<?= $page == 'penarikan' ? 'active' : '' ?>">Penarikan</a>
                <a href="?page=transfer" class="<?= $page == 'transfer' ? 'active' : '' ?>">Transfer</a>
                <a href="?page=riwayat" class="<?= $page == 'riwayat' ? 'active' : '' ?>">Riwayat Transaksi</a>
            </nav>
        </aside>

        <!-- Konten Utama -->
        <main class="main-content">
            <h2><?= $view_title ?></h2>
            <?php if (file_exists($view_file)): ?>
                <?php include $view_file; ?>
            <?php else: ?>
                <?php include 'view/coming-soon.php'; ?>
            <?php endif; ?>
        </main>

        <!-- Sidebar Kanan -->
        <aside class="sidebar-right">
            <h3>Tentang Kami</h3>
            <p>Kami merupakan bank kampus terbesar di Indonesia. Saat ini kami sudah memiliki lebih dari 100 kantor cabang di seluruh Indonesia</p>
            
            <h3>Kantor Pusat</h3>
            <p>Gedung Fakultas Hukum Universitas Bengkulu<br>
            Jalan W.R. Supratman Kandang Limun, Bengkulu</p>
            
            <h3>Hubungi Kami</h3>
            <div class="contact-info">
                <p>
                    <i class="fab fa-google" style="color: #EA4335; margin-right: 8px; width: 20px; text-align: center;"></i> 
                    <a href="mailto:bankfhunib@gmail.com" style="color: #333; text-decoration: none;">bankfhunib@gmail.com</a>
                </p>
                <p>
                    <i class="fab fa-whatsapp" style="color: #25D366; margin-right: 8px; width: 20px; text-align: center;"></i> 
                    <a href="https://wa.me/6285188085088" target="_blank" style="color: #333; text-decoration: none;">085188085088</a>
                </p>
                <p>
                    <i class="fas fa-globe" style="color: #4285F4; margin-right: 8px; width: 20px; text-align: center;"></i> 
                    <a href="https://fh.unib.ac.id" target="_blank" style="color: #333; text-decoration: none;">fh.unib.ac.id</a>
                </p>
            </div>
        </aside>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>📋 Tentang Bank FH</h3>
                <p>Bank FH adalah institusi keuangan kampus yang berkomitmen untuk melayani kebutuhan finansial mahasiswa dan staf Universitas Bengkulu dengan profesional dan terpercaya.</p>
            </div>
            <div class="footer-section">
                <h3>🏢 Lokasi Kantor</h3>
                <p>Gedung Fakultas Hukum<br>Universitas Bengkulu<br>Jalan W.R. Supratman<br>Kandang Limun, Bengkulu</p>
            </div>
            <div class="footer-section">
                <h3>📞 Hubungi Kami</h3>
                <p>
                    <i class="fab fa-google" style="color: #EA4335; margin-right: 8px;"></i>
                    Email: <a href="mailto:bankfhunib@gmail.com" style="color: #e0e0e0; text-decoration: none;">bankfhunib@gmail.com</a><br>
                    
                    <i class="fab fa-whatsapp" style="color: #25D366; margin-right: 8px;"></i>
                    WhatsApp: <a href="https://wa.me/6285188085088" target="_blank" style="color: #e0e0e0; text-decoration: none;">085188085088</a><br>
                    
                    <i class="fas fa-globe" style="color: #4285F4; margin-right: 8px;"></i>
                    Website: <a href="https://fh.unib.ac.id" target="_blank" style="color: #e0e0e0; text-decoration: none;">fh.unib.ac.id</a><br>
                    
                    ⏰ Jam Operasional:<br>Senin-Jumat: 08:00-16:00 WIB
                </p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Bank FH | Universitas Bengkulu | Semua Hak Dilindungi</p>
        </div>
    </footer>
</body>
</html>