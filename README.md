# Sistem Manajemen Pengiriman Kargo - Implementasi OOP PHP

## Identitas Proyek

| Keterangan | Isi |
|---|---|
| Nama Proyek | Sistem Manajemen Pengiriman Kargo |
| Database | `db_pengiriman` |
| Bahasa Pemrograman | PHP |
| Konsep Utama | Object-Oriented Programming (OOP), Inheritance, Abstraction, Encapsulation, Polymorphism |
| File Utama | `driver_polymorphism.php` |
| Penanggung Jawab README | Job 6 - Technical Writer & Documentation Specialist: Dwita |

## Deskripsi Singkat

Proyek ini merupakan aplikasi sederhana untuk mengelola data pengiriman kargo berdasarkan jenis kargo. Aplikasi mengambil data dari database `db_pengiriman`, mengubah data tersebut menjadi objek PHP, kemudian menampilkan laporan pengiriman berdasarkan konsep polymorphism.

Jenis kargo yang digunakan dalam sistem ini terdiri dari:

1. `KargoReguler`
2. `KargoBahanKimia`
3. `KargoPecahBelah`

Setiap jenis kargo memiliki atribut tambahan dan aturan perhitungan tarif pengiriman yang berbeda. Perbedaan aturan tersebut diterapkan menggunakan method overriding pada masing-masing subclass.

---

## Struktur File Proyek

```text
Kelompok 6/
â”œâ”€â”€ db_pengiriman.sql
â”œâ”€â”€ Koneksi.php
â”œâ”€â”€ kargo.php
â”œâ”€â”€ KargoReguler.php
â”œâ”€â”€ KargoBahanKimia.php
â”œâ”€â”€ KargoPecahBelah.php
â”œâ”€â”€ ManajemenLogistik.php
â”œâ”€â”€ driver_polymorphism.php
â””â”€â”€ README.md
```

> Catatan: apabila di pembagian tugas disebut `ManajemenKargo.php`, pada proyek ini nama file yang digunakan adalah `ManajemenLogistik.php`. Fungsinya sama, yaitu sebagai class pengelola data kargo dan penerapan polymorphic collection.

---

## Panduan Instalasi dan Menjalankan Aplikasi

### 1. Persyaratan

Sebelum menjalankan aplikasi, pastikan perangkat sudah memiliki:

- Web server lokal seperti XAMPP, Laragon, atau sejenisnya.
- PHP versi 8 atau versi lain yang mendukung OOP PHP.
- MySQL atau MariaDB.
- Browser untuk membuka halaman aplikasi.

### 2. Menyiapkan Folder Proyek

Letakkan folder proyek ke dalam direktori server lokal.

Contoh pada XAMPP:

```text
C:\xampp\htdocs\Kelompok 6
```

Contoh pada Laragon:

```text
C:\laragon\www\Kelompok 6
```

### 3. Mengimpor Database

1. Jalankan Apache dan MySQL melalui XAMPP/Laragon.
2. Buka phpMyAdmin melalui browser.
3. Buat database baru dengan nama:

```sql
CREATE DATABASE db_pengiriman;
```

4. Pilih database `db_pengiriman`.
5. Masuk ke menu **Import**.
6. Pilih file `db_pengiriman.sql`.
7. Klik **Go/Kirim** sampai proses import berhasil.

### 4. Mengecek Konfigurasi Koneksi

Buka file `Koneksi.php`, lalu pastikan konfigurasi database sesuai dengan server lokal yang digunakan.

```php
private $host = "localhost";
private $user = "root";
private $password = "";
private $database = "db_pengiriman";
```

Jika menggunakan XAMPP atau Laragon standar, biasanya username adalah `root` dan password dikosongkan.

### 5. Menjalankan Aplikasi

Buka browser, lalu akses file utama aplikasi:

```text
http://localhost/Kelompok%206/driver_polymorphism.php
```

Jika nama folder proyek berbeda, sesuaikan URL dengan nama folder yang digunakan.

---

## Class Diagram UML

Letakkan gambar class diagram UML pada folder `docs` atau `assets`, lalu tampilkan pada README menggunakan sintaks Markdown berikut:

