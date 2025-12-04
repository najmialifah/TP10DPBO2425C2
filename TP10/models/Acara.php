<?php

require_once __DIR__ . '/../config/Database.php';

class Acara {
    private $conn;
    private $table_name = "acara";

    public $id;
    public $nama_acara;
    public $jenis_acara;
    public $lokasi;
    public $tgl_acara;
    public $id_grup;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // --- READ ---

    public function readAll() {
        // PERUBAHAN: Diurutkan berdasarkan id acara (a.id) secara menaik (ASC)
        $query = "SELECT a.id, a.nama_acara, a.jenis_acara, a.lokasi, a.tgl_acara, g.nama_grup 
                  FROM " . $this->table_name . " a 
                  LEFT JOIN grup g ON a.id_grup = g.id
                  ORDER BY a.id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function readOne() {
        $query = "SELECT id, nama_acara, jenis_acara, lokasi, tgl_acara, id_grup 
                  FROM " . $this->table_name . " 
                  WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nama_acara = $row['nama_acara'];
            $this->jenis_acara = $row['jenis_acara'];
            $this->lokasi = $row['lokasi'];
            $this->tgl_acara = $row['tgl_acara'];
            $this->id_grup = $row['id_grup'];
        }
        
        return $row;
    }

    // --- CREATE ---

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nama_acara=:nama_acara, jenis_acara=:jenis_acara, lokasi=:lokasi, tgl_acara=:tgl_acara, id_grup=:id_grup";
        
        $stmt = $this->conn->prepare($query);

        $this->nama_acara = htmlspecialchars(strip_tags($this->nama_acara));
        $this->jenis_acara = htmlspecialchars(strip_tags($this->jenis_acara));
        $this->lokasi = htmlspecialchars(strip_tags($this->lokasi));
        $this->tgl_acara = htmlspecialchars(strip_tags($this->tgl_acara));
        $this->id_grup = htmlspecialchars(strip_tags($this->id_grup));

        $stmt->bindParam(":nama_acara", $this->nama_acara);
        $stmt->bindParam(":jenis_acara", $this->jenis_acara);
        $stmt->bindParam(":lokasi", $this->lokasi);
        $stmt->bindParam(":tgl_acara", $this->tgl_acara);
        $stmt->bindParam(":id_grup", $this->id_grup);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // --- UPDATE ---

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nama_acara = :nama_acara, jenis_acara = :jenis_acara, lokasi = :lokasi, tgl_acara = :tgl_acara, id_grup = :id_grup 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nama_acara = htmlspecialchars(strip_tags($this->nama_acara));
        $this->jenis_acara = htmlspecialchars(strip_tags($this->jenis_acara));
        $this->lokasi = htmlspecialchars(strip_tags($this->lokasi));
        $this->tgl_acara = htmlspecialchars(strip_tags($this->tgl_acara));
        $this->id_grup = htmlspecialchars(strip_tags($this->id_grup));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nama_acara', $this->nama_acara);
        $stmt->bindParam(':jenis_acara', $this->jenis_acara);
        $stmt->bindParam(':lokasi', $this->lokasi);
        $stmt->bindParam(':tgl_acara', $this->tgl_acara);
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