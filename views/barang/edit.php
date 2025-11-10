<div class="container mt-4">
    <h3>Edit Data Barang</h3>
    <hr>

    <form action="<?= BASEURL; ?>/barang/update" method="post">
        <input type="hidden" name="id" value="<?= $data['barang']['id']; ?>">

        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= $data['barang']['nama_barang']; ?>" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="jumlah" class="form-label">Kuantitas</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= $data['barang']['jumlah']; ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="satuan" class="form-label">Satuan (Contoh: Buah, Unit, Set)</label>
                <input type="text" class="form-control" id="satuan" name="satuan" value="<?= $data['barang']['satuan']; ?>" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="id_jenis" class="form-label">Jenis Barang</label>
            <select class="form-select" id="id_jenis" name="id_jenis">
                <?php foreach ($data['jenis'] as $jenis) : ?>
                    <option value="<?= $jenis['id']; ?>" <?= ($data['barang']['id_jenis'] == $jenis['id']) ? 'selected' : ''; ?>>
                        <?= $jenis['nama_jenis']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="id_sumber" class="form-label">Sumber Barang</label>
            <select class="form-select" id="id_sumber" name="id_sumber">
                <?php foreach ($data['sumber'] as $sumber) : ?>
                    <option value="<?= $sumber['id']; ?>" <?= ($data['barang']['id_sumber'] == $sumber['id']) ? 'selected' : ''; ?>>
                        <?= $sumber['nama_sumber']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= $data['barang']['keterangan']; ?></textarea>
        </div>

        <a href="<?= BASEURL; ?>/barang" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Update Data</button>
    </form>
</div>