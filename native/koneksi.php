<?php
class koneksi {
private $host = "localhost";
private $username = "root";
private $password = "";
private $dbname = "db_user";

public function getKoneksi() {
    try {
        $koneksi = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
        $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $koneksi;
} catch (PDOException $e) {
        die("Koneksi database gagal: " . $e->getMessage());
        }
    }
}
