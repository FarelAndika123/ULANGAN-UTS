<?php
require_once "koneksi.php";

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["kirim"])) {
    $nama_pelapor  = trim($_POST["nama_pelapor"] ?? "");
    $nama_fasilitas = trim($_POST["nama_fasilitas"] ?? "");
    $lokasi        = trim($_POST["lokasi"] ?? "");
    $id_kategori   = (int) ($_POST["id_kategori"] ?? 0);
    $deskripsi     = trim($_POST["deskripsi"] ?? "");
    $prioritas     = trim($_POST["prioritas"] ?? "");

    if (
        $nama_pelapor === "" ||
        $nama_fasilitas === "" ||
        $lokasi === "" ||
        $id_kategori <= 0 ||
        $deskripsi === "" ||
        $prioritas === ""
    ) {
        $pesan = "Semua data wajib diisi.";
    } else {
        $sql = "INSERT INTO laporan_kerusakan
                (nama_pelapor, nama_fasilitas, lokasi, id_kategori, deskripsi, prioritas)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            $pesan = "Query gagal disiapkan: " . $conn->error;
        } else {
            $stmt->bind_param(
                "sssiss",
                $nama_pelapor,
                $nama_fasilitas,
                $lokasi,
                $id_kategori,
                $deskripsi,
                $prioritas
            );

            if ($stmt->execute()) {
                $pesan = "Laporan berhasil disimpan!";
            } else {
                $pesan = "Gagal menyimpan laporan: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaporan Kerusakan Fasilitas Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-primary text-white">  
    <div class="container">
        <h1 class="fw-bold">Sistem Pelaporan Kerusakan Fasilitas Sekolah</h1>

        <nav class="d-flex gap-4">
    <a href="#form-laporan" class="text-white text-decoration-none">
        Buat Laporan
    </a>
    <a href="#daftar-laporan" class="text-white text-decoration-none">
        Daftar Laporan
    </a>
</nav>
    </div>
</header>

    <main>
        <section id="form-laporan">
            

            <?php if ($pesan !== ""): ?>
                <p>
                    <?= htmlspecialchars($pesan, ENT_QUOTES, "UTF-8") ?>
                </p>
            <?php endif; ?>

<form action="" method="post">
    <div class="card p-4 mb-4">
        <h3 class="mb-4">Data Pelaporan</h3>

        <div class="mb-3">
            <label for="nama_pelapor" class="form-label">
                Nama pelapor
            </label>
            <input type="text" class="form-control"
                   id="nama_pelapor" name="nama_pelapor"
                   maxlength="100" required>
        </div>

        <div class="mb-3">
            <label for="nama_fasilitas" class="form-label">
                Nama fasilitas
            </label>
            <input type="text" class="form-control"
                   id="nama_fasilitas" name="nama_fasilitas"
                   maxlength="100" required>
        </div>

        <div class="mb-3">
            <label for="lokasi" class="form-label">
                Lokasi kerusakan
            </label>
            <input type="text" class="form-control"
                   id="lokasi" name="lokasi"
                   maxlength="100" required>
        </div>

        <div class="mb-3">
            <label for="id_kategori" class="form-label">
                Kategori fasilitas
            </label>
            <select class="form-select" id="id_kategori"
                    name="id_kategori" required>
                <option value="">-- Pilih kategori --</option>
                <option value="1">Elektronik</option>
                <option value="2">Furnitur</option>
                <option value="3">Jaringan</option>
                <option value="4">Peralatan Kelas</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">
                Deskripsi kerusakan
            </label>
            <textarea class="form-control" id="deskripsi"
                      name="deskripsi" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="prioritas" class="form-label">
                Prioritas
            </label>
            <select class="form-select" id="prioritas"
                    name="prioritas" required>
                <option value="">-- Pilih prioritas --</option>
                <option value="Rendah">Rendah</option>
                <option value="Sedang">Sedang</option>
                <option value="Tinggi">Tinggi</option>
            </select>
        </div>

        <button type="submit" name="kirim" class="btn btn-primary">
            Kirim Laporan
        </button>
    </div>
</form>
```
        </section>

        <section id="daftar-laporan">
            <h2>Daftar Laporan Kerusakan</h2>
            <p>Bagian ini belum mengambil data dari database.</p>
        </section>
    </main>
    <h1>BELUM TAU BU CARA NAMBAHIN DAFTAR LAPORAN NYA</h1>

    <footer>
        <p>&copy; 2024 Sistem Pelaporan Kerusakan Fasilitas Sekolah.</p>
    </footer>
</body>
</html>