<?php

require_once __DIR__ . '/../models/Acara.php';
require_once __DIR__ . '/../models/Grup.php'; // Diperlukan untuk dropdown Foreign Key

class AcaraViewModel {
    private $acaraModel;
    private $grupModel;
    
    public $id;
    public $nama_acara;
    public $jenis_acara;
    public $lokasi;
    public $tgl_acara;
    public $id_grup; 
    
    public $acaraList = [];
    public $grupOptions = [];
    public $errorMessage = '';
    public $successMessage = '';

    public function __construct() {
        $this->acaraModel = new Acara();
        $this->grupModel = new Grup();
        $this->loadGrupOptions();
    }

    private function loadGrupOptions() {
        $stmt = $this->grupModel->readAll();
        $this->grupOptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- Metode Read ---

    public function loadAllAcara() {
        $stmt = $this->acaraModel->readAll();
        $this->acaraList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function loadAcara($id) {
        $this->acaraModel->id = $id;
        $data = $this->acaraModel->readOne();

        if ($data) {
            $this->id = $id;
            $this->nama_acara = $data['nama_acara'];
            $this->jenis_acara = $data['jenis_acara'];
            $this->lokasi = $data['lokasi'];
            $this->tgl_acara = $data['tgl_acara'];
            $this->id_grup = $data['id_grup'];
            return true;
        }
        $this->errorMessage = "Data Acara tidak ditemukan.";
        return false;
    }

    // --- Metode Create/Update (Handler Input dari View) ---

    public function handleFormSubmission($postData) {
        if (empty($postData['nama_acara']) || empty($postData['id_grup']) || empty($postData['tgl_acara'])) {
            $this->errorMessage = "Nama Acara, Grup, dan Tanggal Acara harus diisi.";
            return false;
        }

        $this->nama_acara = $postData['nama_acara'];
        $this->jenis_acara = $postData['jenis_acara'] ?? null;
        $this->lokasi = $postData['lokasi'] ?? null;
        $this->tgl_acara = $postData['tgl_acara'];
        $this->id_grup = $postData['id_grup'];

        if (isset($postData['id']) && !empty($postData['id'])) {
            $this->id = $postData['id'];
            return $this->updateAcara();
        } else {
            return $this->createAcara();
        }
    }

    private function createAcara() {
        $this->acaraModel->nama_acara = $this->nama_acara;
        $this->acaraModel->jenis_acara = $this->jenis_acara;
        $this->acaraModel->lokasi = $this->lokasi;
        $this->acaraModel->tgl_acara = $this->tgl_acara;
        $this->acaraModel->id_grup = $this->id_grup;

        if ($this->acaraModel->create()) {
            $this->successMessage = "Acara berhasil ditambahkan!";
            return true;
        } else {
            $this->errorMessage = "Gagal menambahkan Acara.";
            return false;
        }
    }

    private function updateAcara() {
        $this->acaraModel->id = $this->id;
        $this->acaraModel->nama_acara = $this->nama_acara;
        $this->acaraModel->jenis_acara = $this->jenis_acara;
        $this->acaraModel->lokasi = $this->lokasi;
        $this->acaraModel->tgl_acara = $this->tgl_acara;
        $this->acaraModel->id_grup = $this->id_grup;

        if ($this->acaraModel->update()) {
            $this->successMessage = "Acara berhasil diperbarui!";
            return true;
        } else {
            $this->errorMessage = "Gagal memperbarui Acara.";
            return false;
        }
    }

    // --- Metode Delete ---

    public function handleDelete($id) {
        $this->acaraModel->id = $id;
        if ($this->acaraModel->delete()) {
            $this->successMessage = "Acara berhasil dihapus.";
            return true;
        } else {
            $this->errorMessage = "Gagal menghapus Acara.";
            return false;
        }
    }
}
?>