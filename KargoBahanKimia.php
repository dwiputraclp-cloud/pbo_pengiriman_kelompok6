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

    // Overriding
    public function hitungTarifPengiriman()
    {
        $tarifDasar = $this->beratBarang * $this->tarifDasarPerKg;

        $biayaPenangananKhusus =
            $this->tingkatBahaya * 100000;

        return $tarifDasar + $biayaPenangananKhusus;
    }

    public function validasiSOPPacking()
    {
        return "Memerlukan sertifikasi {$this->jenisSertifikasiSandi}";
    }
}
?>