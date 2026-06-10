# Implementasi Database dan Koneksi OOP

## 1. Berkas Ekspor Basis Data (.sql)

File `db_pengiriman.sql` merupakan hasil ekspor (export) database yang digunakan pada aplikasi Pengiriman Kargo. Berkas ini berisi:

* Struktur tabel database.
* Data awal (sample data).
* Primary Key dan Foreign Key.
* Relasi antar tabel.
* Konfigurasi integritas data menggunakan `ON DELETE CASCADE` dan `ON UPDATE CASCADE`.

### Struktur Tabel Utama

```sql
CREATE TABLE kargo (
    id_resi VARCHAR(20) NOT NULL,
    pengirim VARCHAR(100) NOT NULL,
    kota_tujuan VARCHAR(100) NOT NULL,
    berat_barang DECIMAL(10,2) NOT NULL,
    tarif_dasar_perkg DECIMAL(12,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_resi)
);
```

### Relasi Antar Tabel

```sql
ALTER TABLE kargo_reguler
ADD CONSTRAINT fk_reguler_kargo
FOREIGN KEY (id_resi)
REFERENCES kargo(id_resi)
ON DELETE CASCADE
ON UPDATE CASCADE;
```

**Penjelasan:**

* Tabel `kargo` menjadi tabel induk (parent).
* Tabel `kargo_reguler`, `kargo_bahan_kimia`, dan `kargo_pecah_belah` menjadi tabel turunan (child).
* Jika data pada tabel `kargo` dihapus, maka data terkait pada tabel turunan akan ikut terhapus secara otomatis.

---

## 2. Kelas Koneksi Database Menggunakan OOP Constructor

Koneksi database dibuat menggunakan konsep Object-Oriented Programming (OOP). Constructor (`__construct()`) digunakan agar koneksi ke database dilakukan secara otomatis ketika objek dibuat.

### File: koneksi.php

```php
<?php

class Koneksi
{
    // Menyimpan konfigurasi database
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "db_pengiriman";

    // Menyimpan objek koneksi
    public $conn;

    /*
     * Constructor
     * Akan dijalankan otomatis saat objek dibuat.
     */
    public function __construct()
    {
        $this->conn = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        // Mengecek apakah koneksi berhasil
        if ($this->conn->connect_error) {
            die("Koneksi gagal : " . $this->conn->connect_error);
        }
    }
}
?>
```

### Penjelasan Kode

| Bagian            | Fungsi                                     |
| ----------------- | ------------------------------------------ |
| private $host     | Menyimpan nama server database             |
| private $username | Menyimpan username MySQL                   |
| private $password | Menyimpan password MySQL                   |
| private $database | Menyimpan nama database                    |
| public $conn      | Menyimpan objek koneksi                    |
| __construct()     | Membuat koneksi otomatis saat objek dibuat |

### Contoh Penggunaan

```php
<?php

require_once "koneksi.php";

$db = new Koneksi();

echo "Koneksi database berhasil";

?>
```

Ketika kode di atas dijalankan, constructor akan otomatis membuat koneksi ke database tanpa perlu memanggil method lain secara manual.

### Penerapan OOP

* **Encapsulation**: Data konfigurasi database disimpan dalam atribut `private`.
* **Object**: Objek dibuat menggunakan `$db = new Koneksi();`.
* **Constructor**: Method `__construct()` berjalan otomatis saat objek dibuat.
* **Reusability**: Class koneksi dapat digunakan kembali pada seluruh modul CRUD aplikasi.
