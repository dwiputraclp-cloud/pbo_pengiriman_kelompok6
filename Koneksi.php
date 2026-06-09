<?php

class Database
{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "db_pengiriman";

    public $koneksi;

    public function __construct()
    {
        $this->koneksi = new mysqli(
            $this->host,
            $this->user,
            $this->password,
            $this->database
        );

        if ($this->koneksi->connect_error) {
            die("Koneksi gagal: " . $this->koneksi->connect_error);
        }

        $this->koneksi->set_charset("utf8");
    }
}

$db = new Database();
$koneksi = $db->koneksi;

?>