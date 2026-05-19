<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$show_modal = false;
$success = false;
$message = '';

if (isset($_SESSION['form_result'])) {
    $show_modal = true;
    $success = $_SESSION['form_result']['success'];
    $message = $_SESSION['form_result']['message'];
    unset($_SESSION['form_result']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['rekening_asal']) && !empty($_POST['rekening_tujuan']) && !empty($_POST['jumlah'])) {
        if ($_POST['rekening_asal'] === $_POST['rekening_tujuan']) {
            $_SESSION['form_result'] = [
                'success' => false,
                'message' => 'Rekening asal dan tujuan tidak boleh sama!'
            ];
        } else {
            $_SESSION['form_result'] = [
                'success' => true,
                'message' => 'Transfer sebesar Rp ' . number_format($_POST['jumlah'], 0, ',', '.') . ' ke rekening ' . htmlspecialchars($_POST['rekening_tujuan']) . ' berhasil diproses.'
            ];
        }
    } else {
        $_SESSION['form_result'] = [
            'success' => false,
            'message' => 'Mohon lengkapi semua data!'
        ];
    }
    header('Location: ' . $_SERVER['PHP_SELF'] . '?page=transfer');
    exit();
}
?>

<?php if ($show_modal): ?>
<div class="modal-overlay" id="modalOverlay">
    <div class="modal-content <?= $success ? 'modal-success' : 'modal-error' ?>">
        <div class="modal-header">
            <button class="modal-close" onclick="closeModal()" title="Tutup">&times;</button>
            <span class="modal-icon"><?= $success ? '✓' : '⚠' ?></span>
        </div>
        <div class="modal-body">
            <h3><?= $success ? 'Berhasil!' : 'Gagal!' ?></h3>
            <p><?= $message ?></p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" onclick="closeModal()">OK</button>
        </div>
    </div>
</div>
<script>
function closeModal() {
    document.getElementById('modalOverlay').style.display = 'none';
}
</script>
<?php endif; ?>

<form action="" method="POST" style="max-width: 600px; margin: 0 auto;">
    <div class="form-group">
        <label>Nomor Rekening Asal</label>
        <input type="text" name="rekening_asal" placeholder="Masukkan Nomor Rekening Asal" required>
    </div>
    <div class="form-group">
        <label>Nomor Rekening Tujuan</label>
        <input type="text" name="rekening_tujuan" placeholder="Masukkan Nomor Rekening Tujuan" required>
    </div>
    <div class="form-group">
        <label>Jumlah Transfer (Rp)</label>
        <input type="number" name="jumlah" placeholder="Contoh: 150000" min="10000" required>
    </div>
    <div class="form-group">
        <label>Berita / Keterangan (Opsional)</label>
        <input type="text" name="keterangan" placeholder="Contoh: Pembayaran Kost">
    </div>
    <div style="margin-top: 30px;">
        <button type="submit" class="btn btn-primary">↔️ Proses Transfer</button>
        <button type="reset" class="btn btn-secondary">↺ Batal</button>
    </div>
</form>
