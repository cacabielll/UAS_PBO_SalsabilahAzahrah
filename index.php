<?php
require_once __DIR__ . '/KaryawanKontrak.php';
require_once __DIR__ . '/KaryawanTetap.php';
require_once __DIR__ . '/KaryawanMagang.php';

// Objek dummy untuk akses query & conn
$objKontrak = new KaryawanKontrak(0,'','',0,0,null,null);
$objTetap   = new KaryawanTetap(0,'','',0,0,null,null);
$objMagang  = new KaryawanMagang(0,'','',0,0,null,null);

$resKontrak = $objKontrak->getDaftarKontrak();
$resTetap   = $objTetap->getDaftarTetap();
$resMagang  = $objMagang->getDaftarMagang();

function rupiahFormat($n) {
    return 'Rp ' . number_format($n, 0, ',', '.');
}

// Kumpulkan semua ke array PHP
$rows = [];

while ($r = $resKontrak->fetch_assoc()) {
    $obj   = new KaryawanKontrak($r['id_karyawan'],$r['nama_karyawan'],$r['departemen'],$r['hari_kerja_masuk'],$r['gaji_dasar_per_hari'],$r['durasi_kontrak_bulan'],$r['agensi_penyalur']);
    $profil = $obj->tampilkanProfilKaryawan();
    $gajiBersih = $obj->hitungGajiBersih();
    $rows[] = ['jenis'=>'Kontrak','raw'=>$r,'profil'=>$profil,'gaji_bersih'=>$gajiBersih,'gaji_pokok'=>$r['hari_kerja_masuk']*$r['gaji_dasar_per_hari']];
}
while ($r = $resTetap->fetch_assoc()) {
    $obj   = new KaryawanTetap($r['id_karyawan'],$r['nama_karyawan'],$r['departemen'],$r['hari_kerja_masuk'],$r['gaji_dasar_per_hari'],$r['tunjangan_kesehatan'],$r['opsi_saham_id']);
    $profil = $obj->tampilkanProfilKaryawan();
    $gajiBersih = $obj->hitungGajiBersih();
    $rows[] = ['jenis'=>'Tetap','raw'=>$r,'profil'=>$profil,'gaji_bersih'=>$gajiBersih,'gaji_pokok'=>$r['hari_kerja_masuk']*$r['gaji_dasar_per_hari']];
}
while ($r = $resMagang->fetch_assoc()) {
    $obj   = new KaryawanMagang($r['id_karyawan'],$r['nama_karyawan'],$r['departemen'],$r['hari_kerja_masuk'],$r['gaji_dasar_per_hari'],$r['uang_saku_bulanan'],$r['sertifikat_kampus_merdeka']);
    $profil = $obj->tampilkanProfilKaryawan();
    $gajiBersih = $obj->hitungGajiBersih();
    $rows[] = ['jenis'=>'Magang','raw'=>$r,'profil'=>$profil,'gaji_bersih'=>$gajiBersih,'gaji_pokok'=>$r['hari_kerja_masuk']*$r['gaji_dasar_per_hari']];
}

$totalKontrak = $resKontrak->num_rows;
$totalTetap   = $resTetap->num_rows;
$totalMagang  = $resMagang->num_rows;
$totalAll     = $totalKontrak + $totalTetap + $totalMagang;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Manajemen Karyawan</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

:root {
    --purple:     #7c3aed;
    --purple-light: #8b5cf6;
    --purple-pale:  #ede9fe;
    --purple-soft:  #f5f3ff;
    --blue:       #3b82f6;
    --blue-pale:  #eff6ff;
    --pink:       #ec4899;
    --pink-pale:  #fdf2f8;
    --green:      #10b981;
    --green-pale: #ecfdf5;
    --bg:         #f8f7ff;
    --card:       #ffffff;
    --text-1:     #1e1b4b;
    --text-2:     #6b7280;
    --text-3:     #a0aec0;
    --radius-xl:  24px;
    --radius-lg:  16px;
    --radius-md:  12px;
    --radius-sm:  8px;
    --sidebar-w:  68px;
}

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Inter', sans-serif;
    background: var(--bg);
    color: var(--text-1);
    display: flex;
    min-height: 100vh;
}