```markdown
![Class Diagram UML](docs/class-diagram-uml.png)
```

Contoh struktur folder untuk gambar UML:

```text
Kelompok 6/
docs/
class-diagram-uml.png
README.md
```

Jika GitHub sudah menampilkan gambar, maka bagian ini akan menjadi dokumentasi visual relasi antar class pada proyek.

---

## Gambaran Relasi Class

Relasi utama pada proyek ini adalah sebagai berikut:

```text
Kargo (abstract class)
KargoReguler
KargoBahanKimia
KargoPecahBelah

ManajemenLogistik
Mengelola kumpulan objek bertipe Kargo[]

Driver Polymorphism
Menjalankan aplikasi dan menampilkan laporan polymorphic
```

Penjelasan singkat:

- `Kargo` berperan sebagai class induk yang menyimpan atribut umum semua jenis kargo.
- `KargoReguler`, `KargoBahanKimia`, dan `KargoPecahBelah` adalah subclass yang mewarisi atribut dan method dari `Kargo`.
- `ManajemenLogistik` bertugas mengambil data dari database, membentuk objek subclass, menyimpan objek ke dalam collection, dan membuat laporan.
- `driver_polymorphism.php` menjadi file utama untuk menjalankan tampilan dashboard dan laporan data kargo.

---

## Penjelasan File Utama

| File | Fungsi |
|---|---|
| `db_pengiriman.sql` | Berisi struktur database, tabel, relasi, dan data awal pengiriman kargo. |
| `Koneksi.php` | Membuat koneksi ke database `db_pengiriman` menggunakan class `Database`. |
| `kargo.php` | Berisi abstract class `Kargo` sebagai induk dari semua jenis kargo. |
| `KargoReguler.php` | Subclass untuk kargo reguler dengan atribut tambahan `jenisPaket` dan `estimasiHari`. |
| `KargoBahanKimia.php` | Subclass untuk kargo bahan kimia dengan atribut tambahan `tingkatBahaya` dan `jenisSertifikasiSandi`. |
| `KargoPecahBelah.php` | Subclass untuk kargo pecah belah dengan atribut tambahan `ketebalanBubbleWrap` dan `biayaAsuransiWajib`. |
| `ManajemenLogistik.php` | Class pengelola data kargo, database, polymorphic collection, dan laporan. |
| `driver_polymorphism.php` | File utama untuk menjalankan dashboard dan menampilkan hasil laporan polymorphism. |

---

# Penerapan Pilar OOP pada Proyek

## 1. Encapsulation

Encapsulation adalah konsep membungkus data dan method di dalam class, sehingga data tidak diakses secara sembarangan dari luar class.

Pada proyek ini, encapsulation terlihat pada file `kargo.php`.

```php
abstract class Kargo
{
    protected $id_resi;
    protected $pengirim;
    protected $kotaTujuan;
    protected $beratBarang;
    protected $tarifDasarPerKg;
}
```

Atribut utama kargo dibuat menggunakan access modifier `protected`. Artinya, atribut tersebut tidak dapat diakses langsung dari luar class, tetapi masih dapat digunakan oleh class turunannya seperti `KargoReguler`, `KargoBahanKimia`, dan `KargoPecahBelah`.

Untuk mengambil atau mengubah data, class `Kargo` menyediakan method getter dan setter.

```php
public function getIdResi()
{
    return $this->id_resi;
}

public function setBeratBarang($beratBarang)
{
    $this->beratBarang = $beratBarang;
}
```

Dengan cara ini, akses terhadap data lebih terkontrol. Program lain tidak langsung mengubah atribut, tetapi harus melalui method yang sudah disediakan.

Encapsulation juga diterapkan pada file `Koneksi.php`.

```php
private $host = "localhost";
private $user = "root";
private $password = "";
private $database = "db_pengiriman";
```

Data konfigurasi database dibuat `private` agar tidak dapat diakses langsung dari luar class. Hal ini membuat informasi koneksi lebih aman dan rapi.

---

## 2. Inheritance

Inheritance adalah konsep pewarisan, yaitu class turunan dapat mewarisi atribut dan method dari class induk.

