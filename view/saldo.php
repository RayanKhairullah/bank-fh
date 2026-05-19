<?php
$saldo = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['nomor_rekening'])) {
        // Dummy data for balance
        $saldo = rand(100000, 10000000);
    }
}
?>

<div style="max-width: 600px; margin: 0 auto;">
    <form action="" method="POST" style="margin-bottom: 30px;">
        <div class="form-group">
            <label>Nomor Rekening</label>
            <div style="display: flex; gap: 10px;">
                <input type="text" name="nomor_rekening" placeholder="Masukkan Nomor Rekening" required style="flex: 1;" value="<?= isset($_POST['nomor_rekening']) ? htmlspecialchars($_POST['nomor_rekening']) : '' ?>">
                <button type="submit" class="btn btn-primary">Cek</button>
            </div>
        </div>
    </form>

    <?php if ($saldo !== null): ?>
    <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; text-align: center;">
        <h3 style="color: #666; margin-bottom: 10px;">Informasi Saldo</h3>
        <p style="margin-bottom: 5px;">Nomor Rekening: <strong><?= htmlspecialchars($_POST['nomor_rekening']) ?></strong></p>
        <p style="margin-bottom: 15px;">Nama Nasabah: <strong>Nasabah Dummy</strong></p>
        <div style="background-color: #e9ecef; padding: 15px; border-radius: 8px; display: inline-block; min-width: 250px;">
            <span style="font-size: 14px; color: #666; display: block; margin-bottom: 5px;">Total Saldo Aktif</span>
            <span style="font-size: 24px; font-weight: bold; color: #28a745;">Rp <?= number_format($saldo, 0, ',', '.') ?></span>
        </div>
    </div>
    <?php endif; ?>
</div>
