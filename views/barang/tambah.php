<div class="container mt-4">
    <h3>Tambah Barang Baru</h3>
    <hr>
    
    <form action="<?= BASEURL; ?>/barang/store" method="post">
        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="qty" class="form-label">Kuantitas</label>
                <input type="number" class="form-control" id="qty" name="qty" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="satuan" class="form-label">Satuan (Contoh: Buah, Unit, Set)</label>
                <input type="text" class="form-control" id="satuan" name="satuan" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="jenis_id" class="form-label">Jenis Barang</label>
            <select class="form-select" id="jenis_id" name="jenis_id">
                <?php foreach ($data['jenis'] as $jenis) : ?>
                    <option value="<?= $jenis['id']; ?>"><?= $jenis['nama_jenis']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="sumber_id" class="form-label">Sumber Barang (Hibah, Sponsor, Beli)</label>
            <select class="form-select" id="sumber_id" name="sumber_id">
                <?php foreach ($data['sumber'] as $sumber) : ?>
                    <option value="<?= $sumber['id']; ?>"><?= $sumber['nama_sumber']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
        </div>

        <a href="<?= BASEURL; ?>/barang" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Barang</button>
    </form>
</div>