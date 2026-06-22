<?php

require_once __DIR__ . '/Karyawan.php';

class KaryawanMagang extends Karyawan {

    // Properti tambahan spesifik Karyawan Magang
    protected $uangSakuBulanan;
    protected $sertifikatKampusMerdeka;

    public function __construct($id_karyawan, $nama_karyawan, $departemen, $hariKerjaMasuk, $gajiDasarPerHari, $uangSakuBulanan, $sertifikatKampusMerdeka) {
        parent::__construct($id_karyawan, $nama_karyawan, $departemen, $hariKerjaMasuk, $gajiDasarPerHari);

        $this->uangSakuBulanan        = $uangSakuBulanan;
        $this->sertifikatKampusMerdeka = $sertifikatKampusMerdeka;
    }

    // Metode query spesifik - ambil semua data Karyawan Magang dari database
    public function getDaftarMagang() {
        $query  = "SELECT * FROM tabel_karyawan WHERE jenis_karyawan = 'Magang'";
        $result = $this->conn->query($query);
        return $result;
    }

    // Implementasi abstract method: gaji bersih = (hari kerja x gaji dasar) + uang saku bulanan
    public function hitungGajiBersih() {
        return ($this->hariKerjaMasuk * $this->gajiDasarPerHari) + ($this->uangSakuBulanan ?? 0);
    }

    // Implementasi abstract method: profil spesifik Karyawan Magang
    public function tampilkanProfilKaryawan() {
        return [
            'jenis'                     => 'Magang',
            'uang_saku_bulanan'         => $this->uangSakuBulanan         ?? '-',
            'sertifikat_kampus_merdeka' => $this->sertifikatKampusMerdeka ?? '-',
        ];
    }
}