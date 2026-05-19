<?php
// Start session untuk flash message
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah ada pesan dari session (POST-Redirect-GET pattern)
$show_modal = false;
$success = false;
$message = '';

if (isset($_SESSION['form_result'])) {
    $show_modal = true;
    $success = $_SESSION['form_result']['success'];
    $message = $_SESSION['form_result']['message'];
    unset($_SESSION['form_result']); // Hapus setelah ditampilkan
}

// Proses form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    if (!empty($_POST['nama_nasabah']) && 
        !empty($_POST['nomor_identitas']) && 
        !empty($_POST['jenis_kelamin']) && 
        !empty($_POST['tanggal_lahir']) && 
        !empty($_POST['alamat']) && 
        !empty($_POST['nomor_telepon']) && 
        !empty($_POST['pekerjaan'])) {
        
        // Validasi Nomor Identitas hanya angka
        if (!preg_match('/^\d{10,16}$/', $_POST['nomor_identitas'])) {
            $_SESSION['form_result'] = [
                'success' => false,
                'message' => 'Nomor identitas hanya boleh berisi angka (10-16 digit)!'
            ];
        }
        // Validasi Nomor Telepon hanya angka
        elseif (!preg_match('/^\d{10,12}$/', $_POST['nomor_telepon'])) {
            $_SESSION['form_result'] = [
                'success' => false,
                'message' => 'Nomor telepon hanya boleh berisi angka (10-12 digit)!'
            ];
        }
        // Validasi Tanggal Lahir minimal 16 tahun
        else {
            $tanggal_lahir = new DateTime($_POST['tanggal_lahir']);
            $hari_ini = new DateTime('today');
            $umur = $hari_ini->diff($tanggal_lahir)->y;
            
            if ($umur < 16) {
                $_SESSION['form_result'] = [
                    'success' => false,
                    'message' => 'Usia minimal untuk membuat rekening adalah 16 tahun!'
                ];
            } else {
                $nomrek = $conn->real_escape_string($_POST['nomor_rekening']);
                $nama = $conn->real_escape_string($_POST['nama_nasabah']);
                $nik = $conn->real_escape_string($_POST['nomor_identitas']);
                $jk = $conn->real_escape_string($_POST['jenis_kelamin']);
                $tgl_lahir = $conn->real_escape_string($_POST['tanggal_lahir']);
                $alamat = $conn->real_escape_string($_POST['alamat']);
                $telp = $conn->real_escape_string($_POST['nomor_telepon']);
                $pekerjaan = $conn->real_escape_string($_POST['pekerjaan']);
                
                $sql = "INSERT INTO nasabah (nomor_rekening, nama_nasabah, nomor_identitas, jenis_kelamin, tanggal_lahir, alamat, nomor_telepon, pekerjaan) 
                        VALUES ('$nomrek', '$nama', '$nik', '$jk', '$tgl_lahir', '$alamat', '$telp', '$pekerjaan')";
                
                if ($conn->query($sql)) {
                    $_SESSION['form_result'] = [
                        'success' => true,
                        'message' => 'Rekening baru berhasil dibuat! Nomor rekening Anda: ' . $nomrek
                    ];
                } else {
                    $_SESSION['form_result'] = [
                        'success' => false,
                        'message' => 'Gagal menyimpan ke database: ' . $conn->error
                    ];
                }
            }
        }
    } else {
        $_SESSION['form_result'] = [
            'success' => false,
            'message' => 'Mohon lengkapi semua data dengan benar!'
        ];
    }
    
    // Redirect ke halaman yang sama (POST-Redirect-GET pattern)
    header('Location: ' . $_SERVER['PHP_SELF'] . (isset($_GET['page']) ? '?page=' . $_GET['page'] : ''));
    exit();
}

// Generate nomor rekening otomatis
$nomor_rekening = 'RK' . date('YmdHis') . rand(100, 999);
?>

<!-- Modal/Popup -->
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
            <button class="btn btn-primary" onclick="closeModal()">
                <?= $success ? 'Buat Rekening Baru' : 'Coba Lagi' ?>
            </button>
        </div>
    </div>
</div>

<script>
function closeModal() {
    document.getElementById('modalOverlay').style.display = 'none';
    document.body.style.overflow = 'auto'; // Enable scroll kembali
    
    <?php if ($success): ?>
    // Reset form setelah sukses
    const form = document.querySelector('form');
    if (form) {
        form.reset();
        // Generate nomor rekening baru
        const nomor_rekening = 'RK' + new Date().toISOString().slice(0,19).replace(/[:-]/g, '') + Math.floor(Math.random() * 900 + 100);
        document.getElementById('nomor_rekening_display').value = nomor_rekening;
    }
    <?php endif; ?>
}

// Close modal ketika click di luar
document.getElementById('modalOverlay').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Close modal dengan tombol ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && document.getElementById('modalOverlay').style.display !== 'none') {
        closeModal();
    }
});

// Auto show modal
window.addEventListener('DOMContentLoaded', function() {
    document.body.style.overflow = 'hidden'; // Disable scroll saat modal terbuka
});
</script>
<?php endif; ?>

