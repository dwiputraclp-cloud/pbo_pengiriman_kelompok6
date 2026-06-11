<?php
require_once "Koneksi.php";
require_once "ManajemenLogistik.php";

$manajemen = new ManajemenLogistik($koneksi);

// Mengambil data dari database dan memasukkannya ke Polymorphic Collection.
$manajemen->muatDataDariDatabase();

// Semua item diperlakukan sebagai Kargo,
// tetapi method yang berjalan tetap mengikuti class turunannya masing-masing.
$laporanSemua = $manajemen->buatLaporanPolymorphic();

$filterAktif = isset($_GET["jenis"]) ? $_GET["jenis"] : "dashboard";

$judulHalaman = [
    "dashboard" => "Dashboard",
    "semua" => "Semua Data Kargo",
    "reguler" => "Kargo Reguler",
    "bahan-kimia" => "Kargo Bahan Kimia",
    "pecah-belah" => "Kargo Pecah Belah"
];

function cocokDenganFilter($data, $filterAktif)
{
    if ($filterAktif == "dashboard" || $filterAktif == "semua") {
        return true;
    }

    if ($filterAktif == "reguler") {
        return $data["jenis_kargo"] == "Kargo Reguler";
    }

    if ($filterAktif == "bahan-kimia") {
        return $data["jenis_kargo"] == "Kargo Bahan Kimia";
    }

    if ($filterAktif == "pecah-belah") {
        return $data["jenis_kargo"] == "Kargo Pecah Belah";
    }

    return true;
}

$laporan = array_values(array_filter($laporanSemua, function ($data) use ($filterAktif) {
    return cocokDenganFilter($data, $filterAktif);
}));

$jumlahSemua = count($laporanSemua);
$jumlahReguler = count(array_filter($laporanSemua, function ($data) {
    return $data["jenis_kargo"] == "Kargo Reguler";
}));
$jumlahBahanKimia = count(array_filter($laporanSemua, function ($data) {
    return $data["jenis_kargo"] == "Kargo Bahan Kimia";
}));
$jumlahPecahBelah = count(array_filter($laporanSemua, function ($data) {
    return $data["jenis_kargo"] == "Kargo Pecah Belah";
}));

function hitungTotalTarif($laporan)
{
    $total = 0;
    foreach ($laporan as $data) {
        $total += $data["tarif_pengiriman"];
    }
    return $total;
}

$laporanReguler = array_values(array_filter($laporanSemua, function ($data) {
    return $data["jenis_kargo"] == "Kargo Reguler";
}));
$laporanBahanKimia = array_values(array_filter($laporanSemua, function ($data) {
    return $data["jenis_kargo"] == "Kargo Bahan Kimia";
}));
$laporanPecahBelah = array_values(array_filter($laporanSemua, function ($data) {
    return $data["jenis_kargo"] == "Kargo Pecah Belah";
}));

$totalTarif = hitungTotalTarif($laporan);
$totalTarifSemua = hitungTotalTarif($laporanSemua);
$totalTarifReguler = hitungTotalTarif($laporanReguler);
$totalTarifBahanKimia = hitungTotalTarif($laporanBahanKimia);
$totalTarifPecahBelah = hitungTotalTarif($laporanPecahBelah);

$namaHalaman = isset($judulHalaman[$filterAktif]) ? $judulHalaman[$filterAktif] : "Dashboard";

function formatRupiah($angka)
{
    return "Rp " . number_format((float) $angka, 0, ',', '.');
}

