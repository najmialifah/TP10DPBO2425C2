<?php
require_once __DIR__ . '/../models/Grup.php';

class GrupViewModel {
    private $grupModel;
    
    public $id;
    public $nama_grup;
    public $agensi;
    public $tahun_debut;
    public $grupList = [];
    public $errorMessage = '';
    public $successMessage = '';

    public function __construct() {
        $this->grupModel = new Grup();
    }

    // --- Metode Read ---

    public function loadAllGrup() {
        $stmt = $this->grupModel->readAll();
        $this->grupList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function loadGrup($id) {
        $this->grupModel->id = $id;
        $data = $this->grupModel->readOne();

        if ($data) {
            $this->id = $data['id'];
            $this->nama_grup = $data['nama_grup'];
            $this->agensi = $data['agensi'];
            $this->tahun_debut = $data['tahun_debut'];
            return true;
        }
        $this->errorMessage = "Data Grup tidak ditemukan.";
        return false;
    }

    // --- Metode Create/Update (Handler Input dari View) ---

    public function handleFormSubmission($postData) {
        // Validasi data sederhana
        if (empty($postData['nama_grup']) || empty($postData['agensi']) || empty($postData['tahun_debut'])) {
            $this->errorMessage = "Semua field harus diisi.";
            return false;
        }

        $this->nama_grup = $postData['nama_grup'];
        $this->agensi = $postData['agensi'];
        $this->tahun_debut = $postData['tahun_debut'];

        if (isset($postData['id']) && !empty($postData['id'])) {
            $this->id = $postData['id'];
            return $this->updateGrup();
        } else {
            return $this->createGrup();
        }
    }

    private function createGrup() {
        $this->grupModel->nama_grup = $this->nama_grup;
        $this->grupModel->agensi = $this->agensi;
        $this->grupModel->tahun_debut = $this->tahun_debut;

        if ($this->grupModel->create()) {
            $this->successMessage = "Grup berhasil ditambahkan!";
            return true;
        } else {
            $this->errorMessage = "Gagal menambahkan Grup.";
            return false;
        }
    }

    private function updateGrup() {
        $this->grupModel->id = $this->id;
        $this->grupModel->nama_grup = $this->nama_grup;
        $this->grupModel->agensi = $this->agensi;
        $this->grupModel->tahun_debut = $this->tahun_debut;

        if ($this->grupModel->update()) {
            $this->successMessage = "Grup berhasil diperbarui!";
            return true;
        } else {
            $this->errorMessage = "Gagal memperbarui Grup.";
            return false;
        }
    }

    // --- Metode Delete ---

    public function handleDelete($id) {
        $this->grupModel->id = $id;
        if ($this->grupModel->delete()) {
            $this->successMessage = "Grup berhasil dihapus.";
            return true;
        } else {
            $this->errorMessage = "Gagal menghapus Grup.";
            return false;
        }
    }
}
?>