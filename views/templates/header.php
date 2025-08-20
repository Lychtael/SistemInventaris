<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg border-bottom" style="background-color:rgb(255, 255, 255);" data-bs-theme="light">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="<?= BASEURL; ?>/dashboard">
        <img src="<?= BASEURL; ?>/img/Logo-HMTIF.png" alt="Logo Himpunan" style="height: 40px;" class="me-3">
        <div>
            <span class="navbar-brand-main">HMTIF - UNPAS</span>
            <span class="navbar-brand-sub">Sistem Inventaris</span>
        </div>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link text-success" href="<?= BASEURL; ?>/dashboard">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-success" href="<?= BASEURL; ?>/barang">Barang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-success" href="<?= BASEURL; ?>/jenisbarang">Jenis Barang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-success" href="<?= BASEURL; ?>/sumberbarang">Sumber Barang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-success" href="<?= BASEURL; ?>/peminjaman">Peminjaman</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-success" href="<?= BASEURL; ?>/log">Riwayat Aktivitas</a>
            </li>
        </ul>

        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item d-flex align-items-center">
                <span class="navbar-text me-3 text-success">
                    Halo, <?= $_SESSION['username']; ?>
                </span>
                <a href="<?= BASEURL; ?>/auth/logout" class="btn btn-sm btn-danger">Logout</a>
            </li>
        </ul>
    </div>
  </div>
</nav>