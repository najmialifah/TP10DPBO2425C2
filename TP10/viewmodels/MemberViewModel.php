<?php

require_once __DIR__ . '/../models/Member.php';
require_once __DIR__ . '/../models/Grup.php'; // Diperlukan untuk dropdown Foreign Key

class MemberViewModel {
    private $memberModel;
    private $grupModel;
    
    public $id;
    public $nama_lengkap;
    public $nama_panggung;
    public $kewarganegaraan;
    public $id_grup; // Foreign Key
    
    public $memberList = [];
    public $grupOptions = [];
    public $errorMessage = '';
    public $successMessage = '';

    public function __construct() {
        $this->memberModel = new Member();
        $this->grupModel = new Grup();
        $this->loadGrupOptions(); // Muat data grup saat ViewModel diinisialisasi
    }

    private function loadGrupOptions() {
        $stmt = $this->grupModel->readAll();
        $this->grupOptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- Metode Read ---

    public function loadAllMember() {
        $stmt = $this->memberModel->readAll();
        $this->memberList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function loadMember($id) {
        $this->memberModel->id = $id;
        $data = $this->memberModel->readOne();

        if ($data) {
            $this->id = $id;
            $this->nama_lengkap = $data['nama_lengkap'];
            $this->nama_panggung = $data['nama_panggung'];
            $this->kewarganegaraan = $data['kewarganegaraan'];
            $this->id_grup = $data['id_grup'];
            return true;
        }
        $this->errorMessage = "Data Member tidak ditemukan.";
        return false;
    }

    // --- Metode Create/Update (Handler Input dari View) ---

    public function handleFormSubmission($postData) {
        if (empty($postData['nama_lengkap']) || empty($postData['id_grup'])) {
            $this->errorMessage = "Nama Lengkap dan Grup harus diisi.";
            return false;
        }

        $this->nama_lengkap = $postData['nama_lengkap'];
        $this->nama_panggung = $postData['nama_panggung'] ?? null;
        $this->kewarganegaraan = $postData['kewarganegaraan'] ?? null;
        $this->id_grup = $postData['id_grup'];

        if (isset($postData['id']) && !empty($postData['id'])) {
            $this->id = $postData['id'];
            return $this->updateMember();
        } else {
            return $this->createMember();
        }
    }

    private function createMember() {
        $this->memberModel->nama_lengkap = $this->nama_lengkap;
        $this->memberModel->nama_panggung = $this->nama_panggung;
        $this->memberModel->kewarganegaraan = $this->kewarganegaraan;
        $this->memberModel->id_grup = $this->id_grup;

        if ($this->memberModel->create()) {
            $this->successMessage = "Member berhasil ditambahkan!";
            return true;
        } else {
            $this->errorMessage = "Gagal menambahkan Member.";
            return false;
        }
    }

    private function updateMember() {
        $this->memberModel->id = $this->id;
        $this->memberModel->nama_lengkap = $this->nama_lengkap;
        $this->memberModel->nama_panggung = $this->nama_panggung;
        $this->memberModel->kewarganegaraan = $this->kewarganegaraan;
        $this->memberModel->id_grup = $this->id_grup;

        if ($this->memberModel->update()) {
            $this->successMessage = "Member berhasil diperbarui!";
            return true;
        } else {
            $this->errorMessage = "Gagal memperbarui Member.";
            return false;
        }
    }

    // --- Metode Delete ---

    public function handleDelete($id) {
        $this->memberModel->id = $id;
        if ($this->memberModel->delete()) {
            $this->successMessage = "Member berhasil dihapus.";
            return true;
        } else {
            $this->errorMessage = "Gagal menghapus Member.";
            return false;
        }
    }
}
?>