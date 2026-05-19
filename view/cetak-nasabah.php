<div class="table-container">
    <form action="" method="GET" style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
        <input type="hidden" name="page" value="cetak-nasabah">
        <div style="display: flex; gap: 10px;">
            <input type="text" name="search" placeholder="Cari Nasabah (Nama/No. Rek)..." style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit" class="btn btn-secondary">🔍 Cari</button>
            <?php if(isset($_GET['search']) && $_GET['search'] != ''): ?>
                <a href="?page=cetak-nasabah" class="btn btn-secondary" style="text-decoration:none;">Reset</a>
            <?php endif; ?>
        </div>
        <button type="button" class="btn btn-primary" onclick="window.print()">🖨️ Cetak Data</button>
    </form>
    
    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                <th style="padding: 12px; text-align: left;">No. Rekening</th>
                <th style="padding: 12px; text-align: left;">Nama Nasabah</th>
                <th style="padding: 12px; text-align: left;">L/P</th>
                <th style="padding: 12px; text-align: left;">Telepon</th>
                <th style="padding: 12px; text-align: right;">Saldo (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
            $query = "SELECT nomor_rekening, nama_nasabah, jenis_kelamin, nomor_telepon, saldo FROM nasabah";
            
            if (!empty($search)) {
                $query .= " WHERE nama_nasabah LIKE '%$search%' OR nomor_rekening LIKE '%$search%'";
            }
            
            $query .= " ORDER BY created_at DESC";
            
            $result = $conn->query($query);
            
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<tr style="border-bottom: 1px solid #eee;">';
                    echo '<td style="padding: 12px;">' . htmlspecialchars($row['nomor_rekening']) . '</td>';
                    echo '<td style="padding: 12px;">' . htmlspecialchars($row['nama_nasabah']) . '</td>';
                    echo '<td style="padding: 12px;">' . htmlspecialchars($row['jenis_kelamin']) . '</td>';
                    echo '<td style="padding: 12px;">' . htmlspecialchars($row['nomor_telepon']) . '</td>';
                    echo '<td style="padding: 12px; text-align: right;">' . number_format($row['saldo'], 0, ',', '.') . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5" style="padding: 12px; text-align: center;">Tidak ada data nasabah.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .main-content, .main-content * {
        visibility: visible;
    }
    .main-content {
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
