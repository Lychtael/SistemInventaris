<div class="container mt-4">
    <h3>Data Peminjaman</h3>
    <?php Flasher::flash(); ?>
    <hr>
    <a href="<?= BASEURL; ?>/peminjaman/create" class="btn btn-success mb-3">Catat Peminjaman Baru</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Peminjam</th>
                <th>Qty</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($data['peminjaman'] as $pinjam) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $pinjam['nama_barang']; ?></td>
                <td><?= $pinjam['peminjam']; ?></td>
                <td><?= $pinjam['qty_dipinjam']; ?></td>
                <td><?= date('d M Y', strtotime($pinjam['tanggal_pinjam'])); ?></td>
                <td><?= $pinjam['tanggal_kembali'] ? date('d M Y', strtotime($pinjam['tanggal_kembali'])) : '-'; ?></td>
                <td>
                    <?php if ($pinjam['status'] == 'dipinjam'): ?>
                        <span class="badge bg-danger">Dipinjam</span>
                    <?php else: ?>
                        <span class="badge bg-success">Dikembalikan</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($pinjam['status'] == 'dipinjam'): ?>
                        <a href="<?= BASEURL; ?>/peminjaman/kembali/<?= $pinjam['id']; ?>" class="btn btn-sm btn-success">Kembalikan</a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>