<?php
// Menghubungkan ke MongoDB
$client = new MongoDB\Driver\Manager("mongodb://localhost:27017");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan data dari form
    $Id = $_POST['Id'];
    $Nama = $_POST['Nama'];
    $Destinasi = $_POST['Destinasi'];
    $Harga = $_POST['Harga'];

    // Menyiapkan dokumen baru
    $document = [
        'Id'=> $Id,
        'Nama' => $nama,
        'Destinasi' => $destinasi,
        'Harga' => $harga,
        'Gambar' => []
    ];

    // Memproses file gambar yang diupload
    if (isset($_FILES['gambar'])) {
        $gambar = $_FILES['gambar'];

        // Memindahkan file gambar ke direktori yang ditentukan
        $targetDir = 'images/';
        $targetFile = $targetDir . basename($gambar['name']);
        move_uploaded_file($gambar['tmp_name'], $targetFile);

        // Menambahkan nama file gambar ke dokumen
        $document['gambar'][] = $gambar['name'];
    }

    // Menyimpan dokumen ke koleksi "paket"
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->insert($document);
    $client->executeBulkWrite('Paketwisataa.paket_wisataa', $bulk);

    // Kembali ke halaman utama
    header('Location: index.php');
    exit();
}