/* ── SIDEBAR ── */
.sidebar {
    width: var(--sidebar-w);
    background: linear-gradient(180deg, var(--purple) 0%, #5b21b6 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px 0;
    position: fixed;
    top: 0; left: 0; bottom: 0;
    z-index: 100;
    border-radius: 0 20px 20px 0;
    gap: 6px;
}

.sidebar-logo {
    width: 40px; height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    margin-bottom: 24px;
}

.nav-item {
    width: 42px; height: 42px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    cursor: pointer;
    color: rgba(255,255,255,0.6);
    transition: all 0.2s;
}

.nav-item:hover  { background: rgba(255,255,255,0.15); color: #fff; }
.nav-item.active { background: rgba(255,255,255,0.25); color: #fff; }
.sidebar-bottom  { margin-top: auto; }

/* ── MAIN ── */
.main {
    margin-left: var(--sidebar-w);
    flex: 1;
    display: flex;
    gap: 18px;
    padding: 22px 18px;
    min-height: 100vh;
}

.content { flex: 1; display: flex; flex-direction: column; gap: 18px; min-width: 0; }

/* ── TOPBAR ── */
.topbar { display: flex; align-items: center; gap: 12px; }

.search-wrap { flex: 1; position: relative; }

.search-wrap input {
    width: 100%;
    padding: 11px 16px 11px 42px;
    border: none;
    border-radius: var(--radius-lg);
    background: var(--card);
    font-size: 0.875rem;
    color: var(--text-1);
    outline: none;
    box-shadow: 0 2px 8px rgba(124,58,237,0.07);
    font-family: 'Inter', sans-serif;
}

.search-wrap input::placeholder { color: var(--text-3); }
.search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-3); pointer-events: none; }

.icon-btn {
    width: 40px; height: 40px;
    border-radius: var(--radius-md);
    background: var(--card);
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; cursor: pointer;
    box-shadow: 0 2px 8px rgba(124,58,237,0.07);
    transition: background 0.2s;
}
.icon-btn:hover { background: var(--purple-pale); }

/* ── HERO BANNER ── */
.hero {
    background: linear-gradient(135deg, var(--purple) 0%, #a855f7 60%, #ec4899 100%);
    border-radius: var(--radius-xl);
    padding: 28px 32px;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
    min-height: 140px;
}

.hero::before {
    content: '';
    position: absolute;
    top: -50px; right: 120px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
}
.hero::after {
    content: '';
    position: absolute;
    bottom: -60px; right: -20px;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}

.hero-text { z-index: 1; }
.hero-text p  { font-size: 0.82rem; opacity: 0.8; margin-bottom: 6px; letter-spacing: 0.04em; text-transform: uppercase; }
.hero-text h2 { font-size: 1.5rem; font-weight: 800; line-height: 1.2; }

.hero-stats { display: flex; gap: 12px; z-index: 1; }

.stat-card {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: var(--radius-lg);
    padding: 14px 18px;
    text-align: center;
    backdrop-filter: blur(8px);
    min-width: 70px;
}
.stat-card .num { font-size: 1.6rem; font-weight: 800; }
.stat-card .lbl { font-size: 0.65rem; opacity: 0.8; margin-top: 2px; letter-spacing: 0.05em; }

/* ── TAB PILLS ── */
.tab-row { display: flex; gap: 8px; flex-wrap: wrap; }

.tab-pill {
    padding: 9px 22px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    border: 2px solid transparent;
    background: var(--card);
    color: var(--text-2);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: all 0.18s;
    display: flex; align-items: center; gap: 6px;
}

.tab-pill:hover { border-color: var(--purple-pale); color: var(--purple); }
.tab-pill.active { background: var(--purple); color: #fff; border-color: var(--purple); box-shadow: 0 4px 14px rgba(124,58,237,0.35); }

/* ── CARD GRID ── */
.card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
    gap: 14px;
}

/* ── SLIP CARD ── */
.slip-card {
    background: var(--card);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(124,58,237,0.06);
    transition: transform 0.2s, box-shadow 0.2s;
}

.slip-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(124,58,237,0.14);
}

/* Card header - ilustrasi */
.card-header {
    padding: 20px 20px 14px;
    position: relative;
    overflow: hidden;
    min-height: 90px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
}

.header-kontrak { background: linear-gradient(135deg, #ede9fe, #ddd6fe); }
.header-tetap   { background: linear-gradient(135deg, #ecfdf5, #d1fae5); }
.header-magang  { background: linear-gradient(135deg, #fdf2f8, #fce7f3); }

.card-avatar {
    width: 44px; height: 44px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.avatar-kontrak { background: linear-gradient(135deg, var(--purple), var(--purple-light)); }
.avatar-tetap   { background: linear-gradient(135deg, var(--green), #34d399); }
.avatar-magang  { background: linear-gradient(135deg, var(--pink), #f472b6); }

.jenis-badge {
    font-size: 0.65rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.badge-kontrak { background: var(--purple); color: #fff; }
.badge-tetap   { background: var(--green);  color: #fff; }
.badge-magang  { background: var(--pink);   color: #fff; }

/* Deco blob */
.header-blob {
    position: absolute;
    bottom: -20px; right: -20px;
    width: 80px; height: 80px;
    border-radius: 50%;
    opacity: 0.18;
}
.blob-kontrak { background: var(--purple); }
.blob-tetap   { background: var(--green); }
.blob-magang  { background: var(--pink); }

/* Card body */
.card-body { padding: 16px 20px; }

.karyawan-nama {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text-1);
    margin-bottom: 2px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}

.karyawan-dept {
    font-size: 0.75rem;
    color: var(--text-2);
    margin-bottom: 14px;
    display: flex; align-items: center; gap: 4px;
}

/* Progress bar hari kerja */
.progress-wrap { margin-bottom: 14px; }
.progress-label {
    display: flex; justify-content: space-between;
    font-size: 0.7rem; color: var(--text-2);
    margin-bottom: 5px;
}
.progress-track {
    height: 6px;
    background: #f1f0f9;
    border-radius: 10px;
    overflow: hidden;
}
.progress-fill {
    height: 100%;
    border-radius: 10px;
    transition: width 0.6s ease;
}
.fill-kontrak { background: linear-gradient(90deg, var(--purple), var(--purple-light)); }
.fill-tetap   { background: linear-gradient(90deg, var(--green), #34d399); }
.fill-magang  { background: linear-gradient(90deg, var(--pink), #f472b6); }

/* Spesifikasi info */
.spec-box {
    background: var(--purple-soft);
    border-radius: var(--radius-md);
    padding: 10px 12px;
    margin-bottom: 14px;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.spec-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.73rem;
}

.spec-key   { color: var(--text-2); font-weight: 500; }
.spec-val   { color: var(--text-1); font-weight: 600; text-align: right; max-width: 60%; word-break: break-word; }
.spec-null  { color: var(--text-3); font-style: italic; font-weight: 400; }

/* Gaji section */
.gaji-section {
    border-top: 1px dashed #e5e7f0;
    padding-top: 12px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.gaji-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.75rem;
}

.gaji-label { color: var(--text-2); }
.gaji-val   { color: var(--text-1); font-weight: 500; }
.gaji-coret { text-decoration: line-through; color: var(--text-3); font-size: 0.7rem; }

.gaji-bersih-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 6px;
    padding-top: 6px;
    border-top: 1px solid #f0eefe;
}

.gaji-bersih-label { font-size: 0.78rem; font-weight: 600; color: var(--text-1); }

.gaji-bersih-val { font-size: 1rem; font-weight: 800; }
.val-kontrak { color: var(--purple); }
.val-tetap   { color: var(--green); }
.val-magang  { color: var(--pink); }

/* ── RIGHT PANEL ── */
.right-panel { width: 220px; flex-shrink: 0; display: flex; flex-direction: column; gap: 14px; }

.panel-card {
    background: var(--card);
    border-radius: var(--radius-xl);
    padding: 18px 16px;
    box-shadow: 0 4px 16px rgba(124,58,237,0.06);
}

/* Profil */
.profile-avatar {
    width: 52px; height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--purple), var(--pink));
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    margin: 0 auto 10px;
}

.profile-name { font-size: 0.88rem; font-weight: 700; text-align: center; color: var(--text-1); }
.profile-role { font-size: 0.72rem; color: var(--text-2); text-align: center; margin-bottom: 12px; }

.profile-btn {
    display: block; width: 100%;
    padding: 8px;
    background: linear-gradient(135deg, var(--purple), var(--purple-light));
    color: #fff;
    border: none; border-radius: 30px;
    font-size: 0.75rem; font-weight: 600;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
}

/* Ringkasan */
.panel-title { font-size: 0.8rem; font-weight: 700; color: var(--text-1); margin-bottom: 14px; }

.sum-row {
    display: flex; align-items: center; gap: 10px;
    padding: 8px 6px; border-radius: var(--radius-md);
    cursor: pointer; transition: background 0.15s;
    margin-bottom: 4px;
}

.sum-row:hover { background: var(--purple-soft); }

.sum-icon {
    width: 34px; height: 34px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.95rem; flex-shrink: 0;
}

.icon-k { background: var(--purple-pale); }
.icon-t { background: var(--green-pale); }
.icon-m { background: var(--pink-pale); }

.sum-info { flex: 1; }
.sum-label { font-size: 0.75rem; font-weight: 600; color: var(--text-1); }
.sum-sub   { font-size: 0.65rem; color: var(--text-2); }
.sum-count { font-size: 0.75rem; font-weight: 700; color: var(--purple); }

/* Monthly expenses style */
.expense-row {
    display: flex; align-items: center; gap: 10px;
    padding: 8px 0;
    border-bottom: 1px solid #f5f3ff;
}
.expense-row:last-child { border-bottom: none; }
.exp-icon {
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; flex-shrink: 0;
}
.exp-label { font-size: 0.72rem; font-weight: 600; color: var(--text-1); flex: 1; }
.exp-val   { font-size: 0.72rem; font-weight: 700; color: var(--purple); }

/* empty state */
.empty-state {
    grid-column: 1/-1;
    text-align: center;
    padding: 48px 0;
    color: var(--text-3);
    font-size: 0.875rem;
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">🏢</div>
    <div class="nav-item active">🏠</div>
    <div class="nav-item">👤</div>
    <div class="nav-item">📊</div>
    <div class="nav-item">📄</div>
    <div class="nav-item">📅</div>
    <div class="sidebar-bottom">
        <div class="nav-item">⚙️</div>
    </div>
</aside>

<div class="main">

    <!-- CONTENT -->
    <div class="content">

        <!-- Topbar -->
        <div class="topbar">
            <div class="search-wrap">
                <span class="search-icon">🔍</span>
                <input type="text" id="searchInput" placeholder="Cari nama karyawan atau departemen...">
            </div>
            <div class="icon-btn">🔔</div>
            <div class="icon-btn">📌</div>
        </div>

        <!-- Hero Banner -->
        <div class="hero">
            <div class="hero-text">
                <p>Sistem Manajemen Karyawan</p>
                <h2>Slip Gaji &amp;<br>Profil Karyawan</h2>
            </div>
            <div class="hero-stats">
                <div class="stat-card">
                    <div class="num"><?= $totalAll ?></div>
                    <div class="lbl">TOTAL</div>
                </div>
                <div class="stat-card">
                    <div class="num"><?= $totalKontrak ?></div>
                    <div class="lbl">KONTRAK</div>
                </div>
                <div class="stat-card">
                    <div class="num"><?= $totalTetap ?></div>
                    <div class="lbl">TETAP</div>
                </div>
                <div class="stat-card">
                    <div class="num"><?= $totalMagang ?></div>
                    <div class="lbl">MAGANG</div>
                </div>
            </div>
        </div>

        <!-- Tab Pills -->
        <div class="tab-row">
            <div class="tab-pill active" onclick="filterTab('semua',this)">🗂️ Semua</div>
            <div class="tab-pill" onclick="filterTab('Kontrak',this)">📋 Kontrak</div>
            <div class="tab-pill" onclick="filterTab('Tetap',this)">🏅 Tetap</div>
            <div class="tab-pill" onclick="filterTab('Magang',this)">🎓 Magang</div>
        </div>

        <!-- Card Grid -->
        <div class="card-grid" id="cardGrid">

            <?php foreach ($rows as $d):
                $r       = $d['raw'];
                $profil  = $d['profil'];
                $jenis   = strtolower($d['jenis']);
                $pokok   = $d['gaji_pokok'];
                $bersih  = $d['gaji_bersih'];
                $persen  = min(100, round(($r['hari_kerja_masuk'] / 26) * 100));

                // Label spesifikasi per jenis
                if ($d['jenis'] === 'Kontrak') {
                    $specs = [
                        'Durasi Kontrak' => ($profil['durasi_kontrak_bulan'] !== '-') ? $profil['durasi_kontrak_bulan'].' bulan' : null,
                        'Agensi Penyalur' => $profil['agensi_penyalur'] !== '-' ? $profil['agensi_penyalur'] : null,
                    ];
                    $gajiKet = 'Murni hari kehadiran';
                    $gajiExtra = null;
                } elseif ($d['jenis'] === 'Tetap') {
                    $specs = [
                        'Tunjangan Kesehatan' => ($profil['tunjangan_kesehatan'] !== '-') ? rupiahFormat($profil['tunjangan_kesehatan']) : null,
                        'ID Opsi Saham'       => $profil['opsi_saham_id'] !== '-' ? $profil['opsi_saham_id'] : null,
                    ];
                    $gajiKet   = '+ Tunjangan Kesehatan';
                    $gajiExtra = ($profil['tunjangan_kesehatan'] !== '-') ? rupiahFormat($profil['tunjangan_kesehatan']) : 'Rp 0';
                } else {
                    $specs = [
                        'Uang Saku Bulanan'   => ($profil['uang_saku_bulanan'] !== '-') ? rupiahFormat($profil['uang_saku_bulanan']) : null,
                        'Sertifikat KM'       => $profil['sertifikat_kampus_merdeka'] !== '-' ? $profil['sertifikat_kampus_merdeka'] : null,
                    ];
                    $gajiKet   = 'Potongan orientasi 20%';
                    $gajiExtra = '-'.rupiahFormat($pokok * 0.20);
                }
            ?>
            <div class="slip-card"
                 data-jenis="<?= $d['jenis'] ?>"
                 data-nama="<?= strtolower($r['nama_karyawan']) ?>"
                 data-dept="<?= strtolower($r['departemen']) ?>">

                <!-- Header -->
                <div class="card-header header-<?= $jenis ?>">
                    <div class="card-avatar avatar-<?= $jenis ?>">
                        <?php
                        $initials = strtoupper(substr($r['nama_karyawan'], 0, 1));
                        echo $initials;
                        ?>
                    </div>
                    <span class="jenis-badge badge-<?= $jenis ?>"><?= $d['jenis'] ?></span>
                    <div class="header-blob blob-<?= $jenis ?>"></div>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <div class="karyawan-nama"><?= htmlspecialchars($r['nama_karyawan']) ?></div>
                    <div class="karyawan-dept">🏢 <?= htmlspecialchars($r['departemen']) ?></div>

                    <!-- Progress hari kerja -->
                    <div class="progress-wrap">
                        <div class="progress-label">
                            <span>Hari Kerja</span>
                            <span><?= $r['hari_kerja_masuk'] ?> / 26 hari</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill fill-<?= $jenis ?>" style="width:<?= $persen ?>%"></div>
                        </div>
                    </div>

                    <!-- Spesifikasi jabatan -->
                    <div class="spec-box">
                        <?php foreach ($specs as $key => $val): ?>
                        <div class="spec-row">
                            <span class="spec-key"><?= $key ?></span>
                            <?php if ($val): ?>
                                <span class="spec-val"><?= htmlspecialchars($val) ?></span>
                            <?php else: ?>
                                <span class="spec-null">—</span>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                        <div class="spec-row">
                            <span class="spec-key">Gaji/Hari</span>
                            <span class="spec-val"><?= rupiahFormat($r['gaji_dasar_per_hari']) ?></span>
                        </div>
                    </div>

                    <!-- Slip Gaji -->
                    <div class="gaji-section">
                        <div class="gaji-row">
                            <span class="gaji-label">Gaji Pokok</span>
                            <span class="gaji-val"><?= rupiahFormat($pokok) ?></span>
                        </div>
                        <?php if ($gajiExtra): ?>
                        <div class="gaji-row">
                            <span class="gaji-label"><?= $gajiKet ?></span>
                            <span class="gaji-val <?= ($d['jenis']==='Magang') ? 'gaji-coret' : '' ?>">
                                <?= $gajiExtra ?>
                            </span>
                        </div>
                        <?php endif; ?>
                        <div class="gaji-bersih-row">
                            <span class="gaji-bersih-label">💰 Gaji Bersih</span>
                            <span class="gaji-bersih-val val-<?= $jenis ?>"><?= rupiahFormat($bersih) ?></span>
                        </div>
                    </div>

                </div>
            </div>
            <?php endforeach; ?>

            <div id="emptyState" class="empty-state" style="display:none;">
                Tidak ada data yang cocok.
            </div>
        </div>

    </div><!-- /content -->

    <!-- RIGHT PANEL -->
    <div class="right-panel">

        <!-- Profil -->
        <div class="panel-card" style="text-align:center;">
            <div class="profile-avatar">👩‍💼</div>
            <div class="profile-name">Admin HR</div>
            <div class="profile-role">Manajer Sumber Daya Manusia</div>
            <button class="profile-btn">Lihat Profil</button>
        </div>

        <!-- Ringkasan -->
        <div class="panel-card">
            <div class="panel-title">Kelompok Karyawan</div>

            <div class="sum-row" onclick="filterTab('Kontrak',null)">
                <div class="sum-icon icon-k">📋</div>
                <div class="sum-info">
                    <div class="sum-label">Kontrak</div>
                    <div class="sum-sub">Berbasis kehadiran</div>
                </div>
                <div class="sum-count"><?= $totalKontrak ?></div>
            </div>

            <div class="sum-row" onclick="filterTab('Tetap',null)">
                <div class="sum-icon icon-t">🏅</div>
                <div class="sum-info">
                    <div class="sum-label">Tetap</div>
                    <div class="sum-sub">+ Tunjangan</div>
                </div>
                <div class="sum-count"><?= $totalTetap ?></div>
            </div>

            <div class="sum-row" onclick="filterTab('Magang',null)">
                <div class="sum-icon icon-m">🎓</div>
                <div class="sum-info">
                    <div class="sum-label">Magang</div>
                    <div class="sum-sub">Potongan 20%</div>
                </div>
                <div class="sum-count"><?= $totalMagang ?></div>
            </div>
        </div>

        <!-- Keterangan Gaji -->
        <div class="panel-card">
            <div class="panel-title">Keterangan Gaji</div>
            <div class="expense-row">
                <div class="exp-icon icon-k">📋</div>
                <div class="exp-label">Kontrak</div>
                <div class="exp-val">Murni</div>
            </div>
            <div class="expense-row">
                <div class="exp-icon icon-t">🏅</div>
                <div class="exp-label">Tetap</div>
                <div class="exp-val">+ Tunjangan</div>
            </div>
            <div class="expense-row">
                <div class="exp-icon icon-m">🎓</div>
                <div class="exp-label">Magang</div>
                <div class="exp-val">× 0.80</div>
            </div>
        </div>

    </div><!-- /right-panel -->

</div><!-- /main -->

<script>
let activeTab = 'semua';

function filterTab(jenis, btn) {
    activeTab = jenis;

    if (btn) {
        document.querySelectorAll('.tab-pill').forEach(el => el.classList.remove('active'));
        btn.classList.add('active');
    } else {
        document.querySelectorAll('.tab-pill').forEach(el => {
            el.classList.remove('active');
            if (el.textContent.trim().includes(jenis)) el.classList.add('active');
        });
    }
    applyFilter();
}

function applyFilter() {
    const q     = document.getElementById('searchInput').value.toLowerCase().trim();
    const cards = document.querySelectorAll('.slip-card');
    let visible = 0;

    cards.forEach(card => {
        const matchTab    = activeTab === 'semua' || card.dataset.jenis === activeTab;
        const matchSearch = !q || card.dataset.nama.includes(q) || card.dataset.dept.includes(q);
        const show        = matchTab && matchSearch;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    document.getElementById('emptyState').style.display = visible === 0 ? 'grid' : 'none';
}

document.getElementById('searchInput').addEventListener('input', applyFilter);
</script>
</body>
</html>