<form action="" method="POST" onsubmit="return validateForm(event)">
    <div class="form-group">
        <label>Nomor Rekening</label>
        <input type="text" id="nomor_rekening_display" name="nomor_rekening" value="<?= $nomor_rekening ?>" readonly style="background-color: #f5f5f5; cursor: not-allowed;">
    </div>
    
    <div class="form-group">
        <label>Nama Nasabah <span style="color: red;">*</span></label>
        <input type="text" name="nama_nasabah" placeholder="Contoh: Budi Santoso" required>
    </div>
    
    <div class="form-group">
        <label>Nomor Identitas <span style="color: red;">*</span></label>
        <input type="text" name="nomor_identitas" placeholder="Contoh: 1234567890123456" maxlength="16" inputmode="numeric" pattern="[0-9]*" title="Hanya angka yang diperbolehkan" required>
    </div>
    
    <div class="form-group">
        <label>Jenis Kelamin <span style="color: red;">*</span></label>
        <select name="jenis_kelamin" required>
            <option value="">--- Pilih Jenis Kelamin ---</option>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        </select>
    </div>
    
    <div class="form-group">
        <label>Tanggal Lahir <span style="color: red;">*</span></label>
        <input type="date" name="tanggal_lahir" required>
    </div>
    
    <div class="form-group">
        <label>Alamat <span style="color: red;">*</span></label>
        <textarea name="alamat" placeholder="Contoh: Jln. Merdeka No. 123, Bengkulu" required></textarea>
    </div>
    
    <div class="form-group">
        <label>Nomor Telepon <span style="color: red;">*</span></label>
        <input type="tel" name="nomor_telepon" placeholder="Contoh: 085123456789" pattern="[0-9]*" inputmode="numeric" maxlength="12" title="Hanya angka yang diperbolehkan" required>
    </div>
    
    <div class="form-group">
        <label>Pekerjaan <span style="color: red;">*</span></label>
        <input type="text" name="pekerjaan" placeholder="Contoh: Mahasiswa" required>
    </div>
    
    <div style="margin-top: 30px;">
        <button type="submit" class="btn btn-primary">💾 Simpan</button>
        <button type="reset" class="btn btn-secondary">↺ Batal</button>
    </div>
</form>

<script>
function validateForm(event) {
    const form = event.target;
    const nama = form.nama_nasabah.value.trim();
    const nomor_identitas = form.nomor_identitas.value.trim();
    const jenis_kelamin = form.jenis_kelamin.value;
    const tanggal_lahir = form.tanggal_lahir.value;
    const alamat = form.alamat.value.trim();
    const telepon = form.nomor_telepon.value.trim();
    const pekerjaan = form.pekerjaan.value.trim();
    
    // Validasi semua field terisi
    if (!nama || !nomor_identitas || !jenis_kelamin || !tanggal_lahir || !alamat || !telepon || !pekerjaan) {
        alert('⚠️ Mohon lengkapi semua data terlebih dahulu!');
        return false;
    }
    
    // Validasi Nomor Identitas hanya angka
    if (!/^\d+$/.test(nomor_identitas)) {
        alert('⚠️ Nomor identitas hanya boleh berisi angka!');
        form.nomor_identitas.focus();
        return false;
    }
    
    if (nomor_identitas.length < 10) {
        alert('⚠️ Nomor identitas harus minimal 10 digit!');
        form.nomor_identitas.focus();
        return false;
    }
    
    // Validasi Nomor Telepon hanya angka
    if (!/^\d+$/.test(telepon)) {
        alert('⚠️ Nomor telepon hanya boleh berisi angka!');
        form.nomor_telepon.focus();
        return false;
    }
    
    if (telepon.length < 10) {
        alert('⚠️ Nomor telepon harus minimal 10 digit!');
        form.nomor_telepon.focus();
        return false;
    }
    
    // Validasi Tanggal Lahir minimal 16 tahun
    const birthDate = new Date(tanggal_lahir);
    const today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    
    if (age < 16) {
        alert('⚠️ Usia minimal untuk membuat rekening adalah 16 tahun! Usia Anda saat ini: ' + age + ' tahun');
        form.tanggal_lahir.focus();
        return false;
    }
    
    return true;
}

// Prevent non-numeric input untuk Nomor Identitas
document.addEventListener('DOMContentLoaded', function() {
    const nomor_identitas = document.querySelector('input[name="nomor_identitas"]');
    const nomor_telepon = document.querySelector('input[name="nomor_telepon"]');
    
    // Filter Nomor Identitas
    if (nomor_identitas) {
        nomor_identitas.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
    
    // Filter Nomor Telepon
    if (nomor_telepon) {
        nomor_telepon.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
});

// Generate nomor rekening baru setiap kali form di-reset
document.querySelector('form').addEventListener('reset', function() {
    setTimeout(() => {
        const nomor_rekening = 'RK' + new Date().toISOString().slice(0,19).replace(/[:-]/g, '') + Math.floor(Math.random() * 900 + 100);
        document.getElementById('nomor_rekening_display').value = nomor_rekening;
    }, 10);
});
</script>