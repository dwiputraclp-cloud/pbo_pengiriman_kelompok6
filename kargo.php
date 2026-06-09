<?php

abstract class Kargo
{
    // Encapsulation
    protected $id_resi;
    protected $pengirim;
    protected $kotaTujuan;
    protected $beratBarang;
    protected $tarifDasarPerKg;

    /**
     * Constructor
     */
    public function __construct(
        $id_resi,
        $pengirim,
        $kotaTujuan,
        $beratBarang,
        $tarifDasarPerKg
    ) {
        $this->id_resi = $id_resi;
        $this->pengirim = $pengirim;
        $this->kotaTujuan = $kotaTujuan;
        $this->beratBarang = $beratBarang;
        $this->tarifDasarPerKg = $tarifDasarPerKg;
    }

    // Getter
    public function getIdResi()
    {
        return $this->id_resi;
    }

    public function getPengirim()
    {
        return $this->pengirim;
    }

    public function getKotaTujuan()
    {
        return $this->kotaTujuan;
    }

    public function getBeratBarang()
    {
        return $this->beratBarang;
    }

    public function getTarifDasarPerKg()
    {
        return $this->tarifDasarPerKg;
    }

    // Setter
    public function setPengirim($pengirim)
    {
        $this->pengirim = $pengirim;
    }

    public function setKotaTujuan($kotaTujuan)
    {
        $this->kotaTujuan = $kotaTujuan;
    }

    public function setBeratBarang($beratBarang)
    {
        $this->beratBarang = $beratBarang;
    }

    public function setTarifDasarPerKg($tarifDasarPerKg)
    {
        $this->tarifDasarPerKg = $tarifDasarPerKg;
    }

    /**
     * Method abstrak untuk menghitung tarif pengiriman.
     * Wajib diimplementasikan oleh subclass.
     */
    abstract public function hitungTarifPengiriman();

    /**
     * Method abstrak untuk validasi SOP packing.
     * Wajib diimplementasikan oleh subclass.
     */
    abstract public function validasiSOPPacking();
}