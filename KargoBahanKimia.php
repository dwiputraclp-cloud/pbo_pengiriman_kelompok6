<?php
require_once "kargo.php";

class KargoBahanKimia extends Kargo
{
    private $tingkatBahaya;
    private $jenisSertifikasiSandi;

    public function __construct(
        $id_resi,
        $pengirim,
        $kotaTujuan,
        $beratBarang,
        $tarifDasarPerKg,
        $tingkatBahaya,
        $jenisSertifikasiSandi
    ) {
        parent::__construct(
            $id_resi,
            $pengirim,
            $kotaTujuan,
            $beratBarang,
            $tarifDasarPerKg
        );

        $this->tingkatBahaya = $tingkatBahaya;
        $this->jenisSertifikasiSandi = $jenisSertifikasiSandi;
    }

    public function getTingkatBahaya()
    {
        return $this->tingkatBahaya;
    }

    public function getJenisSertifikasiSandi()
    {
        return $this->jenisSertifikasiSandi;
    }

    /**
     * Mengambil angka dari tingkat bahaya.
     * Aman untuk data berbentuk angka 1, 2, 3 maupun teks seperti "Class 1".
     */
    private function ambilAngkaTingkatBahaya()
    {
        if (is_numeric($this->tingkatBahaya)) {
            return (int) $this->tingkatBahaya;
        }

        preg_match('/\d+/', (string) $this->tingkatBahaya, $hasil);

        if (!empty($hasil)) {
            return (int) $hasil[0];
        }

        return 1;
    }

    // Overriding
    public function hitungTarifPengiriman()
    {
        $tarifDasar = (float) $this->beratBarang * (float) $this->tarifDasarPerKg;

        $angkaTingkatBahaya = $this->ambilAngkaTingkatBahaya();
        $biayaPenangananKhusus = $angkaTingkatBahaya * 100000;

        return $tarifDasar + $biayaPenangananKhusus;
    }

    public function validasiSOPPacking()
    {
        return "Memerlukan sertifikasi {$this->jenisSertifikasiSandi} untuk tingkat bahaya {$this->tingkatBahaya}";
    }
}
?>