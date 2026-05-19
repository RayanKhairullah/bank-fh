<?php
$show_history = false;
$transaksi = [];
$nama_nasabah = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['nomor_rekening'])) {
        $nomrek = $conn->real_escape_string($_POST['nomor_rekening']);
        
        $cek = $conn->query("SELECT nama_nasabah FROM nasabah WHERE nomor_rekening = '$nomrek'");
        if ($cek && $cek->num_rows > 0) {
            $row = $cek->fetch_assoc();
            $nama_nasabah = $row['nama_nasabah'];
            $show_history = true;
            
            $result = $conn->query("SELECT * FROM transaksi WHERE nomor_rekening = '$nomrek' ORDER BY tanggal DESC");
            if ($result) {
                while($t = $result->fetch_assoc()) {
                    $transaksi[] = $t;
                }
            }
        } else {
            $error = "Nomor Rekening tidak ditemukan!";
        }
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
            <?php if (isset($error)): ?>
                <p style="color: red; margin-top: 10px;"><?= $error ?></p>
            <?php endif; ?>
        </div>
    </form>

    <?php if ($show_history): ?>
    <div class="table-container">
        <h3 style="margin-bottom: 5px;">Riwayat Transaksi: <?= htmlspecialchars($_POST['nomor_rekening']) ?></h3>
        <p style="margin-bottom: 15px; color: #666;">Atas Nama: <?= htmlspecialchars($nama_nasabah) ?></p>
        
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
                <?php if (count($transaksi) > 0): ?>
                    <?php foreach ($transaksi as $t): ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 12px;"><?= date('d-m-Y H:i', strtotime($t['tanggal'])) ?></td>
                            <?php
                            $color = in_array($t['jenis_transaksi'], ['Setoran', 'Transfer Masuk']) ? '#28a745' : '#dc3545';
                            $sign = in_array($t['jenis_transaksi'], ['Setoran', 'Transfer Masuk']) ? '+' : '-';
                            ?>
                            <td style="padding: 12px; color: <?= $color ?>;"><?= $t['jenis_transaksi'] ?></td>
                            <td style="padding: 12px;"><?= htmlspecialchars($t['keterangan']) ?></td>
                            <td style="padding: 12px; text-align: right; color: <?= $color ?>;"><?= $sign . number_format($t['jumlah'], 0, ',', '.') ?></td>
                            <td style="padding: 12px; text-align: right;"><?= number_format($t['saldo_akhir'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="padding: 12px; text-align: center;">Belum ada riwayat transaksi.</td>
                    </tr>
                <?php endif; ?>
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
