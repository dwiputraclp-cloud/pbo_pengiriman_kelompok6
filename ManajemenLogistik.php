<?php
require_once "Koneksi.php";
require_once "KargoReguler.php";
require_once "KargoBahanKimia.php";
require_once "KargoPecahBelah.php";

class ManajemenLogistik
{
    private $koneksi;

    /**
     * Polymorphic Collection.
     * Di PHP, ArrayList dapat direpresentasikan menggunakan array.
     * Isi array ini bertipe kelas induk Kargo, tetapi objek aslinya bisa berupa:
     * KargoReguler, KargoBahanKimia, atau KargoPecahBelah.
     *
     * @var Kargo[]
     */
    private $daftarKargo = [];

    /**
     * Peta nama kolom database.
     * Dibuat fleksibel agar bisa membaca database yang memakai snake_case
     * maupun camelCase, misalnya kota_tujuan atau kotaTujuan.
     */
    private $kolom = [];

    public function __construct($koneksi)
    {
        $this->koneksi = $koneksi;
        $this->aturPetaKolom();
    }

    /**
     * Method untuk mengambil nama kolom yang benar-benar ada di database.
     * Contoh: jika kota_tujuan tidak ada, maka akan memakai kotaTujuan.
     */
    private function ambilNamaKolom($namaTabel, $pilihanKolom)
    {
        $hasil = $this->koneksi->query("SHOW COLUMNS FROM `$namaTabel`");

        if ($hasil === false) {
            throw new Exception("Tabel $namaTabel tidak ditemukan: " . $this->koneksi->error);
        }

        $kolomYangAda = [];
        while ($baris = $hasil->fetch_assoc()) {
            $kolomYangAda[] = $baris["Field"];
        }

        foreach ($pilihanKolom as $kolom) {
            if (in_array($kolom, $kolomYangAda)) {
                return $kolom;
            }
        }

        throw new Exception(
            "Kolom pada tabel $namaTabel tidak ditemukan. Pilihan yang dicari: " .
            implode(", ", $pilihanKolom)
        );
    }

    /**
     * Pemetaan kolom agar controller cocok dengan struktur database kamu.
     */
    private function aturPetaKolom()
    {
        $this->kolom = [
            "kargo" => [
                "idResi" => $this->ambilNamaKolom("kargo", ["id_resi"]),
                "pengirim" => $this->ambilNamaKolom("kargo", ["pengirim"]),
                "kotaTujuan" => $this->ambilNamaKolom("kargo", ["kota_tujuan", "kotaTujuan"]),
                "beratBarang" => $this->ambilNamaKolom("kargo", ["berat_barang", "beratBarang"]),
                "tarifDasarPerKg" => $this->ambilNamaKolom("kargo", ["tarif_dasar_perkg", "tarifDasarPerKg"])
            ],
            "reguler" => [
                "jenisPaket" => $this->ambilNamaKolom("kargo_reguler", ["jenis_paket", "jenisPaket"]),
                "estimasiHari" => $this->ambilNamaKolom("kargo_reguler", ["estimasi_hari", "estimasiHari"])
            ],
            "bahanKimia" => [
                "tingkatBahaya" => $this->ambilNamaKolom("kargo_bahan_kimia", ["tingkat_bahaya", "tingkatBahaya"]),
                "jenisSertifikasiSandi" => $this->ambilNamaKolom("kargo_bahan_kimia", ["jenis_sertifikasi_sandi", "jenisSertifikasiSandi"])
            ],
            "pecahBelah" => [
                "ketebalanBubbleWrap" => $this->ambilNamaKolom("kargo_pecah_belah", ["ketebalan_bubble_wrap", "ketebalanBubbleWrap"]),
                "biayaAsuransiWajib" => $this->ambilNamaKolom("kargo_pecah_belah", ["biaya_asuransi_wajib", "biayaAsuransiWajib"])
            ]
        ];
    }

