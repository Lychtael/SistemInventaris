<div class="container mt-4">
  <h3><?= $data['judul']; ?></h3>
  <hr>

  <?php Flasher::flash(); ?>

  <div class="d-flex justify-content-start mb-3">
  <a href="<?= BASEURL; ?>/barang/tambah" class="btn btn-success me-2">Tambah Barang</a>
  <a href="<?= BASEURL; ?>/barang/exportCsv" class="btn btn-success me-2">Export ke CSV</a>
    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#importModal">Import dari CSV</button>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <div class="row align-items-end">
        <div class="col-md-8">
          <form action="<?= BASEURL; ?>/barang" method="get" class="d-flex align-items-end">
            <div class="flex-grow-1 me-2">
              <label class="form-label">Filter berdasarkan:</label>
              <select name="jenis" class="form-select">
                <option value="">Semua Jenis</option>
                <?php foreach($data['jenis_list'] as $jenis): ?>
                  <option value="<?= $jenis['id']; ?>" <?= (($_GET['jenis'] ?? '') == $jenis['id']) ? 'selected' : ''; ?>>
                    <?= $jenis['nama_jenis']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="flex-grow-1 me-2">
              <label class="form-label">&nbsp;</label>
              <select name="sumber" class="form-select">
                <option value="">Semua Sumber</option>
                <?php foreach($data['sumber_list'] as $sumber): ?>
                  <option value="<?= $sumber['id']; ?>" <?= (($_GET['sumber'] ?? '') == $sumber['id']) ? 'selected' : ''; ?>>
                    <?= $sumber['nama_sumber']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="me-2">
              <button type="submit" class="btn btn-primary">Apply Filter</button>
            </div>
            <div>
              <a href="<?= BASEURL; ?>/barang" class="btn btn-secondary">Reset</a>
            </div>
          </form>
        </div>
        <div class="col-md-4">
          <label for="keyword" class="form-label">Cari Nama Barang  </label>
          <input type="text" class="form-control" placeholder="Mulai mengetik..." name="keyword" id="keyword" autocomplete="off">
        </div>
      </div>
    </div>
  </div>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Qty</th>
        <th>Satuan</th>
        <th>Jenis Barang</th>
        <th>Sumber Barang</th>
        <th>Keterangan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody id="table-body">
        <?php $no = $data['start_number']; // Gunakan nomor awal dari controller ?>
        <?php foreach($data['barang'] as $brg) : ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($brg['nama_barang']); ?></td>
            <td><?= htmlspecialchars($brg['qty']); ?></td>
            <td><?= htmlspecialchars($brg['satuan']); ?></td>
            <td><?= htmlspecialchars($brg['nama_jenis'] ?? '-'); ?></td>
            <td><?= htmlspecialchars($brg['nama_sumber'] ?? '-'); ?></td>
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
    </tbody>
  </table>
  <nav>
    <ul class="pagination justify-content-center">
        <li class="page-item <?= ($data['current_page'] <= 1) ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?= $data['current_page'] - 1; ?>">Previous</a>
        </li>

        <?php for($i = 1; $i <= $data['total_pages']; $i++): ?>
            <li class="page-item <?= ($i == $data['current_page']) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
            </li>
        <?php endfor; ?>
        
        <li class="page-item <?= ($data['current_page'] >= $data['total_pages']) ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?= $data['current_page'] + 1; ?>">Next</a>
        </li>
    </ul>
  </nav>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function() {
    $('#keyword').on('keyup', function() {
        let keyword = $(this).val();
        
        $.ajax({
            url: '<?= BASEURL; ?>/barang/cari',
            data: { keyword: keyword },
            method: 'post',
            success: function(data) {
                $('#table-body').html(data);
            }
        });
    });
});
</script>

<?php if (isset($_SESSION['csv_import_errors'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const errors = <?= json_encode($_SESSION['csv_import_errors']); ?>;
        const errorList = document.getElementById('errorList');
        
        errorList.innerHTML = '';
        errors.forEach(function(error) {
            let li = document.createElement('li');
            li.className = 'list-group-item';
            li.textContent = error;
            errorList.appendChild(li);
        });

        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    });
</script>
<?php 
    unset($_SESSION['csv_import_errors']); 
?>
<?php endif; ?>