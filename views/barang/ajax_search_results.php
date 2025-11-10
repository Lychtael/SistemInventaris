<?php $no = 1; ?>
<?php foreach($data['barang'] as $brg) : ?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $brg['nama_barang']; ?></td>
    <td><?= $brg['jumlah']; ?></td>
    <td><?= $brg['satuan']; ?></td>
    <td><?= $brg['nama_jenis'] ?? '-'; ?></td>
    <td><?= $brg['nama_sumber'] ?? '-'; ?></td>
    <td>
        <?php 
            $keterangan = $brg['keterangan'];
            if (strlen($keterangan) > 40) {
                echo htmlspecialchars(substr($keterangan, 0, 40)) . '...';
            } else {
                echo htmlspecialchars($keterangan ?? '-');
            }
        ?>
    </td>
    <td>
        <a href="<?= BASEURL; ?>/barang/detail/<?= $brg['id']; ?>" class="btn btn-sm btn-info">Detail</a>
        <a href="<?= BASEURL; ?>/barang/edit/<?= $brg['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
        <a href="<?= BASEURL; ?>/barang/hapus/<?= $brg['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?');">Hapus</a>
    </td>
</tr>
<?php endforeach; ?>