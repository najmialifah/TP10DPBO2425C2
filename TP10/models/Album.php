<?php

require_once __DIR__ . '/../config/Database.php';

class Album {
    private $conn;
    private $table_name = "album";

    // Properti objek Album (sesuai kolom tabel)
    public $id;
    public $judul_album;
    public $jenis_album;
    public $tgl_rilis;
    public $id_grup; // Foreign Key

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // --- READ ---

    public function readAll() {
        // Mengambil data album, digabungkan dengan nama grup
        $query = "SELECT a.id, a.judul_album, a.jenis_album, a.tgl_rilis, g.nama_grup 
                  FROM " . $this->table_name . " a 
                  LEFT JOIN grup g ON a.id_grup = g.id
                  ORDER BY a.tgl_rilis DESC, a.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function readOne() {
        $query = "SELECT id, judul_album, jenis_album, tgl_rilis, id_grup 
                  FROM " . $this->table_name . " 
                  WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->judul_album = $row['judul_album'];
            $this->jenis_album = $row['jenis_album'];
            $this->tgl_rilis = $row['tgl_rilis'];
            $this->id_grup = $row['id_grup'];
        }
        
        return $row;
    }

    // --- CREATE ---

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET judul_album=:judul_album, jenis_album=:jenis_album, tgl_rilis=:tgl_rilis, id_grup=:id_grup";
        
        $stmt = $this->conn->prepare($query);

        // Sanitasi data
        $this->judul_album = htmlspecialchars(strip_tags($this->judul_album));
        $this->jenis_album = htmlspecialchars(strip_tags($this->jenis_album));
        $this->tgl_rilis = htmlspecialchars(strip_tags($this->tgl_rilis));
        $this->id_grup = htmlspecialchars(strip_tags($this->id_grup));

        // Binding nilai
        $stmt->bindParam(":judul_album", $this->judul_album);
        $stmt->bindParam(":jenis_album", $this->jenis_album);
        $stmt->bindParam(":tgl_rilis", $this->tgl_rilis);
        $stmt->bindParam(":id_grup", $this->id_grup);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // --- UPDATE ---

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET judul_album = :judul_album, jenis_album = :jenis_album, tgl_rilis = :tgl_rilis, id_grup = :id_grup 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitasi data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->judul_album = htmlspecialchars(strip_tags($this->judul_album));
        $this->jenis_album = htmlspecialchars(strip_tags($this->jenis_album));
        $this->tgl_rilis = htmlspecialchars(strip_tags($this->tgl_rilis));
        $this->id_grup = htmlspecialchars(strip_tags($this->id_grup));

        // Binding data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':judul_album', $this->judul_album);
        $stmt->bindParam(':jenis_album', $this->jenis_album);
        $stmt->bindParam(':tgl_rilis', $this->tgl_rilis);
        $stmt->bindParam(':id_grup', $this->id_grup);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // --- DELETE ---

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>