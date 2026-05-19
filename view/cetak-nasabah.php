<div class="table-container">
    <div style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <input type="text" placeholder="Cari Nasabah..." style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            <button class="btn btn-secondary">🔍 Cari</button>
        </div>
        <button class="btn btn-primary" onclick="window.print()">🖨️ Cetak Data</button>
    </div>
    
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
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px;">RK202405101001</td>
                <td style="padding: 12px;">Ulnaya Bilatus Shita</td>
                <td style="padding: 12px;">P</td>
                <td style="padding: 12px;">083152803199</td>
                <td style="padding: 12px; text-align: right;">2,500,000</td>
            </tr>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px;">RK202405112304</td>
                <td style="padding: 12px;">Davina Tasya Alifya</td>
                <td style="padding: 12px;">P</td>
                <td style="padding: 12px;">0895385260012</td>
                <td style="padding: 12px; text-align: right;">1,250,000</td>
            </tr>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px;">RK202405121122</td>
                <td style="padding: 12px;">Tisatryann</td>
                <td style="padding: 12px;">P</td>
                <td style="padding: 12px;">089603790233</td>
                <td style="padding: 12px; text-align: right;">5,750,000</td>
            </tr>
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
    .btn, input {
        display: none !important;
    }
}
</style>
