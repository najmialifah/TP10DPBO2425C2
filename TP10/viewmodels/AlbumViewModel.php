<?php

require_once __DIR__ . '/../models/Album.php';
require_once __DIR__ . '/../models/Grup.php'; // Diperlukan untuk dropdown Foreign Key

class AlbumViewModel {
    private $albumModel;
    private $grupModel;
    
    public $id;
    public $judul_album;
    public $jenis_album;
    public $tgl_rilis;
    public $id_grup; // Foreign Key
    
    public $albumList = [];
    public $grupOptions = [];
    public $errorMessage = '';
    public $successMessage = '';

    public function __construct() {
        $this->albumModel = new Album();
        $this->grupModel = new Grup();
        $this->loadGrupOptions();
    }

    private function loadGrupOptions() {
        $stmt = $this->grupModel->readAll();
        $this->grupOptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- Metode Read ---

    public function loadAllAlbum() {
        $stmt = $this->albumModel->readAll();
        $this->albumList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function loadAlbum($id) {
        $this->albumModel->id = $id;
        $data = $this->albumModel->readOne();

        if ($data) {
            $this->id = $id;
            $this->judul_album = $data['judul_album'];
            $this->jenis_album = $data['jenis_album'];
            $this->tgl_rilis = $data['tgl_rilis'];
            $this->id_grup = $data['id_grup'];
            return true;
        }
        $this->errorMessage = "Data Album tidak ditemukan.";
        return false;
    }

    // --- Metode Create/Update (Handler Input dari View) ---

    public function handleFormSubmission($postData) {
        if (empty($postData['judul_album']) || empty($postData['id_grup']) || empty($postData['tgl_rilis'])) {
            $this->errorMessage = "Judul Album, Grup, dan Tanggal Rilis harus diisi.";
            return false;
        }

        $this->judul_album = $postData['judul_album'];
        $this->jenis_album = $postData['jenis_album'] ?? null;
        $this->tgl_rilis = $postData['tgl_rilis'];
        $this->id_grup = $postData['id_grup'];

        if (isset($postData['id']) && !empty($postData['id'])) {
            $this->id = $postData['id'];
            return $this->updateAlbum();
        } else {
            return $this->createAlbum();
        }
    }

    private function createAlbum() {
        $this->albumModel->judul_album = $this->judul_album;
        $this->albumModel->jenis_album = $this->jenis_album;
        $this->albumModel->tgl_rilis = $this->tgl_rilis;
        $this->albumModel->id_grup = $this->id_grup;

        if ($this->albumModel->create()) {
            $this->successMessage = "Album berhasil ditambahkan!";
            return true;
        } else {
            $this->errorMessage = "Gagal menambahkan Album.";
            return false;
        }
    }

    private function updateAlbum() {
        $this->albumModel->id = $this->id;
        $this->albumModel->judul_album = $this->judul_album;
        $this->albumModel->jenis_album = $this->jenis_album;
        $this->albumModel->tgl_rilis = $this->tgl_rilis;
        $this->albumModel->id_grup = $this->id_grup;

        if ($this->albumModel->update()) {
            $this->successMessage = "Album berhasil diperbarui!";
            return true;
        } else {
            $this->errorMessage = "Gagal memperbarui Album.";
            return false;
        }
    }

    // --- Metode Delete ---

    public function handleDelete($id) {
        $this->albumModel->id = $id;
        if ($this->albumModel->delete()) {
            $this->successMessage = "Album berhasil dihapus.";
            return true;
        } else {
            $this->errorMessage = "Gagal menghapus Album.";
            return false;
        }
    }
}
?>