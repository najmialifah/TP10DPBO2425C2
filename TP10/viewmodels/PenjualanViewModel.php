<?php

require_once __DIR__ . '/../models/Penjualan.php';
require_once __DIR__ . '/../models/Album.php'; 

class PenjualanViewModel {
    private $penjualanModel;
    private $albumModel;
    
    public $id;
    public $jumlah_terjual;
    public $negara;
    public $sumber_chart;
    public $id_album; 
    
    public $penjualanList = [];
    public $albumOptions = [];
    public $errorMessage = '';
    public $successMessage = '';

    public function __construct() {
        $this->penjualanModel = new Penjualan();
        $this->albumModel = new Album();
        $this->loadAlbumOptions();
    }

    private function loadAlbumOptions() {
        $stmt = $this->albumModel->readAll();
        // Ambil data album. Kita mungkin ingin menampilkan Judul Album dan Nama Grup.
        $this->albumOptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- Metode Read ---

    public function loadAllPenjualan() {
        $stmt = $this->penjualanModel->readAll();
        $this->penjualanList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function loadPenjualan($id) {
        $this->penjualanModel->id = $id;
        $data = $this->penjualanModel->readOne();

        if ($data) {
            $this->id = $id;
            $this->jumlah_terjual = $data['jumlah_terjual'];
            $this->negara = $data['negara'];
            $this->sumber_chart = $data['sumber_chart'];
            $this->id_album = $data['id_album'];
            return true;
        }
        $this->errorMessage = "Data Penjualan tidak ditemukan.";
        return false;
    }

    // --- Metode Create/Update (Handler Input dari View) ---

    public function handleFormSubmission($postData) {
        if (empty($postData['jumlah_terjual']) || empty($postData['id_album'])) {
            $this->errorMessage = "Jumlah Terjual dan Album harus diisi.";
            return false;
        }

        $this->jumlah_terjual = $postData['jumlah_terjual'];
        $this->negara = $postData['negara'] ?? null;
        $this->sumber_chart = $postData['sumber_chart'] ?? null;
        $this->id_album = $postData['id_album'];

        if (isset($postData['id']) && !empty($postData['id'])) {
            $this->id = $postData['id'];
            return $this->updatePenjualan();
        } else {
            return $this->createPenjualan();
        }
    }

    private function createPenjualan() {
        $this->penjualanModel->jumlah_terjual = $this->jumlah_terjual;
        $this->penjualanModel->negara = $this->negara;
        $this->penjualanModel->sumber_chart = $this->sumber_chart;
        $this->penjualanModel->id_album = $this->id_album;

        if ($this->penjualanModel->create()) {
            $this->successMessage = "Data Penjualan berhasil ditambahkan!";
            return true;
        } else {
            $this->errorMessage = "Gagal menambahkan Data Penjualan.";
            return false;
        }
    }

    private function updatePenjualan() {
        $this->penjualanModel->id = $this->id;
        $this->penjualanModel->jumlah_terjual = $this->jumlah_terjual;
        $this->penjualanModel->negara = $this->negara;
        $this->penjualanModel->sumber_chart = $this->sumber_chart;
        $this->penjualanModel->id_album = $this->id_album;

        if ($this->penjualanModel->update()) {
            $this->successMessage = "Data Penjualan berhasil diperbarui!";
            return true;
        } else {
            $this->errorMessage = "Gagal memperbarui Data Penjualan.";
            return false;
        }
    }

    // --- Metode Delete ---

    public function handleDelete($id) {
        $this->penjualanModel->id = $id;
        if ($this->penjualanModel->delete()) {
            $this->successMessage = "Data Penjualan berhasil dihapus.";
            return true;
        } else {
            $this->errorMessage = "Gagal menghapus Data Penjualan.";
            return false;
        }
    }
}
?>