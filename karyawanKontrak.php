<?php

require_once __DIR__ . '/Karyawan.php';

class KaryawanKontrak extends Karyawan {

    // Properti tambahan spesifik Karyawan Kontrak
    protected $durasiKontrakBulan;
    protected $agensiPenyalur;

    public function __construct($id_karyawan, $nama_karyawan, $departemen, $hariKerjaMasuk, $gajiDasarPerHari, $durasiKontrakBulan, $agensiPenyalur) {
        parent::__construct($id_karyawan, $nama_karyawan, $departemen, $hariKerjaMasuk, $gajiDasarPerHari);

        $this->durasiKontrakBulan = $durasiKontrakBulan;
        $this->agensiPenyalur     = $agensiPenyalur;
    }

    // Metode query spesifik - ambil semua data Karyawan Kontrak dari database
    public function getDaftarKontrak() {
        $query  = "SELECT * FROM tabel_karyawan WHERE jenis_karyawan = 'Kontrak'";
        $result = $this->conn->query($query);
        return $result;
    }

    // Tahap 5 - Overriding hitungGajiBersih():
    // Gaji bersih = hari_kerja_masuk * gaji_dasar_per_hari
    // (penggajian murni berdasarkan jumlah hari kehadiran, tanpa tunjangan)
    public function hitungGajiBersih() {
        return $this->hariKerjaMasuk * $this->gajiDasarPerHari;
    }

    // Implementasi abstract method: profil spesifik Karyawan Kontrak
    public function tampilkanProfilKaryawan() {
        return [
            'jenis'                => 'Kontrak',
            'durasi_kontrak_bulan' => $this->durasiKontrakBulan ?? '-',
            'agensi_penyalur'      => $this->agensiPenyalur     ?? '-',
        ];
    }
}
