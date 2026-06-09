<?php

// Membuat class Database untuk mengelola koneksi ke MySQL
class Database
{
    // Konfigurasi database
    private $host = "localhost";       // Nama host database
    private $user = "root";            // Username MySQL
    private $password = "";            // Password MySQL
    private $database = "db_pengiriman"; // Nama database yang digunakan

    // Variabel untuk menyimpan objek koneksi
    public $koneksi;

    // Constructor akan otomatis dijalankan saat objek dibuat
    public function __construct()
    {
        // Membuat koneksi ke database menggunakan MySQLi
        $this->koneksi = new mysqli(
            $this->host,
            $this->user,
            $this->password,
            $this->database
        );

        // Mengecek apakah koneksi berhasil atau gagal
        if ($this->koneksi->connect_error) {
            die("Koneksi gagal: " . $this->koneksi->connect_error);
        }

        // Mengatur karakter encoding menjadi UTF-8
        $this->koneksi->set_charset("utf8");
    }
}

// Membuat objek Database
$db = new Database();

// Menyimpan koneksi ke variabel agar mudah digunakan di file lain
$koneksi = $db->koneksi;

?>