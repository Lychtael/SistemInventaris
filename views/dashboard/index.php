<div class="container mt-4">
    <h3>Dashboard Inventaris</h3>
    <hr>
    
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Semua Barang</h5>
                    <p class="card-text fs-4 fw-bold"><?= $data['total_barang']['total']; ?> Unit</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-white bg-danger shadow">
                <div class="card-body">
                    <h5 class="card-title">Barang Habis (Stok 0)</h5>
                    <p class="card-text fs-4 fw-bold"><?= $data['barang_habis']['total']; ?> Jenis</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    Barang Berdasarkan Jenis
                </div>
                <ul class="list-group list-group-flush">
                    <?php if (empty($data['barang_by_jenis'])): ?>
                        <li class="list-group-item">Data tidak ditemukan.</li>
                    <?php else: ?>
                        <?php foreach ($data['barang_by_jenis'] as $jenis) : ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= $jenis['nama_jenis']; ?>
                                <span class="badge bg-primary rounded-pill"><?= $jenis['jumlah']; ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    Barang Berdasarkan Sumber
                </div>
                <ul class="list-group list-group-flush">
                    <?php if (empty($data['barang_by_sumber'])): ?>
                        <li class="list-group-item">Data tidak ditemukan.</li>
                    <?php else: ?>
                        <?php foreach ($data['barang_by_sumber'] as $sumber) : ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= $sumber['nama_sumber']; ?>
                                <span class="badge bg-success rounded-pill"><?= $sumber['jumlah']; ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>