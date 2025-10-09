<?php

class BarangController extends Controller {
    public function __construct()
    {
        // Cek jika user belum login
        if (!isset($_SESSION['is_login'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index()
    {
        $data['judul'] = 'Daftar Barang';
        
        // Pagination Logic
        $limit = 25;
        $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
        $offset = ($page > 1) ? ($page * $limit) - $limit : 0;
        
        // Prepare params for model
        $params = [
            'limit' => $limit,
            'offset' => $offset,
            'jenis_id' => $_GET['jenis'] ?? null,
            'sumber_id' => $_GET['sumber'] ?? null,
            'sort' => $_GET['sort'] ?? 'id',
            'direction' => $_GET['direction'] ?? 'desc'
        ];
    
        $total_records = $this->model('Barang_model')->countAllBarang($params);
        $data['total_pages'] = ceil($total_records / $limit);
        $data['current_page'] = $page;
        $data['start_number'] = $offset + 1;
        
        $data['barang'] = $this->model('Barang_model')->getAllBarang($params);
        
        $data['jenis_list'] = $this->model('Barang_model')->getAllJenis();
        $data['sumber_list'] = $this->model('Barang_model')->getAllSumber();
        $data['current_filters'] = $params;
    
        $this->view('templates/header', $data);
        $this->view('barang/index', $data);
        $this->view('templates/footer');
    }
    public function cari()
    {
        $data['barang'] = $this->model('Barang_model')->cariDataBarang();
        $this->view('barang/ajax_search_results', $data); // View partial
    }
    public function tambah() {
        $data['judul'] = 'Tambah Barang';
        $data['jenis'] = $this->model('Barang_model')->getAllJenis();
        $data['sumber'] = $this->model('Barang_model')->getAllSumber();
        
        $this->view('templates/header', $data);
        $this->view('barang/tambah', $data);
        $this->view('templates/footer');
    }
    public function store() {
        // Validasi 1: Pastikan kolom wajib tidak kosong
        if (empty(trim($_POST['nama_barang'])) || empty(trim($_POST['qty'])) || empty(trim($_POST['satuan']))) {
            Flasher::setFlash('Gagal', 'Data tidak lengkap. Semua kolom wajib diisi.', 'danger');
            header('Location: ' . BASEURL . '/barang/tambah');
            exit;
        }

        // Validasi 2: Kuantitas harus minimal 1
        if ((int)$_POST['qty'] <= 0) {
            Flasher::setFlash('Gagal', 'Kuantitas tidak valid. Jumlah minimal adalah 1.', 'danger');
            header('Location: ' . BASEURL . '/barang/tambah');
            exit;
        }

        if ($this->model('Barang_model')->tambahDataBarang($_POST) > 0) {
            $this->model('Log_model')->catatLog('TAMBAH', 'barang', "Menambah barang baru: " . htmlspecialchars($_POST['nama_barang']));
            Flasher::setFlash('Data Barang', 'berhasil ditambahkan.', 'success');
        } else {
            Flasher::setFlash('Data Barang', 'gagal ditambahkan.', 'danger');
        }
        header('Location: ' . BASEURL . '/barang');
        exit;
    }
    public function edit($id)
    {
        $data['judul'] = 'Edit Barang';
        $data['barang'] = $this->model('Barang_model')->getBarangById($id);
        $data['jenis'] = $this->model('Barang_model')->getAllJenis();
        $data['sumber'] = $this->model('Barang_model')->getAllSumber();
        
        $this->view('templates/header', $data);
        $this->view('barang/edit', $data);
        $this->view('templates/footer');
    }
    public function update() {
        if ($this->model('Barang_model')->updateDataBarang($_POST) > 0) {
            $this->model('Log_model')->catatLog('UBAH', 'barang', "Mengubah data barang: " . htmlspecialchars($_POST['nama_barang']));
            Flasher::setFlash('Data Barang', 'berhasil diubah.', 'success');
        } else {
            Flasher::setFlash('Data Barang', 'gagal diubah.', 'danger');
        }
        header('Location: ' . BASEURL . '/barang');
        exit;
    }
 
    public function hapus($id) {
        $barang = $this->model('Barang_model')->getBarangById($id);
        if ($this->model('Barang_model')->hapusDataBarang($id) > 0) {
            $this->model('Log_model')->catatLog('HAPUS', 'barang', "Menghapus barang: " . htmlspecialchars($barang['nama_barang']));
            Flasher::setFlash('Data Barang', 'berhasil dihapus.', 'success');
        } else {
            Flasher::setFlash('Data Barang', 'gagal dihapus.', 'danger');
        }
        header('Location: ' . BASEURL . '/barang');
        exit;
    }
    public function detail($id)
    {
        $data['judul'] = 'Detail Barang';
        $data['barang'] = $this->model('Barang_model')->getDetailBarangById($id);
        $this->view('templates/header', $data);
        $this->view('barang/detail', $data);
        $this->view('templates/footer');
    }
    public function exportCsv()
    {
        $data_barang = $this->model('Barang_model')->getAllBarangWithDetails();

        // Set header untuk file download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="data_barang_' . date('Y-m-d') . '.csv"');

        // Buka output stream
        $output = fopen('php://output', 'w');

        // Tulis header kolom
        fputcsv($output, array('Nama Barang', 'Kuantitas', 'Satuan', 'Jenis', 'Sumber', 'Keterangan'));

        // Tulis data barang
        foreach ($data_barang as $barang) {
            fputcsv($output, $barang);
        }

        fclose($output);
        exit();
    }

    // app/controllers/BarangController.php

    public function importCsv()
    {
        if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] != 0) {
            Flasher::setFlash('Import Gagal', 'Tidak ada file yang diunggah atau terjadi error.', 'danger');
            header('Location: ' . BASEURL . '/barang');
            exit;
        }
    
        $file = $_FILES['csv_file']['tmp_name'];
        $handle = fopen($file, "r");
    
        if ($handle === false) {
            Flasher::setFlash('Import Gagal', 'Tidak bisa membaca file CSV.', 'danger');
            header('Location: ' . BASEURL . '/barang');
            exit;
        }
    
        // --- Ambil header CSV
        $headers = fgetcsv($handle, 1000, ",");
        if (!$headers) {
            Flasher::setFlash('Import Gagal', 'File CSV kosong atau header tidak valid.', 'danger');
            header('Location: ' . BASEURL . '/barang');
            exit;
        }
    
        // --- Mapping header agar fleksibel
        $headerMap = [
            'nama barang' => 'nama_barang',
            'nama_barang' => 'nama_barang',
            'nama'        => 'nama_barang',
            'qty'         => 'qty',
            'kuantitas'   => 'qty',
            'satuan'      => 'satuan',
            'jenis'       => 'jenis',
            'kategori'    => 'jenis',
            'sumber'      => 'sumber',
            'asal'        => 'sumber',
            'keterangan'  => 'keterangan',
            'ket'         => 'keterangan'
        ];
    
        // --- Normalisasi header
        $normalizedHeaders = [];
        foreach ($headers as $h) {
            $key = strtolower(trim($h));
            $normalizedHeaders[] = $headerMap[$key] ?? $key;
        }
    
        $errors = [];
        $dataToImport = [];
        $rowNumber = 1;
    
        // --- Definisi nilai yang diizinkan (dibikin lowercase semua biar fleksibel)
        $allowed_satuan = ['unit', 'set', 'buah'];
        $allowed_sumber = ['hibah', 'beli', 'sponsor'];
        $allowed_jenis  = [
            'alat tulis percetakan & perlengkapan',
            'alat dapur',
            'perlengkapan istirahat',
            'elektronik',
            'furniture'
        ];
    
        // --- Loop isi CSV
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $rowNumber++;
            if (count($row) != count($normalizedHeaders)) {
                $errors[] = "Baris #{$rowNumber}: Jumlah kolom tidak sesuai.";
                continue;
            }
    
            // Buat asosiatif
            $rowAssoc = array_combine($normalizedHeaders, $row);
    
            // Normalisasi isi ke lowercase untuk validasi (tapi simpan versi original)
            $satuanVal = strtolower(trim($rowAssoc['satuan'] ?? ''));
            $jenisVal  = strtolower(trim($rowAssoc['jenis'] ?? ''));
            $sumberVal = strtolower(trim($rowAssoc['sumber'] ?? ''));
    
            // Validasi Qty
            if (empty(trim($rowAssoc['qty'] ?? ''))) {
                $rowAssoc['qty'] = 0;
            } elseif (!ctype_digit(strval($rowAssoc['qty']))) {
                $errors[] = "Baris #{$rowNumber}: Kuantitas ('{$rowAssoc['qty']}') harus angka bulat.";
            }
    
            // Validasi Satuan
            if (!in_array($satuanVal, $allowed_satuan)) {
                $errors[] = "Baris #{$rowNumber}: Satuan ('{$rowAssoc['satuan']}') tidak valid.";
            }
    
            // Validasi Jenis
            if (!in_array($jenisVal, $allowed_jenis)) {
                $errors[] = "Baris #{$rowNumber}: Jenis Barang ('{$rowAssoc['jenis']}') tidak valid.";
            }
    
            // Validasi Sumber
            if (!in_array($sumberVal, $allowed_sumber)) {
                $errors[] = "Baris #{$rowNumber}: Sumber Barang ('{$rowAssoc['sumber']}') tidak valid.";
            }
    
            $dataToImport[] = $rowAssoc;
        }
        fclose($handle);
    
        // --- Jika ada error
        if (!empty($errors)) {
            $_SESSION['csv_import_errors'] = $errors;
            header('Location: ' . BASEURL . '/barang');
            exit;
        }
    
        // --- Import ke DB
        foreach ($dataToImport as $row) {
            $this->model('Barang_model')->importFromCsv($row); // sekarang langsung array asosiatif
        }
    
        $this->model('Log_model')->catatLog('IMPORT', 'barang', "Mengimpor data dari file CSV.");
        Flasher::setFlash('Import Berhasil', 'Semua data dari CSV telah ditambahkan.', 'success');
        header('Location: ' . BASEURL . '/barang');
        exit;
    }
    
    
    public function importCsvForm()
    {
        $data['judul'] = 'Import Barang dari CSV';
        $this->view('templates/header', $data);
        $this->view('barang/import', $data);
        $this->view('templates/footer');
    }

}