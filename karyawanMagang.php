<?php

require_once __DIR__ . '/Karyawan.php';

class KaryawanMagang extends Karyawan {

    // Properti tambahan spesifik Karyawan Magang
    protected $uangSakuBulanan;
    protected $sertifikatKampusMerdeka;

    public function __construct($id_karyawan, $nama_karyawan, $departemen, $hariKerjaMasuk, $gajiDasarPerHari, $uangSakuBulanan, $sertifikatKampusMerdeka) {
        parent::__construct($id_karyawan, $nama_karyawan, $departemen, $hariKerjaMasuk, $gajiDasarPerHari);

        $this->uangSakuBulanan         = $uangSakuBulanan;
        $this->sertifikatKampusMerdeka = $sertifikatKampusMerdeka;
    }

    // Metode query spesifik - ambil semua data Karyawan Magang dari database
    public function getDaftarMagang() {
        $query  = "SELECT * FROM tabel_karyawan WHERE jenis_karyawan = 'Magang'";
        $result = $this->conn->query($query);
        return $result;
    }

    // Tahap 5 - Overriding hitungGajiBersih():
    // Gaji bersih = (hari_kerja_masuk * gaji_dasar_per_hari) * 0.80
    // (potongan 20% dari plafon harian untuk biaya program orientasi,
    //  pelatihan, atau asuransi kerja intern)
    public function hitungGajiBersih() {
        return ($this->hariKerjaMasuk * $this->gajiDasarPerHari) * 0.80;
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