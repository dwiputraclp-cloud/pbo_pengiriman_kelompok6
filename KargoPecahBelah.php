<?php
require_once "kargo.php";

class KargoPecahBelah extends Kargo
{
    private $ketebalanBubbleWrap;
    private $biayaAsuransiWajib;

    public function __construct(
        $id_resi,
        $pengirim,
        $kotaTujuan,
        $beratBarang,
        $tarifDasarPerKg,
        $ketebalanBubbleWrap,
        $biayaAsuransiWajib
    ) {
        parent::__construct(
            $id_resi,
            $pengirim,
            $kotaTujuan,
            $beratBarang,
            $tarifDasarPerKg
        );

        $this->ketebalanBubbleWrap = $ketebalanBubbleWrap;
        $this->biayaAsuransiWajib = $biayaAsuransiWajib;
    }

    public function getKetebalanBubbleWrap()
    {
        return $this->ketebalanBubbleWrap;
    }

    public function getBiayaAsuransiWajib()
    {
        return $this->biayaAsuransiWajib;
    }

    // Overriding
    public function hitungTarifPengiriman()
    {
        $tarifBerat =
            $this->beratBarang * $this->tarifDasarPerKg;

        $surchargeFragile =
            $tarifBerat * 0.05;

        return $tarifBerat
            + $this->biayaAsuransiWajib
            + $surchargeFragile;
    }

    public function validasiSOPPacking()
    {
        return "Bubble Wrap {$this->ketebalanBubbleWrap} mm wajib digunakan";
    }
}
?>