    /**
     * Membungkus nama kolom dengan backtick agar aman dipakai di query SQL.
     */
    private function kolom($namaTabel, $namaKolom)
    {
        return "`" . $this->kolom[$namaTabel][$namaKolom] . "`";
    }

    /**
     * Menambahkan objek kargo ke collection tanpa menyimpan ke database.
     * Method ini menunjukkan bahwa semua subclass bisa diperlakukan sebagai Kargo.
     */
    public function tambahKeCollection(Kargo $kargo)
    {
        $this->daftarKargo[] = $kargo;
    }

    /**
     * Mengambil seluruh data dari database, lalu mengubahnya menjadi objek subclass.
     */
    public function muatDataDariDatabase()
    {
        $this->daftarKargo = [];

        $this->muatKargoReguler();
        $this->muatKargoBahanKimia();
        $this->muatKargoPecahBelah();

        return $this->daftarKargo;
    }

    private function muatKargoReguler()
    {
        $query = "SELECT k." . $this->kolom("kargo", "idResi") . " AS id_resi,
                         k." . $this->kolom("kargo", "pengirim") . " AS pengirim,
                         k." . $this->kolom("kargo", "kotaTujuan") . " AS kota_tujuan,
                         k." . $this->kolom("kargo", "beratBarang") . " AS berat_barang,
                         k." . $this->kolom("kargo", "tarifDasarPerKg") . " AS tarif_dasar_perkg,
                         r." . $this->kolom("reguler", "jenisPaket") . " AS jenis_paket,
                         r." . $this->kolom("reguler", "estimasiHari") . " AS estimasi_hari
                  FROM kargo k
                  INNER JOIN kargo_reguler r ON r." . $this->kolom("kargo", "idResi") . " = k." . $this->kolom("kargo", "idResi");

        $result = $this->koneksi->query($query);

        while ($data = $result->fetch_assoc()) {
            $this->daftarKargo[] = new KargoReguler(
                $data["id_resi"],
                $data["pengirim"],
                $data["kota_tujuan"],
                $data["berat_barang"],
                $data["tarif_dasar_perkg"],
                $data["jenis_paket"],
                $data["estimasi_hari"]
            );
        }
    }

    private function muatKargoBahanKimia()
    {
        $query = "SELECT k." . $this->kolom("kargo", "idResi") . " AS id_resi,
                         k." . $this->kolom("kargo", "pengirim") . " AS pengirim,
                         k." . $this->kolom("kargo", "kotaTujuan") . " AS kota_tujuan,
                         k." . $this->kolom("kargo", "beratBarang") . " AS berat_barang,
                         k." . $this->kolom("kargo", "tarifDasarPerKg") . " AS tarif_dasar_perkg,
                         b." . $this->kolom("bahanKimia", "tingkatBahaya") . " AS tingkat_bahaya,
                         b." . $this->kolom("bahanKimia", "jenisSertifikasiSandi") . " AS jenis_sertifikasi_sandi
                  FROM kargo k
                  INNER JOIN kargo_bahan_kimia b ON b." . $this->kolom("kargo", "idResi") . " = k." . $this->kolom("kargo", "idResi");

        $result = $this->koneksi->query($query);

        while ($data = $result->fetch_assoc()) {
            $this->daftarKargo[] = new KargoBahanKimia(
                $data["id_resi"],
                $data["pengirim"],
                $data["kota_tujuan"],
                $data["berat_barang"],
                $data["tarif_dasar_perkg"],
                $data["tingkat_bahaya"],
                $data["jenis_sertifikasi_sandi"]
            );
        }
    }

