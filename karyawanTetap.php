<?php

require_once __DIR__ . '/Karyawan.php';

class KaryawanTetap extends Karyawan {

    // Properti tambahan spesifik Karyawan Tetap
    protected $tunjanganKesehatan;
    protected $opsiSahamId;

    public function __construct($id_karyawan, $nama_karyawan, $departemen, $hariKerjaMasuk, $gajiDasarPerHari, $tunjanganKesehatan, $opsiSahamId) {
        parent::__construct($id_karyawan, $nama_karyawan, $departemen, $hariKerjaMasuk, $gajiDasarPerHari);

        $this->tunjanganKesehatan = $tunjanganKesehatan;
        $this->opsiSahamId        = $opsiSahamId;
    }

    // Metode query spesifik - ambil semua data Karyawan Tetap dari database
    public function getDaftarTetap() {
        $query  = "SELECT * FROM tabel_karyawan WHERE jenis_karyawan = 'Tetap'";
        $result = $this->conn->query($query);
        return $result;
    }

    // Tahap 5 - Overriding hitungGajiBersih():
    // Gaji bersih = (hari_kerja_masuk * gaji_dasar_per_hari) + tunjangan_kesehatan
    // (mendapatkan tambahan tunjangan kesehatan/keluarga yang besarnya bervariasi)
    public function hitungGajiBersih() {
        return ($this->hariKerjaMasuk * $this->gajiDasarPerHari) + ($this->tunjanganKesehatan ?? 0);
    }

    // Implementasi abstract method: profil spesifik Karyawan Tetap
    public function tampilkanProfilKaryawan() {
        return [
            'jenis'               => 'Tetap',
            'tunjangan_kesehatan' => $this->tunjanganKesehatan ?? '-',
            'opsi_saham_id'       => $this->opsiSahamId        ?? '-',
        ];
    }
}