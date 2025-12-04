<?php

require_once __DIR__ . '/../config/Database.php';

class Member {
    private $conn;
    private $table_name = "member";

    public $id;
    public $nama_lengkap;
    public $nama_panggung;
    public $kewarganegaraan;
    public $id_grup;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // --- READ ---

    public function readAll() {
        // PERUBAHAN: Diurutkan berdasarkan id member (m.id) secara menaik (ASC)
        $query = "SELECT m.id, m.nama_lengkap, m.nama_panggung, m.kewarganegaraan, g.nama_grup 
                  FROM " . $this->table_name . " m 
                  LEFT JOIN grup g ON m.id_grup = g.id
                  ORDER BY m.id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function readOne() {
        $query = "SELECT id, nama_lengkap, nama_panggung, kewarganegaraan, id_grup 
                  FROM " . $this->table_name . " 
                  WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nama_lengkap = $row['nama_lengkap'];
            $this->nama_panggung = $row['nama_panggung'];
            $this->kewarganegaraan = $row['kewarganegaraan'];
            $this->id_grup = $row['id_grup'];
        }
        
        return $row;
    }

    // --- CREATE ---

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nama_lengkap=:nama_lengkap, nama_panggung=:nama_panggung, kewarganegaraan=:kewarganegaraan, id_grup=:id_grup";
        
        $stmt = $this->conn->prepare($query);

        $this->nama_lengkap = htmlspecialchars(strip_tags($this->nama_lengkap));
        $this->nama_panggung = htmlspecialchars(strip_tags($this->nama_panggung));
        $this->kewarganegaraan = htmlspecialchars(strip_tags($this->kewarganegaraan));
        $this->id_grup = htmlspecialchars(strip_tags($this->id_grup));

        $stmt->bindParam(":nama_lengkap", $this->nama_lengkap);
        $stmt->bindParam(":nama_panggung", $this->nama_panggung);
        $stmt->bindParam(":kewarganegaraan", $this->kewarganegaraan);
        $stmt->bindParam(":id_grup", $this->id_grup);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // --- UPDATE ---

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nama_lengkap = :nama_lengkap, nama_panggung = :nama_panggung, kewarganegaraan = :kewarganegaraan, id_grup = :id_grup 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nama_lengkap = htmlspecialchars(strip_tags($this->nama_lengkap));
        $this->nama_panggung = htmlspecialchars(strip_tags($this->nama_panggung));
        $this->kewarganegaraan = htmlspecialchars(strip_tags($this->kewarganegaraan));
        $this->id_grup = htmlspecialchars(strip_tags($this->id_grup));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nama_lengkap', $this->nama_lengkap);
        $stmt->bindParam(':nama_panggung', $this->nama_panggung);
        $stmt->bindParam(':kewarganegaraan', $this->kewarganegaraan);
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