    private function muatKargoPecahBelah()
    {
        $query = "SELECT k." . $this->kolom("kargo", "idResi") . " AS id_resi,
                         k." . $this->kolom("kargo", "pengirim") . " AS pengirim,
                         k." . $this->kolom("kargo", "kotaTujuan") . " AS kota_tujuan,
                         k." . $this->kolom("kargo", "beratBarang") . " AS berat_barang,
                         k." . $this->kolom("kargo", "tarifDasarPerKg") . " AS tarif_dasar_perkg,
                         p." . $this->kolom("pecahBelah", "ketebalanBubbleWrap") . " AS ketebalan_bubble_wrap,
                         p." . $this->kolom("pecahBelah", "biayaAsuransiWajib") . " AS biaya_asuransi_wajib
                  FROM kargo k
                  INNER JOIN kargo_pecah_belah p ON p." . $this->kolom("kargo", "idResi") . " = k." . $this->kolom("kargo", "idResi");

        $result = $this->koneksi->query($query);

        while ($data = $result->fetch_assoc()) {
            $this->daftarKargo[] = new KargoPecahBelah(
                $data["id_resi"],
                $data["pengirim"],
                $data["kota_tujuan"],
                $data["berat_barang"],
                $data["tarif_dasar_perkg"],
                $data["ketebalan_bubble_wrap"],
                $data["biaya_asuransi_wajib"]
            );
        }
    }

    /**
     * Menyimpan objek Kargo ke tabel utama dan tabel turunan.
     */
    public function simpanKargo(Kargo $kargo)
    {
        $this->koneksi->begin_transaction();

        try {
            $queryKargo = "INSERT INTO kargo
                           (" . $this->kolom("kargo", "idResi") . ",
                            " . $this->kolom("kargo", "pengirim") . ",
                            " . $this->kolom("kargo", "kotaTujuan") . ",
                            " . $this->kolom("kargo", "beratBarang") . ",
                            " . $this->kolom("kargo", "tarifDasarPerKg") . ")
                           VALUES (?, ?, ?, ?, ?)";

            $stmtKargo = $this->koneksi->prepare($queryKargo);
            $idResi = $kargo->getIdResi();
            $pengirim = $kargo->getPengirim();
            $kotaTujuan = $kargo->getKotaTujuan();
            $beratBarang = $kargo->getBeratBarang();
            $tarifDasarPerKg = $kargo->getTarifDasarPerKg();

            $stmtKargo->bind_param(
                "sssdd",
                $idResi,
                $pengirim,
                $kotaTujuan,
                $beratBarang,
                $tarifDasarPerKg
            );
            $stmtKargo->execute();

            if ($kargo instanceof KargoReguler) {
                $this->simpanKargoReguler($kargo);
            } elseif ($kargo instanceof KargoBahanKimia) {
                $this->simpanKargoBahanKimia($kargo);
            } elseif ($kargo instanceof KargoPecahBelah) {
                $this->simpanKargoPecahBelah($kargo);
            } else {
                throw new Exception("Jenis kargo tidak dikenal.");
            }

            $this->koneksi->commit();
            $this->tambahKeCollection($kargo);
            return true;
        } catch (Exception $e) {
            $this->koneksi->rollback();
            return false;
        }
    }

    private function simpanKargoReguler(KargoReguler $kargo)
    {
        $query = "INSERT INTO kargo_reguler
                  (" . $this->kolom("kargo", "idResi") . ",
                   " . $this->kolom("reguler", "jenisPaket") . ",
                   " . $this->kolom("reguler", "estimasiHari") . ")
                  VALUES (?, ?, ?)";

        $stmt = $this->koneksi->prepare($query);
        $idResi = $kargo->getIdResi();
        $jenisPaket = $kargo->getJenisPaket();
        $estimasiHari = $kargo->getEstimasiHari();

        $stmt->bind_param("ssi", $idResi, $jenisPaket, $estimasiHari);
        $stmt->execute();
    }

