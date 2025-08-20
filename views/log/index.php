<div class="container mt-4">
    <h3><?= $data['judul']; ?></h3>
    <hr>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Admin</th>
                <th>Aksi</th>
                <th>Tabel</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['log'] as $log) : ?>
            <tr>
                <td><?= date('d M Y, H:i:s', strtotime($log['created_at'])); ?></td>
                <td><?= htmlspecialchars($log['username']); ?></td>
                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($log['aksi']); ?></span></td>
                <td><?= htmlspecialchars($log['tabel']); ?></td>
                <td><?= htmlspecialchars($log['keterangan']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>