<?php
require_once "kargo.php";

class KargoReguler extends Kargo
{
    private $jenisPaket;
    private $estimasiHari;

    public function __construct(
        $id_resi,
        $pengirim,
        $kotaTujuan,
        $beratBarang,
        $tarifDasarPerKg,
        $jenisPaket,
        $estimasiHari
    ) {
        parent::__construct(
            $id_resi,
            $pengirim,
            $kotaTujuan,
            $beratBarang,
            $tarifDasarPerKg
        );

        $this->jenisPaket = $jenisPaket;
        $this->estimasiHari = $estimasiHari;
    }

    public function getJenisPaket()
    {
        return $this->jenisPaket;
    }

    public function getEstimasiHari()
    {
        return $this->estimasiHari;
    }

    // Overriding
    public function hitungTarifPengiriman()
    {
        return $this->beratBarang * $this->tarifDasarPerKg;
    }

    public function validasiSOPPacking()
    {
        return "Packing reguler menggunakan {$this->jenisPaket}";
    }
}
?>