    private function simpanKargoBahanKimia(KargoBahanKimia $kargo)
    {
        $query = "INSERT INTO kargo_bahan_kimia
                  (" . $this->kolom("kargo", "idResi") . ",
                   " . $this->kolom("bahanKimia", "tingkatBahaya") . ",
                   " . $this->kolom("bahanKimia", "jenisSertifikasiSandi") . ")
                  VALUES (?, ?, ?)";

        $stmt = $this->koneksi->prepare($query);
        $idResi = $kargo->getIdResi();
        $tingkatBahaya = $kargo->getTingkatBahaya();
        $jenisSertifikasiSandi = $kargo->getJenisSertifikasiSandi();

        $stmt->bind_param("sss", $idResi, $tingkatBahaya, $jenisSertifikasiSandi);
        $stmt->execute();
    }

    private function simpanKargoPecahBelah(KargoPecahBelah $kargo)
    {
        $query = "INSERT INTO kargo_pecah_belah
                  (" . $this->kolom("kargo", "idResi") . ",
                   " . $this->kolom("pecahBelah", "ketebalanBubbleWrap") . ",
                   " . $this->kolom("pecahBelah", "biayaAsuransiWajib") . ")
                  VALUES (?, ?, ?)";

        $stmt = $this->koneksi->prepare($query);
        $idResi = $kargo->getIdResi();
        $ketebalanBubbleWrap = $kargo->getKetebalanBubbleWrap();
        $biayaAsuransiWajib = $kargo->getBiayaAsuransiWajib();

        $stmt->bind_param("sdd", $idResi, $ketebalanBubbleWrap, $biayaAsuransiWajib);
        $stmt->execute();
    }

    public function getDaftarKargo()
    {
        return $this->daftarKargo;
    }

    public function cariKargoByResi($idResi)
    {
        foreach ($this->daftarKargo as $kargo) {
            if ($kargo->getIdResi() == $idResi) {
                return $kargo;
            }
        }

        return null;
    }

    public function hitungTotalTarifSemuaKargo()
    {
        $total = 0;

        foreach ($this->daftarKargo as $kargo) {
            // Dynamic Binding terjadi di sini.
            // PHP akan memilih method hitungTarifPengiriman()
            // sesuai class asli objek saat runtime.
            $total += $kargo->hitungTarifPengiriman();
        }

        return $total;
    }

    public function buatLaporanPolymorphic()
    {
        $laporan = [];

        foreach ($this->daftarKargo as $kargo) {
            // Dynamic Binding juga terjadi di dua baris ini.
            // PHP akan memanggil method sesuai class asli objek saat runtime.
            $tarif = $kargo->hitungTarifPengiriman();
            $sop = $kargo->validasiSOPPacking();

            $data = [
                "id_resi" => $kargo->getIdResi(),
                "jenis_kargo" => $this->getJenisKargo($kargo),
                "pengirim" => $kargo->getPengirim(),
                "kota_tujuan" => $kargo->getKotaTujuan(),
                "berat_barang" => $kargo->getBeratBarang(),
                "tarif_dasar_perkg" => $kargo->getTarifDasarPerKg(),
                "tarif_pengiriman" => $tarif,
                "validasi_sop" => $sop,

                // Default untuk atribut subclass.
                "jenis_paket" => "-",
                "estimasi_hari" => "-",
                "tingkat_bahaya" => "-",
                "jenis_sertifikasi_sandi" => "-",
                "ketebalan_bubble_wrap" => "-",
                "biaya_asuransi_wajib" => "-",
                "atribut_khusus" => "-",
                "rumus_tarif" => $this->getRumusTarif($kargo),
                "detail_perhitungan" => $this->getDetailPerhitungan($kargo)
            ];

            if ($kargo instanceof KargoReguler) {
                $data["jenis_paket"] = $kargo->getJenisPaket();
                $data["estimasi_hari"] = $kargo->getEstimasiHari();
                $data["atribut_khusus"] =
                    "Jenis Paket: " . $kargo->getJenisPaket() .
                    " | Estimasi: " . $kargo->getEstimasiHari() . " hari";
            }

            if ($kargo instanceof KargoBahanKimia) {
                $data["tingkat_bahaya"] = $kargo->getTingkatBahaya();
                $data["jenis_sertifikasi_sandi"] = $kargo->getJenisSertifikasiSandi();
                $data["atribut_khusus"] =
                    "Tingkat Bahaya: " . $kargo->getTingkatBahaya() .
                    " | Sertifikasi: " . $kargo->getJenisSertifikasiSandi();
            }

            if ($kargo instanceof KargoPecahBelah) {
                $data["ketebalan_bubble_wrap"] = $kargo->getKetebalanBubbleWrap();
                $data["biaya_asuransi_wajib"] = $kargo->getBiayaAsuransiWajib();
                $data["atribut_khusus"] =
                    "Bubble Wrap: " . $kargo->getKetebalanBubbleWrap() . " mm" .
                    " | Asuransi: Rp " . number_format($kargo->getBiayaAsuransiWajib(), 0, ',', '.');
            }

            $laporan[] = $data;
        }

        return $laporan;
    }

