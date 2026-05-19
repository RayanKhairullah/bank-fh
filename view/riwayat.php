<?php
$show_history = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['nomor_rekening'])) {
        $show_history = true;
    }
}
?>

<div style="max-width: 800px; margin: 0 auto;">
    <form action="" method="POST" style="margin-bottom: 30px;">
        <div class="form-group">
            <label>Nomor Rekening</label>
            <div style="display: flex; gap: 10px;">
                <input type="text" name="nomor_rekening" placeholder="Masukkan Nomor Rekening" required style="flex: 1;" value="<?= isset($_POST['nomor_rekening']) ? htmlspecialchars($_POST['nomor_rekening']) : '' ?>">
                <button type="submit" class="btn btn-primary">Cari Riwayat</button>
            </div>
        </div>
    </form>

    <?php if ($show_history): ?>
    <div class="table-container">
        <h3 style="margin-bottom: 15px;">Riwayat Transaksi: <?= htmlspecialchars($_POST['nomor_rekening']) ?></h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 12px; text-align: left;">Tanggal</th>
                    <th style="padding: 12px; text-align: left;">Jenis Transaksi</th>
                    <th style="padding: 12px; text-align: left;">Keterangan</th>
                    <th style="padding: 12px; text-align: right;">Jumlah (Rp)</th>
                    <th style="padding: 12px; text-align: right;">Saldo Akhir (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;">19-05-2024 10:30</td>
                    <td style="padding: 12px; color: #28a745;">Setoran Tunai</td>
                    <td style="padding: 12px;">Setoran awal</td>
                    <td style="padding: 12px; text-align: right; color: #28a745;">+5,000,000</td>
                    <td style="padding: 12px; text-align: right;">5,000,000</td>
                </tr>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;">20-05-2024 14:15</td>
                    <td style="padding: 12px; color: #dc3545;">Tarik Tunai</td>
                    <td style="padding: 12px;">ATM Cabang Utama</td>
                    <td style="padding: 12px; text-align: right; color: #dc3545;">-500,000</td>
                    <td style="padding: 12px; text-align: right;">4,500,000</td>
                </tr>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;">22-05-2024 09:00</td>
                    <td style="padding: 12px; color: #dc3545;">Transfer Keluar</td>
                    <td style="padding: 12px;">Ke RK12345678</td>
                    <td style="padding: 12px; text-align: right; color: #dc3545;">-1,000,000</td>
                    <td style="padding: 12px; text-align: right;">3,500,000</td>
                </tr>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;">25-05-2024 16:45</td>
                    <td style="padding: 12px; color: #28a745;">Transfer Masuk</td>
                    <td style="padding: 12px;">Dari RK87654321</td>
                    <td style="padding: 12px; text-align: right; color: #28a745;">+250,000</td>
                    <td style="padding: 12px; text-align: right;">3,750,000</td>
                </tr>
            </tbody>
        </table>
        
        <div style="margin-top: 20px; text-align: right;">
            <button class="btn btn-secondary" onclick="window.print()">🖨️ Cetak Riwayat</button>
        </div>
    </div>
    
    <style>
    @media print {
        body * {
            visibility: hidden;
        }
        .table-container, .table-container * {
            visibility: visible;
        }
        .table-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .btn, form {
            display: none !important;
        }
    }
    </style>
    <?php endif; ?>
</div>
