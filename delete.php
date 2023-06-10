<?php
// Menghubungkan ke MongoDB
$client = new MongoDB\Driver\Manager("mongodb://localhost:27017");

// Mendapatkan ID dokumen yang akan dihapus dari parameter URL
$id = $_GET['Id'];

// Menghapus dokumen berdasarkan ID
$bulk = new MongoDB\Driver\BulkWrite;
$bulk->delete(['_id' => new MongoDB\BSON\ObjectID($id)]);
$client->executeBulkWrite('Paketwisataa.paket_wisataa', $bulk);

// Kembali ke halaman utama
header('Location: index.php');
exit();
