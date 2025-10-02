<div class="container mt-4">
  <h3>Import Data Barang dari CSV</h3>
  <hr>

  <?php Flasher::flash(); ?>

  <form action="<?= BASEURL; ?>/barang/importCsv" method="post" enctype="multipart/form-data">
      <div class="mb-3">
          <label for="csv_file" class="form-label">Pilih File CSV</label>
          <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
      </div>
      <a href="<?= BASEURL; ?>/barang" class="btn btn-secondary">Batal</a>
      <button type="submit" class="btn btn-primary">Upload</button>
  </form>
</div>
