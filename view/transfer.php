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
        $rek_asal = $conn->real_escape_string($_POST['rekening_asal']);
        $rek_tujuan = $conn->real_escape_string($_POST['rekening_tujuan']);
        $jumlah = (float) $_POST['jumlah'];
        $keterangan = $conn->real_escape_string($_POST['keterangan'] ?? 'Transfer');
        
        if ($rek_asal === $rek_tujuan) {
            $_SESSION['form_result'] = [
                'success' => false,
                'message' => 'Rekening asal dan tujuan tidak boleh sama!'
            ];
        } else {
            // Cek rekening asal
            $cek_asal = $conn->query("SELECT saldo FROM nasabah WHERE nomor_rekening = '$rek_asal'");
            $cek_tujuan = $conn->query("SELECT saldo FROM nasabah WHERE nomor_rekening = '$rek_tujuan'");
            
            if ($cek_asal && $cek_asal->num_rows > 0 && $cek_tujuan && $cek_tujuan->num_rows > 0) {
                $row_asal = $cek_asal->fetch_assoc();
                $saldo_asal_awal = $row_asal['saldo'];
                
                $row_tujuan = $cek_tujuan->fetch_assoc();
                $saldo_tujuan_awal = $row_tujuan['saldo'];
                
                if ($saldo_asal_awal >= $jumlah) {
                    $saldo_asal_akhir = $saldo_asal_awal - $jumlah;
                    $saldo_tujuan_akhir = $saldo_tujuan_awal + $jumlah;
                    
                    $conn->begin_transaction();
                    try {
                        // Update saldo pengirim
                        $conn->query("UPDATE nasabah SET saldo = $saldo_asal_akhir WHERE nomor_rekening = '$rek_asal'");
                        // Update saldo penerima
                        $conn->query("UPDATE nasabah SET saldo = $saldo_tujuan_akhir WHERE nomor_rekening = '$rek_tujuan'");
                        
                        // Log transaksi pengirim
                        $conn->query("INSERT INTO transaksi (nomor_rekening, jenis_transaksi, keterangan, jumlah, saldo_akhir) VALUES ('$rek_asal', 'Transfer Keluar', 'Ke $rek_tujuan - $keterangan', $jumlah, $saldo_asal_akhir)");
                        // Log transaksi penerima
                        $conn->query("INSERT INTO transaksi (nomor_rekening, jenis_transaksi, keterangan, jumlah, saldo_akhir) VALUES ('$rek_tujuan', 'Transfer Masuk', 'Dari $rek_asal - $keterangan', $jumlah, $saldo_tujuan_akhir)");
                        
                        $conn->commit();
                        
                        $_SESSION['form_result'] = [
                            'success' => true,
                            'message' => 'Transfer sebesar Rp ' . number_format($jumlah, 0, ',', '.') . ' ke rekening ' . htmlspecialchars($rek_tujuan) . ' berhasil diproses.'
                        ];
                    } catch (Exception $e) {
                        $conn->rollback();
                        $_SESSION['form_result'] = [
                            'success' => false,
                            'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                        ];
                    }
                } else {
                    $_SESSION['form_result'] = [
                        'success' => false,
                        'message' => 'Saldo tidak mencukupi!'
                    ];
                }
            } else {
                $_SESSION['form_result'] = [
                    'success' => false,
                    'message' => 'Rekening asal atau tujuan tidak ditemukan!'
                ];
            }
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
