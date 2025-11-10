<div class="container mt-4">
    <h3>Catat Peminjaman Baru</h3>
    <hr>

    <?php Flasher::flash(); ?>
    <form action="<?= BASEURL; ?>/peminjaman/store" method="post">
        <div class="mb-3">
            <label for="id_barang" class="form-label">Pilih Barang</label>
            <select class="form-select" id="id_barang" name="id_barang" required>
                <option value="" disabled selected>-- Pilih Barang --</option>
                <?php foreach ($data['barang'] as $barang) : ?>
                    <option value="<?= $barang['id']; ?>">(Stok: <?= $barang['jumlah']; ?>) <?= $barang['nama_barang']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="peminjam" class="form-label">Nama Peminjam</label>
            <input type="text" class="form-control" id="peminjam" name="peminjam" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="jumlah_dipinjam" class="form-label">Jumlah Pinjam</label>
                <input type="number" class="form-control" id="jumlah_dipinjam" name="jumlah_dipinjam" required min="1">
            </div>
            <div class="col-md-6 mb-3">
                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="<?= date('Y-m-d'); ?>" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
        </div>

        <a href="<?= BASEURL; ?>/peminjaman" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>