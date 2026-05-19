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
    if (!empty($_POST['nomor_rekening']) && !empty($_POST['jumlah'])) {
        $_SESSION['form_result'] = [
            'success' => true,
            'message' => 'Penarikan sebesar Rp ' . number_format($_POST['jumlah'], 0, ',', '.') . ' berhasil diproses.'
        ];
    } else {
        $_SESSION['form_result'] = [
            'success' => false,
            'message' => 'Mohon lengkapi semua data!'
        ];
    }
    header('Location: ' . $_SERVER['PHP_SELF'] . '?page=penarikan');
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
        <label>Nomor Rekening</label>
        <input type="text" name="nomor_rekening" placeholder="Masukkan Nomor Rekening" required>
    </div>
    <div class="form-group">
        <label>Jumlah Penarikan (Rp)</label>
        <input type="number" name="jumlah" placeholder="Contoh: 50000" min="50000" required>
    </div>
    <div style="margin-top: 30px;">
        <button type="submit" class="btn btn-primary">💸 Proses Penarikan</button>
        <button type="reset" class="btn btn-secondary">↺ Batal</button>
    </div>
</form>
