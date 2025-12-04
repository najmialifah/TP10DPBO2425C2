<?php
require_once __DIR__ . '/../config/Database.php';

class Grup {
    private $conn;
    private $table_name = "grup";

    public $id;
    public $nama_grup;
    public $agensi;
    public $tahun_debut;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function readAll() {
        // PERUBAHAN: Diurutkan berdasarkan id secara menaik
        $query = "SELECT id, nama_grup, agensi, tahun_debut FROM " . $this->table_name . " ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nama_grup=:nama_grup, agensi=:agensi, tahun_debut=:tahun_debut";
        
        $stmt = $this->conn->prepare($query);

        $this->nama_grup = htmlspecialchars(strip_tags($this->nama_grup));
        $this->agensi = htmlspecialchars(strip_tags($this->agensi));
        $this->tahun_debut = htmlspecialchars(strip_tags($this->tahun_debut));

        $stmt->bindParam(":nama_grup", $this->nama_grup);
        $stmt->bindParam(":agensi", $this->agensi);
        $stmt->bindParam(":tahun_debut", $this->tahun_debut);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function readOne() {
        $query = "SELECT id, nama_grup, agensi, tahun_debut FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nama_grup = $row['nama_grup'];
            $this->agensi = $row['agensi'];
            $this->tahun_debut = $row['tahun_debut'];
        }
        
        return $row;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nama_grup = :nama_grup, agensi = :agensi, tahun_debut = :tahun_debut WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nama_grup = htmlspecialchars(strip_tags($this->nama_grup));
        $this->agensi = htmlspecialchars(strip_tags($this->agensi));
        $this->tahun_debut = htmlspecialchars(strip_tags($this->tahun_debut));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nama_grup', $this->nama_grup);
        $stmt->bindParam(':agensi', $this->agensi);
        $stmt->bindParam(':tahun_debut', $this->tahun_debut);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

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