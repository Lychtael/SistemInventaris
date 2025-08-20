<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Detail Barang</h3>
        </div>
        <div class="card-body">
            <h5 class="card-title"><?= $data['barang']['nama_barang']; ?></h5>
            <p class="card-text">
                <strong>Kuantitas:</strong> <?= $data['barang']['qty']; ?> <?= $data['barang']['satuan']; ?>
            </p>
            <p class="card-text">
                <strong>Jenis Barang:</strong> 
                <span class="badge bg-info"><?= $data['barang']['nama_jenis'] ?? 'Tidak ada'; ?></span>
            </p>
            <p class="card-text">
                <strong>Sumber Barang:</strong> 
                <span class="badge bg-success"><?= $data['barang']['nama_sumber'] ?? 'Tidak ada'; ?></span>
            </p>
            <p class="card-text">
                <strong>Keterangan:</strong>
                <br>
                <?= nl2br(htmlspecialchars($data['barang']['keterangan'] ?? 'Tidak ada keterangan.')); ?>
            </p>
            <p class="card-text">
                <small class="text-muted">
                    Data dibuat pada: <?= date('d M Y, H:i', strtotime($data['barang']['created_at'])); ?>
                </small>
            </p>
            
            <a href="<?= BASEURL; ?>/barang" class="btn btn-secondary mt-3">Kembali ke Daftar</a>
        </div>
    </div>
</div>