    private function ambilAngkaDariTeks($teks)
    {
        if (is_numeric($teks)) {
            return (int) $teks;
        }

        preg_match('/\d+/', (string) $teks, $hasil);

        if (!empty($hasil)) {
            return (int) $hasil[0];
        }

        return 1;
    }

    private function getRumusTarif(Kargo $kargo)
    {
        if ($kargo instanceof KargoReguler) {
            return "Berat * Tarif Dasar per Kg";
        }

        if ($kargo instanceof KargoBahanKimia) {
            return "(Berat * Tarif Dasar per Kg) + (Tingkat Bahaya * Rp100.000)";
        }

        if ($kargo instanceof KargoPecahBelah) {
            return "(Berat * Tarif Dasar per Kg) + Biaya Asuransi Wajib + Surcharge Fragile 5%";
        }

        return "-";
    }

    private function getDetailPerhitungan(Kargo $kargo)
    {
        $berat = (float) $kargo->getBeratBarang();
        $tarifDasar = (float) $kargo->getTarifDasarPerKg();
        $tarifBerat = $berat * $tarifDasar;

        if ($kargo instanceof KargoReguler) {
            return $berat . " kg x Rp " . number_format($tarifDasar, 0, ',', '.') .
                " = Rp " . number_format($tarifBerat, 0, ',', '.');
        }

        if ($kargo instanceof KargoBahanKimia) {
            $tingkatBahaya = $this->ambilAngkaDariTeks($kargo->getTingkatBahaya());
            $biayaPenanganan = $tingkatBahaya * 100000;
            $total = $tarifBerat + $biayaPenanganan;

            return "Rp " . number_format($tarifBerat, 0, ',', '.') . " + (" .
                $tingkatBahaya . " x Rp 100.000 = Rp " . number_format($biayaPenanganan, 0, ',', '.') . ")" .
                " = Rp " . number_format($total, 0, ',', '.');
        }

        if ($kargo instanceof KargoPecahBelah) {
            $asuransi = (float) $kargo->getBiayaAsuransiWajib();
            $surchargeFragile = $tarifBerat * 0.05;
            $total = $tarifBerat + $asuransi + $surchargeFragile;

            return "Rp " . number_format($tarifBerat, 0, ',', '.') . " + Rp " .
                number_format($asuransi, 0, ',', '.') . " + 5% x Rp " .
                number_format($tarifBerat, 0, ',', '.') . " = Rp " .
                number_format($total, 0, ',', '.');
        }

        return "-";
    }

    private function getJenisKargo(Kargo $kargo)
    {
        if ($kargo instanceof KargoReguler) {
            return "Kargo Reguler";
        }

        if ($kargo instanceof KargoBahanKimia) {
            return "Kargo Bahan Kimia";
        }

        if ($kargo instanceof KargoPecahBelah) {
            return "Kargo Pecah Belah";
        }

        return "Kargo Umum";
    }
}
?>
