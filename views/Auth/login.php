<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $data['judul']; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

  <div class="card shadow-lg border-0 rounded-4" style="max-width: 400px; width: 100%;">
    <div class="card-body p-4 text-center">

      <!-- Judul -->
      <h5 class="fw-bold text-uppercase mb-4">Sistem Inventaris<br>HMTIF-UNPAS</h5>

      <!-- Logo -->
      <div class="mb-4">
        <img src="../img/Logo-HMTIF.png" alt="Logo HMTIF" class="img-fluid" style="max-width:120px;">
      </div>

      <!-- Flash message -->
      <?php Flasher::flash(); ?>

      <!-- Form -->
      <form action="<?= BASEURL; ?>/auth/prosesLogin" method="post">
        <div class="mb-3 text-start">
          <label for="username" class="form-label fw-semibold">Username</label>
          <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-4 text-start">
          <label for="password" class="form-label fw-semibold">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 fw-bold text-uppercase">Login</button>
      </form>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
