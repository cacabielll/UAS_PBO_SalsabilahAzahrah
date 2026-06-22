<?php

require_once __DIR__ . '/koneksi.php';

abstract class Karyawan extends Database {

    // Atribut terenkapsulasi (protected) - dipetakan dari kolom tabel_karyawan
    protected $id_karyawan;
    protected $nama_karyawan;
    protected $departemen;
    protected $hariKerjaMasuk;
    protected $gajiDasarPerHari;

    public function __construct($id_karyawan, $nama_karyawan, $departemen, $hariKerjaMasuk, $gajiDasarPerHari) {
        parent::__construct(); // panggil koneksi dari Database

        $this->id_karyawan      = $id_karyawan;
        $this->nama_karyawan    = $nama_karyawan;
        $this->departemen       = $departemen;
        $this->hariKerjaMasuk   = $hariKerjaMasuk;
        $this->gajiDasarPerHari = $gajiDasarPerHari;
    }

    // Metode abstrak - wajib diimplementasikan di setiap kelas anak
    abstract public function hitungGajiBersih();
    abstract public function tampilkanProfilKaryawan();
}