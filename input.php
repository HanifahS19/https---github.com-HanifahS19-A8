<?php
// Pengaturan MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "penduduk_db2";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek jika ada data yang ingin dimasukkan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kecamatan'])) {
    // Mengambil data dengan aman
    $kecamatan = $_POST['kecamatan'] ?? '';
    $luas = $_POST['luas'] ?? 0;
    $jumlah_penduduk = $_POST['jumlah_penduduk'] ?? 0;
    $longitude = $_POST['longitude'] ?? 0;
    $latitude = $_POST['latitude'] ?? 0;

    // Menyiapkan query dengan prepared statements untuk keamanan
    $stmt = $conn->prepare("INSERT INTO penduduk (kecamatan, luas, jumlah_penduduk, longitude, latitude) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdidd", $kecamatan, $luas, $jumlah_penduduk, $longitude, $latitude);

    // Eksekusi query dan cek hasil
    if ($stmt->execute()) {
        // Redirect kembali ke halaman tampilan setelah menambahkan data
        header("Location: index.php"); // ganti ke view.php untuk melihat data
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Menutup statement
    $stmt->close();
}

// Menutup koneksi
$conn->close();
?>
