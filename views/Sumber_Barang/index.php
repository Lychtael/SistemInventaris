<div class="container mt-4">
    <h3>Data Sumber Barang</h3>
    <?php Flasher::flash(); ?>
    <hr>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#formModal">
      Tambah Sumber Barang
    </button>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Nama Sumber</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($data['sumber_barang'] as $sb) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $sb['nama_sumber']; ?></td>
                <td>
                    <a href="<?= BASEURL; ?>/sumberbarang/ubah/<?= $sb['id']; ?>" class="btn btn-sm btn-warning tampilModalUbah" data-bs-toggle="modal" data-bs-target="#formModal" data-id="<?= $sb['id']; ?>">Edit</a>
                    <a href="<?= BASEURL; ?>/sumberbarang/hapus/<?= $sb['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?');">Hapus</a>
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
        <h5 class="modal-title" id="judulModal">Tambah Sumber Barang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= BASEURL; ?>/sumberbarang/tambah" method="post">
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label for="nama_sumber">Nama Sumber</label>
            <input type="text" class="form-control" id="nama_sumber" name="nama_sumber">
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
    // Script untuk UBAH data
    $('.tampilModalUbah').on('click', function() {
        $('#judulModal').html('Ubah Data Sumber Barang');
        $('.modal-body form').attr('action', '<?= BASEURL; ?>/sumberbarang/ubah'); // <-- DIUBAH
        const id = $(this).data('id');
        $.ajax({
            url: '<?= BASEURL; ?>/sumberbarang/getubah', // <-- DIUBAH
            data: {id : id},
            method: 'post',
            dataType: 'json',
            success: function(data) {
                $('#nama_sumber').val(data.nama_sumber); // <-- DIUBAH
                $('#id').val(data.id);
            }
        });
    });

    // Script untuk reset modal TAMBAH data
    $('button[data-bs-target="#formModal"]').on('click', function() {
        $('#judulModal').html('Tambah Sumber Barang');
        $('.modal-body form').attr('action', '<?= BASEURL; ?>/sumberbarang/tambah'); // <-- DIUBAH
        $('#nama_sumber').val(''); // <-- DIUBAH
        $('#id').val('');
    });
});
</script>