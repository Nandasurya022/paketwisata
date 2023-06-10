<?php
// Menghubungkan ke MongoDB
$client = new MongoDB\Driver\Manager("mongodb://localhost:27017");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan ID dokumen yang akan diedit
    $id = $_POST['id'];

    // Mendapatkan data dari form
    $Id = $_POST['Id'];
    $nama = $_POST['nama'];
    $destinasi = $_POST['destinasi'];
    $harga = $_POST['harga'];

    // Menyiapkan dokumen yang akan diupdate
    $document = [
        'Id' => new MongoDB\BSON\ObjectID($Id),
        'Nama' => $Nama,
        'Destinasi' => $Destinasi,
        'Harga' => $Harga
    ];

    // Menyimpan perubahan ke koleksi "paket"
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->update(['_id' => new MongoDB\BSON\ObjectID($id)], ['$set' => $document]);
    $client->executeBulkWrite('Paketwisataa.paket_wisataa', $bulk);

    // Kembali ke halaman utama
    header('Location: index.php');
    exit();
} else {
    // Mendapatkan ID dokumen dari parameter URL
    $id = $_GET['id'];

    // Mengeksekusi query untuk mendapatkan data paket wisata berdasarkan ID
    $query = new MongoDB\Driver\Query(['_id' => new MongoDB\BSON\ObjectID($id)]);
    $cursor = $client->executeQuery('Paketwisataa.paket_wisataa', $query);

    // Memeriksa apakah data ditemukan
    if (count($cursor) === 0) {
        // Jika tidak ditemukan, kembali ke halaman utama
        header('Location: index.php');
        exit();
    }

    // Mendapatkan data paket wisata
    $document = current($cursor->toArray());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Paket Wisata</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Edit Paket Wisata</h1>

    <form action="edit.php" method="post">
        <input type="hidden" name="id" value="<?php echo $document->_id; ?>">
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" value="<?php echo $document->nama; ?>" required><br>
        <label for="destinasi">Destinasi:</label>
        <input type="text" name="destinasi" id="destinasi" value="<?php echo $document->destinasi; ?>" required><br>
        <label for="harga">Harga:</label>
        <input type="text" name="harga" id="harga" value="<?php echo $document->harga; ?>" required><br>
        <input type="submit" value="Simpan">
    </form>

    <br>
    <a href="index.php">Kembali ke Daftar Paket Wisata</a>
</body>
</html>