function tampilkanHeaderTabel($filterAktif)
{
    echo "<tr>";
    echo "<th>No</th>";
    echo "<th>ID Resi</th>";

    if ($filterAktif == "semua") {
        echo "<th>Jenis Kargo</th>";
    }

    echo "<th>Pengirim</th>";
    echo "<th>Kota Tujuan</th>";
    echo "<th>Berat</th>";
    echo "<th>Tarif/Kg</th>";

    if ($filterAktif == "reguler") {
        echo "<th>Jenis Paket</th>";
        echo "<th>Estimasi Hari</th>";
    } elseif ($filterAktif == "bahan-kimia") {
        echo "<th>Tingkat Bahaya</th>";
        echo "<th>Sertifikasi Sandi</th>";
    } elseif ($filterAktif == "pecah-belah") {
        echo "<th>Ketebalan Bubble Wrap</th>";
        echo "<th>Biaya Asuransi Wajib</th>";
    } else {
        echo "<th>Atribut Khusus Subclass</th>";
    }

    echo "<th>Tarif Pengiriman</th>";
    echo "<th>Validasi SOP</th>";
    echo "</tr>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manajemen Logistik</title>
    <style>
        :root {
            --powder-blue: #B3DEF8;
            --blue-gray: #58A1D3;
            --classic-blue: #0F4C81;
            --blue-slate: #022C50;
            --midnight: #06172E;
            --soft-bg: #EAF5FA;
            --white: #ffffff;
            --text-dark: #11263E;
            --text-muted: #6E8294;
            --border-soft: rgba(15, 76, 129, 0.12);
            --shadow-soft: 0 18px 40px rgba(2, 44, 80, 0.14);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(179, 222, 248, 0.95), transparent 34%),
                linear-gradient(135deg, #edf8fc 0%, #dceef5 45%, #eaf5fa 100%);
            color: var(--text-dark);
        }

        .dashboard {
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--blue-slate) 0%, var(--midnight) 100%);
            color: var(--white);
            padding: 26px 20px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            box-shadow: 14px 0 30px rgba(6, 23, 46, 0.22);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--powder-blue), var(--blue-gray));
            color: var(--blue-slate);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 12px 26px rgba(88, 161, 211, 0.28);
        }

        .brand-text h2 {
            font-size: 18px;
            margin: 0;
            letter-spacing: 0.3px;
        }

        .brand-text p {
            font-size: 12px;
            margin: 5px 0 0;
            color: var(--powder-blue);
        }

        .profile-box {
            background: rgba(179, 222, 248, 0.08);
            border: 1px solid rgba(179, 222, 248, 0.16);
            border-radius: 22px;
            padding: 16px;
            margin-bottom: 26px;
        }

        .profile-box .avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: var(--powder-blue);
            color: var(--blue-slate);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .profile-box h3 {
            margin: 0;
            font-size: 15px;
        }

        .profile-box p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #c8dded;
        }

        .menu-label {
            color: #9ec7e6;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin: 22px 0 10px;
        }

        .menu-link,
        .dropdown-title {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 13px 15px;
            color: #dcecf7;
            text-decoration: none;
            border-radius: 16px;
            font-size: 14px;
            transition: 0.2s;
            cursor: pointer;
        }

        .menu-link:hover,
        .dropdown-title:hover {
            background: rgba(179, 222, 248, 0.1);
            color: var(--white);
        }

        .menu-link.active,
        .dropdown-title.active {
            background: var(--powder-blue);
            color: var(--blue-slate);
            font-weight: bold;
            box-shadow: 0 12px 24px rgba(179, 222, 248, 0.16);
        }

        details {
            margin-bottom: 6px;
        }

        summary {
            list-style: none;
        }

        summary::-webkit-details-marker {
            display: none;
        }

        .dropdown-title::after {
            content: "▾";
            font-size: 12px;
            color: inherit;
        }

        details[open] .dropdown-title::after {
            content: "▴";
        }

        .submenu {
            margin: 8px 0 8px 18px;
            padding-left: 12px;
            border-left: 1px solid rgba(179, 222, 248, 0.22);
        }

        .submenu a {
            display: block;
            padding: 10px 12px;
            margin-bottom: 5px;
            color: #c8dded;
            font-size: 13px;
            text-decoration: none;
            border-radius: 12px;
        }

        .submenu a:hover {
            background: rgba(179, 222, 248, 0.1);
            color: var(--white);
        }

        .submenu a.active {
            background: rgba(88, 161, 211, 0.2);
            color: var(--powder-blue);
            font-weight: bold;
        }

        .sidebar-illustration {
            margin-top: 28px;
            padding: 16px;
            border-radius: 22px;
            background: rgba(179, 222, 248, 0.08);
            border: 1px solid rgba(179, 222, 248, 0.14);
            font-size: 12px;
            color: #c8dded;
            line-height: 1.5;
        }

        .main-content {
            margin-left: 280px;
            width: calc(100% - 280px);
            padding: 32px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .topbar h1 {
            margin: 0;
            font-size: 28px;
            color: var(--blue-slate);
        }

        .topbar p {
            margin: 7px 0 0;
            color: var(--text-muted);
            font-size: 14px;
        }

        .user-badge {
            background: rgba(255, 255, 255, 0.82);
            padding: 13px 18px;
            border-radius: 18px;
            box-shadow: var(--shadow-soft);
            font-size: 14px;
            color: var(--blue-slate);
            border: 1px solid var(--border-soft);
            white-space: nowrap;
        }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1.55fr) minmax(280px, 0.75fr);
            gap: 22px;
            margin-bottom: 24px;
        }

        .welcome-panel {
            min-height: 270px;
            border-radius: 32px;
            padding: 30px;
            color: var(--white);
            background:
                radial-gradient(circle at 88% 22%, rgba(179, 222, 248, 0.42), transparent 22%),
                linear-gradient(135deg, var(--classic-blue) 0%, var(--blue-slate) 58%, var(--midnight) 100%);
            box-shadow: var(--shadow-soft);
            position: relative;
            overflow: hidden;
        }

        .welcome-panel::after {
            content: "";
            position: absolute;
            right: -68px;
            bottom: -70px;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: rgba(179, 222, 248, 0.12);
        }

        .welcome-panel .mini-label {
            display: inline-block;
            background: rgba(179, 222, 248, 0.18);
            color: var(--powder-blue);
            border: 1px solid rgba(179, 222, 248, 0.22);
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .welcome-panel h2 {
            margin: 0;
            font-size: 36px;
            max-width: 620px;
            line-height: 1.18;
            position: relative;
            z-index: 1;
        }

        .welcome-panel p {
            margin: 14px 0 0;
            max-width: 650px;
            color: #d5ecfa;
            font-size: 15px;
            line-height: 1.7;
            position: relative;
            z-index: 1;
        }

        .hero-actions {
            margin-top: 25px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .btn-primary,
        .btn-secondary {
            display: inline-block;
            text-decoration: none;
            padding: 12px 16px;
            border-radius: 15px;
            font-size: 13px;
            font-weight: bold;
        }

        .btn-primary {
            background: var(--powder-blue);
            color: var(--blue-slate);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--white);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .summary-panel {
            border-radius: 32px;
            padding: 26px;
            background: rgba(255, 255, 255, 0.82);
            box-shadow: var(--shadow-soft);
            border: 1px solid var(--border-soft);
        }

        .summary-panel h3 {
            margin: 0;
            color: var(--blue-slate);
            font-size: 18px;
        }

        .summary-panel .big-number {
            margin-top: 18px;
            font-size: 42px;
            font-weight: bold;
            color: var(--classic-blue);
        }

        .summary-panel p {
            margin: 8px 0 0;
            color: var(--text-muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .progress-box {
            margin-top: 22px;
        }

        .progress-row {
            margin-bottom: 13px;
        }

        .progress-row span {
            display: flex;
            justify-content: space-between;
            color: var(--text-muted);
            font-size: 12px;
            margin-bottom: 6px;
        }

        .progress-track {
            height: 8px;
            background: #dbeaf4;
            border-radius: 999px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--blue-gray), var(--classic-blue));
            border-radius: 999px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .card,
        .cargo-card {
            background: rgba(255, 255, 255, 0.86);
            border-radius: 24px;
            padding: 20px;
            box-shadow: var(--shadow-soft);
            border: 1px solid var(--border-soft);
        }

        .cargo-card {
            text-decoration: none;
            color: inherit;
            display: block;
            transition: 0.2s;
        }

        .cargo-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 22px 48px rgba(2, 44, 80, 0.18);
        }

        .card-icon {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--powder-blue), var(--blue-gray));
            color: var(--blue-slate);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 14px;
        }

        .card span,
        .cargo-card span {
            color: var(--text-muted);
            font-size: 13px;
        }

        .card h3,
        .cargo-card h3 {
            margin: 9px 0 0;
            font-size: 30px;
            color: var(--blue-slate);
        }

        .cargo-card p {
            margin: 9px 0 0;
            color: var(--text-muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .cargo-card .tarif {
            margin-top: 14px;
            color: var(--classic-blue);
            font-weight: bold;
            font-size: 13px;
        }

        .dashboard-section-title {
            margin: 0 0 15px;
            color: var(--blue-slate);
            font-size: 21px;
        }

        .quick-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .quick-card {
            border-radius: 24px;
            padding: 20px;
            background: var(--blue-slate);
            color: var(--white);
            box-shadow: var(--shadow-soft);
            min-height: 145px;
        }

        .quick-card:nth-child(2) {
            background: var(--classic-blue);
        }

        .quick-card:nth-child(3) {
            background: var(--blue-gray);
            color: var(--blue-slate);
        }

        .quick-card h3 {
            margin: 0;
            font-size: 17px;
        }

        .quick-card p {
            margin: 12px 0 0;
            font-size: 13px;
            line-height: 1.6;
            opacity: 0.92;
        }

        .content-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 26px;
            padding: 24px;
            box-shadow: var(--shadow-soft);
            border: 1px solid var(--border-soft);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .table-header h2 {
            margin: 0;
            font-size: 20px;
            color: var(--blue-slate);
        }

        .total-box {
            background: #e2f4ff;
            color: var(--classic-blue);
            padding: 10px 14px;
            border-radius: 14px;
            font-weight: bold;
            font-size: 14px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
            font-size: 14px;
        }

        th,
        td {
            padding: 14px 12px;
            border-bottom: 1px solid rgba(15, 76, 129, 0.1);
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #eef7fc;
            color: var(--classic-blue);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        tr:hover {
            background: #f6fbfe;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            background: #dff0fb;
            color: var(--classic-blue);
            font-size: 12px;
            font-weight: bold;
        }

        .nowrap {
            white-space: nowrap;
        }

        .empty-state {
            padding: 34px;
            text-align: center;
            color: var(--text-muted);
            background: #f6fbfe;
            border-radius: 18px;
            border: 1px dashed rgba(15, 76, 129, 0.25);
        }

        .info-polymorphism {
            margin-top: 18px;
            padding: 15px;
            background: #e8f5fd;
            border-left: 5px solid var(--classic-blue);
            border-radius: 14px;
            color: var(--blue-slate);
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 1100px) {
            .hero,
            .quick-grid {
                grid-template-columns: 1fr;
            }

            .cards {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .sidebar {
                position: static;
                width: 100%;
                min-height: auto;
            }

            .dashboard {
                display: block;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 20px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 560px) {
            .cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-icon">🚚</div>
                <div class="brand-text">
                    <h2>Logistik App</h2>
                    <p>Dashboard Pengiriman</p>
                </div>
            </div>

            <div class="profile-box">
                <div class="avatar">G</div>
                <h3>Galuh</h3>
                <p>Controller & Polymorphic Driver Specialist</p>
            </div>

            <div class="menu-label">Menu Utama</div>

            <a class="menu-link <?= $filterAktif == 'dashboard' ? 'active' : ''; ?>" href="driver_polymorphism.php?jenis=dashboard">
                <span>🏠 Dashboard</span>
            </a>

            <details <?= $filterAktif != 'dashboard' ? 'open' : 'open'; ?>>
                <summary class="dropdown-title <?= $filterAktif != 'dashboard' ? 'active' : ''; ?>">
                    <span>📦 Kargo</span>
                </summary>
                <div class="submenu">
                    <a href="driver_polymorphism.php?jenis=semua" class="<?= $filterAktif == 'semua' ? 'active' : ''; ?>">
                        Semua Kargo
                    </a>
                    <a href="driver_polymorphism.php?jenis=reguler" class="<?= $filterAktif == 'reguler' ? 'active' : ''; ?>">
                        Kargo Reguler
                    </a>
                    <a href="driver_polymorphism.php?jenis=bahan-kimia" class="<?= $filterAktif == 'bahan-kimia' ? 'active' : ''; ?>">
                        Kargo Bahan Kimia
                    </a>
                    <a href="driver_polymorphism.php?jenis=pecah-belah" class="<?= $filterAktif == 'pecah-belah' ? 'active' : ''; ?>">
                        Kargo Pecah Belah
                    </a>
                </div>
            </details>

            <div class="sidebar-illustration">
                Polymorphic Collection menyimpan objek turunan sebagai tipe induk <b>Kargo</b>, lalu method overriding berjalan dinamis saat runtime.
            </div>
        </aside>

        <main class="main-content">
            <div class="topbar">
                <div>
                    <h1><?= htmlspecialchars($namaHalaman); ?></h1>
                    <p>Manajemen data pengiriman dengan konsep inheritance, overriding, polymorphism, dan dynamic binding.</p>
                </div>
                <div class="user-badge">
                    Job 4: <b>Galuh</b>
                </div>
            </div>

            <?php if ($filterAktif == "dashboard") : ?>
                <section class="hero">
                    <div class="welcome-panel">
                        <span class="mini-label">Dashboard Manajemen Logistik</span>
                        <h2>Selamat datang, Galuh 👋</h2>
                        <p>
                            Dashboard ini menampilkan ringkasan data kargo dari class induk <b>Kargo</b>
                            dan class turunan <b>KargoReguler</b>, <b>KargoBahanKimia</b>, serta <b>KargoPecahBelah</b>.
                            Pilih menu Kargo di sidebar untuk melihat data sesuai jenis subclass.
                        </p>
                        <div class="hero-actions">
                            <a href="driver_polymorphism.php?jenis=semua" class="btn-primary">Lihat Semua Kargo</a>
                            <a href="driver_polymorphism.php?jenis=reguler" class="btn-secondary">Kargo Reguler</a>
                        </div>
                    </div>

                    <div class="summary-panel">
                        <h3>Total Data Kargo</h3>
                        <div class="big-number"><?= $jumlahSemua; ?></div>
                        <p>Total seluruh data pengiriman yang berhasil dimuat dari database melalui controller ManajemenLogistik.</p>
                        <div class="progress-box">
                            <div class="progress-row">
                                <span><b>Reguler</b><b><?= $jumlahReguler; ?></b></span>
                                <div class="progress-track">
                                    <div class="progress-fill" style="width: <?= $jumlahSemua > 0 ? ($jumlahReguler / $jumlahSemua) * 100 : 0; ?>%;"></div>
                                </div>
                            </div>
                            <div class="progress-row">
                                <span><b>Bahan Kimia</b><b><?= $jumlahBahanKimia; ?></b></span>
                                <div class="progress-track">
                                    <div class="progress-fill" style="width: <?= $jumlahSemua > 0 ? ($jumlahBahanKimia / $jumlahSemua) * 100 : 0; ?>%;"></div>
                                </div>
                            </div>
                            <div class="progress-row">
                                <span><b>Pecah Belah</b><b><?= $jumlahPecahBelah; ?></b></span>
                                <div class="progress-track">
                                    <div class="progress-fill" style="width: <?= $jumlahSemua > 0 ? ($jumlahPecahBelah / $jumlahSemua) * 100 : 0; ?>%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <h2 class="dashboard-section-title">Card Kargo</h2>
                <section class="cards">
                    <a class="cargo-card" href="driver_polymorphism.php?jenis=semua">
                        <div class="card-icon">📦</div>
                        <span>Semua Kargo</span>
                        <h3><?= $jumlahSemua; ?></h3>
                        <p>Menampilkan semua data kargo dari seluruh subclass.</p>
                        <div class="tarif">Total: <?= formatRupiah($totalTarifSemua); ?></div>
                    </a>

                    <a class="cargo-card" href="driver_polymorphism.php?jenis=reguler">
                        <div class="card-icon">🚚</div>
                        <span>Kargo Reguler</span>
                        <h3><?= $jumlahReguler; ?></h3>
                        <p>Atribut tambahan: jenis paket dan estimasi hari.</p>
                        <div class="tarif">Total: <?= formatRupiah($totalTarifReguler); ?></div>
                    </a>

                    <a class="cargo-card" href="driver_polymorphism.php?jenis=bahan-kimia">
                        <div class="card-icon">⚗️</div>
                        <span>Kargo Bahan Kimia</span>
                        <h3><?= $jumlahBahanKimia; ?></h3>
                        <p>Atribut tambahan: tingkat bahaya dan sertifikasi sandi.</p>
                        <div class="tarif">Total: <?= formatRupiah($totalTarifBahanKimia); ?></div>
                    </a>

                    <a class="cargo-card" href="driver_polymorphism.php?jenis=pecah-belah">
                        <div class="card-icon">🧊</div>
                        <span>Kargo Pecah Belah</span>
                        <h3><?= $jumlahPecahBelah; ?></h3>
                        <p>Atribut tambahan: bubble wrap dan asuransi wajib.</p>
                        <div class="tarif">Total: <?= formatRupiah($totalTarifPecahBelah); ?></div>
                    </a>
                </section>

                <section class="quick-grid">
                    <div class="quick-card">
                        <h3>Controller Terpusat</h3>
                        <p>ManajemenLogistik menjadi penghubung antara tampilan dashboard, database, dan model class kargo.</p>
                    </div>
                    <div class="quick-card">
                        <h3>Polymorphic Collection</h3>
                        <p>Data kargo disimpan dalam satu collection bertipe induk, tetapi objek aslinya tetap berasal dari subclass.</p>
                    </div>
                    <div class="quick-card">
                        <h3>Dynamic Binding</h3>
                        <p>Method hitung tarif dan validasi SOP berjalan sesuai class asli objek saat runtime.</p>
                    </div>
                </section>
            <?php else : ?>
                <section class="cards">
                    <div class="card">
                        <div class="card-icon">📦</div>
                        <span>Total Semua Kargo</span>
                        <h3><?= $jumlahSemua; ?></h3>
                    </div>
                    <div class="card">
                        <div class="card-icon">🚚</div>
                        <span>Kargo Reguler</span>
                        <h3><?= $jumlahReguler; ?></h3>
                    </div>
                    <div class="card">
                        <div class="card-icon">⚗️</div>
                        <span>Kargo Bahan Kimia</span>
                        <h3><?= $jumlahBahanKimia; ?></h3>
                    </div>
                    <div class="card">
                        <div class="card-icon">🧊</div>
                        <span>Kargo Pecah Belah</span>
                        <h3><?= $jumlahPecahBelah; ?></h3>
                    </div>
                </section>

                <section class="content-card">
                    <div class="table-header">
                        <h2>Data <?= htmlspecialchars($namaHalaman); ?></h2>
                        <div class="total-box">
                            Total Tarif: <?= formatRupiah($totalTarif); ?>
                        </div>
                    </div>

                    <?php if (count($laporan) == 0) : ?>
                        <div class="empty-state">
                            Data kargo belum tersedia untuk menu ini.
                        </div>
                    <?php else : ?>
                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <?php tampilkanHeaderTabel($filterAktif); ?>
                                </thead>
                                <tbody>
                                    <?php foreach ($laporan as $index => $data) : ?>
                                        <tr>
                                            <td><?= $index + 1; ?></td>
                                            <td><b><?= htmlspecialchars($data["id_resi"]); ?></b></td>

                                            <?php if ($filterAktif == "semua") : ?>
                                                <td><span class="badge"><?= htmlspecialchars($data["jenis_kargo"]); ?></span></td>
                                            <?php endif; ?>

                                            <td><?= htmlspecialchars($data["pengirim"]); ?></td>
                                            <td><?= htmlspecialchars($data["kota_tujuan"]); ?></td>
                                            <td class="nowrap"><?= htmlspecialchars($data["berat_barang"]); ?> kg</td>
                                            <td class="nowrap"><?= formatRupiah($data["tarif_dasar_perkg"]); ?></td>

                                            <?php if ($filterAktif == "reguler") : ?>
                                                <td><?= htmlspecialchars($data["jenis_paket"]); ?></td>
                                                <td class="nowrap"><?= htmlspecialchars($data["estimasi_hari"]); ?> hari</td>
                                            <?php elseif ($filterAktif == "bahan-kimia") : ?>
                                                <td><?= htmlspecialchars($data["tingkat_bahaya"]); ?></td>
                                                <td><?= htmlspecialchars($data["jenis_sertifikasi_sandi"]); ?></td>
                                            <?php elseif ($filterAktif == "pecah-belah") : ?>
                                                <td class="nowrap"><?= htmlspecialchars($data["ketebalan_bubble_wrap"]); ?> mm</td>
                                                <td class="nowrap"><?= formatRupiah($data["biaya_asuransi_wajib"]); ?></td>
                                            <?php else : ?>
                                                <td><?= htmlspecialchars($data["atribut_khusus"]); ?></td>
                                            <?php endif; ?>

                                            <td class="nowrap"><b><?= formatRupiah($data["tarif_pengiriman"]); ?></b></td>
                                            <td><?= htmlspecialchars($data["validasi_sop"]); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <div class="info-polymorphism">
                        <b>Konsep OOP:</b> data pada tabel ini berasal dari collection bertipe induk <b>Kargo</b>.
                        Saat method <b>hitungTarifPengiriman()</b> dan <b>validasiSOPPacking()</b> dipanggil,
                        PHP menjalankan method sesuai objek aslinya, yaitu <b>KargoReguler</b>,
                        <b>KargoBahanKimia</b>, atau <b>KargoPecahBelah</b>.
                    </div>
                </section>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
