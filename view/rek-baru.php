<form action="" method="post">
    <label>Nomor Rekening</label>
    <input type="text" name="norek" value="Otomatis (Backend)" readonly style="background:#f1f5f9; color:#777;">

    <label>Nama Nasabah</label>
    <input type="text" name="nama" required>

    <label>Nomor Identitas</label>
    <input type="text" name="nik" required>

    <label>Jenis Kelamin</label>
    <select name="jk">
        <option value="">-- Pilih --</option>
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </select>

    <label>Tanggal Lahir</label>
    <input type="date" name="tgl_lahir" required>

    <label>Alamat</label>
    <textarea name="alamat" rows="3" required></textarea>

    <label>Nomor Telepon</label>
    <input type="tel" name="telp" required>

    <label>Pekerjaan</label>
    <input type="text" name="pekerjaan">

    <button type="submit">💾 Simpan Data</button>
</form>