Pada proyek ini, class induknya adalah `Kargo`, sedangkan class turunannya adalah:

- `KargoReguler`
- `KargoBahanKimia`
- `KargoPecahBelah`

Contoh penerapan inheritance pada file `KargoReguler.php`:

```php
class KargoReguler extends Kargo
{
    private $jenisPaket;
    private $estimasiHari;
}
```

Keyword `extends Kargo` menunjukkan bahwa `KargoReguler` mewarisi atribut dan method dari class `Kargo`.

Pada constructor subclass, pemanggilan constructor class induk dilakukan menggunakan `parent::__construct()`.

```php
parent::__construct(
    $id_resi,
    $pengirim,
    $kotaTujuan,
    $beratBarang,
    $tarifDasarPerKg
);
```

Dengan inheritance, atribut umum seperti `id_resi`, `pengirim`, `kotaTujuan`, `beratBarang`, dan `tarifDasarPerKg` cukup ditulis satu kali pada class `Kargo`. Subclass hanya perlu menambahkan atribut khusus sesuai jenis kargonya.

Contoh atribut khusus subclass:

| Subclass | Atribut Tambahan |
|---|---|
| `KargoReguler` | `jenisPaket`, `estimasiHari` |
| `KargoBahanKimia` | `tingkatBahaya`, `jenisSertifikasiSandi` |
| `KargoPecahBelah` | `ketebalanBubbleWrap`, `biayaAsuransiWajib` |

---

## 3. Abstraction

Abstraction adalah konsep menyembunyikan detail implementasi dan hanya menampilkan aturan utama yang wajib dimiliki oleh class turunan.

Pada proyek ini, abstraction diterapkan pada file `kargo.php` melalui `abstract class Kargo`.

```php
abstract class Kargo
{
    abstract public function hitungTarifPengiriman();
    abstract public function validasiSOPPacking();
}
```

Class `Kargo` dibuat sebagai abstract class karena tidak digunakan untuk membuat objek secara langsung. Class ini hanya menjadi bentuk umum dari semua jenis kargo.

Method `hitungTarifPengiriman()` dan `validasiSOPPacking()` dibuat abstract karena setiap jenis kargo memiliki aturan tarif dan SOP packing yang berbeda.

Dengan adanya abstract method, setiap subclass wajib membuat implementasi method tersebut. Jika subclass tidak membuat implementasinya, program akan error.

Contoh implementasi pada `KargoReguler.php`:

```php
public function hitungTarifPengiriman()
{
    return $this->beratBarang * $this->tarifDasarPerKg;
}

public function validasiSOPPacking()
{
    return "Packing reguler menggunakan {$this->jenisPaket}";
}
```

Abstraction membuat struktur program lebih konsisten karena semua jenis kargo pasti memiliki method perhitungan tarif dan validasi SOP packing.

---

## 4. Polymorphism

Polymorphism adalah kemampuan objek berbeda untuk diperlakukan sebagai tipe yang sama, tetapi tetap menjalankan perilaku sesuai class aslinya.

Pada proyek ini, polymorphism diterapkan melalui method overriding pada method:

- `hitungTarifPengiriman()`
- `validasiSOPPacking()`

Ketiga subclass memiliki nama method yang sama, tetapi isi atau aturan perhitungannya berbeda.

### Overriding pada `KargoReguler`

```php
public function hitungTarifPengiriman()
{
    return $this->beratBarang * $this->tarifDasarPerKg;
}
```

Tarif kargo reguler dihitung dari berat barang dikali tarif dasar per kilogram.

### Overriding pada `KargoBahanKimia`

```php
public function hitungTarifPengiriman()
{
    $tarifDasar = (float) $this->beratBarang * (float) $this->tarifDasarPerKg;

    $angkaTingkatBahaya = $this->ambilAngkaTingkatBahaya();
    $biayaPenangananKhusus = $angkaTingkatBahaya * 100000;

    return $tarifDasar + $biayaPenangananKhusus;
}
```

Tarif kargo bahan kimia dihitung dari tarif dasar ditambah biaya penanganan khusus berdasarkan tingkat bahaya.

