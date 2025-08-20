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
        fgetcsv($handle); // Lewati header

        $errors = [];
        $dataToImport = [];
        $rowNumber = 1;

        // Definisikan nilai yang diizinkan
        $allowed_satuan = ['Unit', 'Set', 'Buah'];
        $allowed_sumber = ['Hibah', 'Beli', 'Sponsor'];
        $allowed_jenis = ['Alat Tulis Percetakan & Perlengkapan', 'Alat Dapur', 'Perlengkapan Istirahat', 'Elektronik', 'Furniture'];

        // 1. Validasi dengan aturan baru
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $rowNumber++;
            if (count($data) != 6) { $errors[] = "Baris #{$rowNumber}: Jumlah kolom tidak sesuai."; continue; }
        
            // Aturan untuk Qty
            if (empty(trim($data[1]))) {
                $data[1] = 0;
            } elseif (!ctype_digit(strval($data[1]))) {
                $errors[] = "Baris #{$rowNumber}: Kuantitas ('{$data[1]}') harus berupa angka bulat.";
            }
            
            // Aturan untuk Satuan
            if (!in_array($data[2], $allowed_satuan)) {
                $errors[] = "Baris #{$rowNumber}: Satuan ('{$data[2]}') tidak valid. Harus Unit/Set/Buah.";
            }
        
            // Aturan untuk Jenis Barang (kolom ke-4, index 3)
            if (!in_array($data[3], $allowed_jenis)) {
                $errors[] = "Baris #{$rowNumber}: Jenis Barang ('{$data[3]}') tidak valid.";
            }
        
            // Aturan untuk Sumber Barang (kolom ke-5, index 4)
            if (!in_array($data[4], $allowed_sumber)) {
                $errors[] = "Baris #{$rowNumber}: Sumber Barang ('{$data[4]}') tidak valid. Harus Hibah/Beli/Sponsor.";
            }
        
            $dataToImport[] = $data;
        }
        fclose($handle);

        // 2. Jika ada error, tampilkan di modal
        if (!empty($errors)) {
            $_SESSION['csv_import_errors'] = $errors;
            header('Location: ' . BASEURL . '/barang');
            exit;
        }

        // 3. Jika tidak ada error, import data
        foreach ($dataToImport as $data) {
            $this->model('Barang_model')->importFromCsv($data);
        }

        $this->model('Log_model')->catatLog('IMPORT', 'barang', "Mengimpor data dari file CSV.");
        Flasher::setFlash('Import Berhasil', 'Semua data dari CSV telah ditambahkan.', 'success');
        header('Location: ' . BASEURL . '/barang');
        exit;
    }
}