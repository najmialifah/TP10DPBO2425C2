<?php

require_once __DIR__ . '/../config/Database.php';

class Penjualan {
    private $conn;
    private $table_name = "penjualan";

    public $id;
    public $jumlah_terjual;
    public $negara;
    public $sumber_chart;
    public $id_album;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // --- READ ---

    public function readAll() {
        // PERUBAHAN: Diurutkan berdasarkan id penjualan (p.id) secara menaik (ASC)
        $query = "SELECT p.id, p.jumlah_terjual, p.negara, p.sumber_chart, a.judul_album, g.nama_grup
                  FROM " . $this->table_name . " p 
                  LEFT JOIN album a ON p.id_album = a.id
                  LEFT JOIN grup g ON a.id_grup = g.id
                  ORDER BY p.id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function readOne() {
        $query = "SELECT id, jumlah_terjual, negara, sumber_chart, id_album 
                  FROM " . $this->table_name . " 
                  WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->jumlah_terjual = $row['jumlah_terjual'];
            $this->negara = $row['negara'];
            $this->sumber_chart = $row['sumber_chart'];
            $this->id_album = $row['id_album'];
        }
        
        return $row;
    }

    // --- CREATE ---

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET jumlah_terjual=:jumlah_terjual, negara=:negara, sumber_chart=:sumber_chart, id_album=:id_album";
        
        $stmt = $this->conn->prepare($query);

        $this->jumlah_terjual = htmlspecialchars(strip_tags($this->jumlah_terjual));
        $this->negara = htmlspecialchars(strip_tags($this->negara));
        $this->sumber_chart = htmlspecialchars(strip_tags($this->sumber_chart));
        $this->id_album = htmlspecialchars(strip_tags($this->id_album));

        $stmt->bindParam(":jumlah_terjual", $this->jumlah_terjual);
        $stmt->bindParam(":negara", $this->negara);
        $stmt->bindParam(":sumber_chart", $this->sumber_chart);
        $stmt->bindParam(":id_album", $this->id_album);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // --- UPDATE ---

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET jumlah_terjual = :jumlah_terjual, negara = :negara, sumber_chart = :sumber_chart, id_album = :id_album 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->jumlah_terjual = htmlspecialchars(strip_tags($this->jumlah_terjual));
        $this->negara = htmlspecialchars(strip_tags($this->negara));
        $this->sumber_chart = htmlspecialchars(strip_tags($this->sumber_chart));
        $this->id_album = htmlspecialchars(strip_tags($this->id_album));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':jumlah_terjual', $this->jumlah_terjual);
        $stmt->bindParam(':negara', $this->negara);
        $stmt->bindParam(':sumber_chart', $this->sumber_chart);
        $stmt->bindParam(':id_album', $this->id_album);

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