### Overriding pada `KargoPecahBelah`

```php
public function hitungTarifPengiriman()
{
    $tarifBerat = $this->beratBarang * $this->tarifDasarPerKg;
    $surchargeFragile = $tarifBerat * 0.05;

    return $tarifBerat + $this->biayaAsuransiWajib + $surchargeFragile;
}
```

Tarif kargo pecah belah dihitung dari tarif berat, ditambah biaya asuransi wajib, dan tambahan surcharge fragile sebesar 5%.

### Polymorphic Collection pada `ManajemenLogistik.php`

Polymorphism paling jelas terlihat pada collection berikut:

```php
private $daftarKargo = [];
```

Array tersebut digunakan untuk menyimpan berbagai objek subclass, yaitu `KargoReguler`, `KargoBahanKimia`, dan `KargoPecahBelah`.

Method berikut menerima parameter bertipe `Kargo`:

```php
public function tambahKeCollection(Kargo $kargo)
{
    $this->daftarKargo[] = $kargo;
}
```

Karena parameter bertipe `Kargo`, maka semua objek dari subclass yang mewarisi `Kargo` dapat dimasukkan ke dalam collection tersebut.

Contoh proses dynamic binding terdapat pada method `buatLaporanPolymorphic()`:

```php
foreach ($this->daftarKargo as $kargo) {
    $tarif = $kargo->hitungTarifPengiriman();
    $sop = $kargo->validasiSOPPacking();
}
```

Walaupun variabel `$kargo` diperlakukan sebagai objek `Kargo`, method yang dijalankan tetap menyesuaikan class asli objek tersebut.

Contohnya:

- Jika objek aslinya `KargoReguler`, maka yang berjalan adalah `hitungTarifPengiriman()` milik `KargoReguler`.
- Jika objek aslinya `KargoBahanKimia`, maka yang berjalan adalah `hitungTarifPengiriman()` milik `KargoBahanKimia`.
- Jika objek aslinya `KargoPecahBelah`, maka yang berjalan adalah `hitungTarifPengiriman()` milik `KargoPecahBelah`.

Inilah yang disebut polymorphism, karena satu pemanggilan method yang sama dapat menghasilkan perilaku berbeda sesuai jenis objeknya.

---

## Ringkasan Penerapan Pilar OOP

| Pilar OOP | Penerapan pada Proyek | File |
|---|---|---|
| Encapsulation | Atribut dibuat `private` atau `protected`, akses data dilakukan melalui getter dan setter. | `kargo.php`, `Koneksi.php`, seluruh subclass |
| Inheritance | Class `KargoReguler`, `KargoBahanKimia`, dan `KargoPecahBelah` mewarisi class `Kargo`. | `KargoReguler.php`, `KargoBahanKimia.php`, `KargoPecahBelah.php` |
| Abstraction | Class `Kargo` dibuat abstract dan memiliki abstract method yang wajib diimplementasikan subclass. | `kargo.php` |
| Polymorphism | Method `hitungTarifPengiriman()` dan `validasiSOPPacking()` dioverride oleh setiap subclass dan dipanggil melalui collection bertipe `Kargo`. | `ManajemenLogistik.php`, `driver_polymorphism.php` |

---

## Alur Kerja Program

1. File `driver_polymorphism.php` memanggil file koneksi dan class manajemen.
2. Objek `ManajemenLogistik` dibuat dengan parameter koneksi database.
3. Method `muatDataDariDatabase()` mengambil data dari tabel utama dan tabel turunan.
4. Data dari database diubah menjadi objek `KargoReguler`, `KargoBahanKimia`, atau `KargoPecahBelah`.
5. Semua objek disimpan dalam array `$daftarKargo`.
6. Method `buatLaporanPolymorphic()` melakukan perulangan pada seluruh objek kargo.
7. Saat method `hitungTarifPengiriman()` dan `validasiSOPPacking()` dipanggil, PHP menjalankan method sesuai subclass masing-masing.
8. Hasil laporan ditampilkan pada dashboard.

---

## Validasi Kontribusi Commit GitHub

Berdasarkan riwayat commit yang terdapat pada repository, kontribusi anggota kelompok dapat dirangkum sebagai berikut:

