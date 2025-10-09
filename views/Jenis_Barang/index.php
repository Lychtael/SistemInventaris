<div class="container mt-4">
    <h3>Data Jenis Barang</h3>
    <?php Flasher::flash(); ?>
    <hr>
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#formModal">
      Tambah Jenis Barang
    </button>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Nama Jenis</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($data['jenis_barang'] as $jb) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $jb['nama_jenis']; ?></td>
                <td>
                    <a href="<?= BASEURL; ?>/jenisbarang/ubah/<?= $jb['id']; ?>" class="btn btn-sm btn-warning tampilModalUbah" data-bs-toggle="modal" data-bs-target="#formModal" data-id="<?= $jb['id']; ?>">Edit</a>
                    <a href="<?= BASEURL; ?>/jenisbarang/hapus/<?= $jb['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?');">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="judulModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="judulModal">Tambah Jenis Barang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= BASEURL; ?>/jenisbarang/tambah" method="post">
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label for="nama_jenis">Nama Jenis</label>
            <input type="text" class="form-control" id="nama_jenis" name="nama_jenis" required>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
$(function() {
    $('.tampilModalUbah').on('click', function() {
        $('#judulModal').html('Ubah Data Jenis Barang');
        $('.modal-body form').attr('action', '<?= BASEURL; ?>/jenisbarang/ubah');

        const id = $(this).data('id');

        $.ajax({
            url: '<?= BASEURL; ?>/jenisbarang/getubah',
            data: {id : id},
            method: 'post',
            dataType: 'json',
            success: function(data) {
                $('#nama_jenis').val(data.nama_jenis);
                $('#id').val(data.id);
            }
        });
    });

    // Reset modal saat tombol tambah di-klik
    $('.btn-primary[data-bs-target="#formModal"]').on('click', function() {
        $('#judulModal').html('Tambah Jenis Barang');
        $('.modal-body form').attr('action', '<?= BASEURL; ?>/jenisbarang/tambah');
        $('#nama_jenis').val('');
        $('#id').val('');
    });
});
</script>