| Anggota / Username Git | Jumlah Commit | File / Bagian yang Dikerjakan | Ringkasan Kontribusi |
|---|---:|---|---|
| `dwitalistanti-byte` | 11 | `README.md` | Membuat dan memperbarui dokumentasi README, menambahkan penjelasan database dan koneksi. |
| `naelladw` | 9 | `KargoReguler.php`, `KargoBahanKimia.php`, `KargoPecahBelah.php` | Membuat class turunan kargo dan melakukan debugging pada class bahan kimia. |
| `Galuh Dwi Putra` | 2 | `ManajemenLogistik.php`, `driver_polymorphism.php` | Menambahkan class manajemen logistik dan halaman driver polymorphism/dashboard. |
| `Kharisma Putri Isabela` | 2 | `kargo.php` | Menambahkan class induk `Kargo`. |
| `deaameliana` | 1 | `db_pengiriman.sql`, `Koneksi.php` | Menambahkan database dan koneksi PHP ke MySQL. |

> Catatan validasi: jumlah commit di atas diambil dari riwayat Git repository. Jika ada commit baru setelah README ini dibuat, tabel perlu diperbarui agar sesuai dengan grafik kontribusi commit terbaru di GitHub.

---

## Logbook Aktivitas Mingguan

| Minggu / Tanggal | Anggota | Aktivitas | Bukti Validasi Commit | Status |
|---|---|---|---|---|
| 8 Juni 2026 | Galuh Dwi Putra | Melakukan percobaan push awal ke repository. | Commit `11cb252` - `mencoba push (Galuh)` | Tervalidasi |
| 8 Juni 2026 | Naella | Melakukan percobaan push awal dari perangkat anggota. | Commit `41505d0` - `Mencoba push di laptop naella` | Tervalidasi |
| 9 Juni 2026 | Dea | Menambahkan database `db_pengiriman` dan file koneksi database. | Commit `332ce1d` - `Menambahkan database db_pengiriman dan koneksi.php` | Tervalidasi |
| 9 Juni 2026 | Kharisma Putri Isabela | Menambahkan class induk `Kargo`. | Commit `4edecdc` - `Menambahkan file kargo.php` | Tervalidasi |
| 9 Juni 2026 | Naella | Menambahkan class turunan `KargoReguler`, `KargoBahanKimia`, dan `KargoPecahBelah`. | Commit `bbd51d8`, `95a0d65`, `0a7d8e0` | Tervalidasi |
| 9 Juni 2026 | Dwita | Menambahkan file README dan mulai mengisi dokumentasi. | Commit `186d587`, `fed59ca`, `15ec227` | Tervalidasi |
| 10 Juni 2026 | Dwita | Memperbarui README dengan penjelasan database dan koneksi. | Commit `513b761`, `e95362b`, `43f0dfb` | Tervalidasi |
| 10 Juni 2026 | Naella | Melakukan debugging pada file `KargoBahanKimia.php`. | Commit `db2c552` - `Debugging KargoBahanKimia.php` | Tervalidasi |
| 11 Juni 2026 | Galuh Dwi Putra | Menambahkan `ManajemenLogistik.php` dan `driver_polymorphism.php` untuk penerapan polymorphism dan dashboard. | Commit `2274b04` - `Menambahkan ManajemenLogistik.php dan driver_polymorphism.php` | Tervalidasi |

---

## Kesimpulan

Proyek Sistem Manajemen Pengiriman Kargo telah menerapkan empat pilar utama OOP. Encapsulation digunakan untuk melindungi atribut class, inheritance digunakan untuk membentuk class turunan dari class induk `Kargo`, abstraction digunakan melalui abstract class dan abstract method, sedangkan polymorphism diterapkan melalui overriding method pada setiap subclass dan pemanggilan method secara dynamic binding pada `ManajemenLogistik.php`.

Dengan penerapan OOP ini, kode program menjadi lebih terstruktur, mudah dikembangkan, dan setiap jenis kargo dapat memiliki aturan perhitungan tarif serta validasi SOP packing yang berbeda tanpa mengubah struktur utama program.
