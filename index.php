<!DOCTYPE html>
<html>
<head>
    <title>Paket Wisata</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <!-- Menampilkan gambar-gambar destinasi wisata -->
    <div class="gallery">
        <h2>Gambar Destinasi Wisata</h2>

        <?php
        foreach ($cursor as $document) {
            echo '<div class="destination">';
            echo '<h3>' . $document->nama . '</h3>';

            // Menampilkan gambar-gambar destinasi
            foreach ($destination[$document->nama] as $image) {
                echo '<img src="images/' . $image . '" alt="' . $image . '">';
            }

            echo '</div>';
        }
        ?>
    </div>

    <h1>Paket Wisata</h1>

    <?php
    // Menghubungkan ke MongoDB
    $client = new MongoDB\Driver\Manager("mongodb://localhost:27017");

    // Menentukan peran pengguna (admin/user)
    $role = isset($_GET['role']) ? $_GET['role'] : 'user';

    // Menampilkan daftar paket wisata
    $query = new MongoDB\Driver\Query([]);
    $cursor = $client->executeQuery('Paketwisataa.paket_wisataa', $query);

    echo '<h2>Daftar Paket Wisata</h2>';
    echo '<table>';
    echo '<tr><th>ID</th><th>Nama</th><th>Destinasi</th><th>Harga</th>';

    if ($role === 'admin') {
        echo '<th>Aksi</th>';
    }

    echo '</tr>';

    foreach ($cursor as $document) {
        echo '<tr>';
        echo '<td>' . $document->Id . '</td>';
        echo '<td>' . $document->Nama . '</td>';
        echo '<td>' . $document->Destinasi . '</td>';
        echo '<td>' . $document->Harga . '</td>';

        if ($role === 'admin') {
            echo '<td><a href="edit.php?id=' . $document->_id . '">Edit</a> | <a href="delete.php?id=' . $document->_id . '">Hapus</a></td>';
        }

        echo '</tr>';
    }

    echo '</table>';

    // Jika pengguna adalah admin, tampilkan form untuk menambahkan paket wisata baru
    if ($role === 'admin') {
        echo '<h2>Tambah Paket Wisata Baru</h2>';
        echo '<form action="insert.php" method="post">';
        echo '<label for="nama">Nama:</label>';
        echo '<input type="text" name="nama" id="nama" required><br>';
        echo '<label for="destinasi">Destinasi:</label>';
        echo '<input type="text" name="destinasi" id="destinasi" required><br>';
        echo '<label for="harga">Harga:</label>';
        echo '<input type="text" name="harga" id="harga" required><br>';
        echo '<input type="submit" value="Tambah">';
        echo '</form>';
    }
    ?>

    <br>

    <!-- Tautan untuk masuk sebagai admin atau user -->
    <a href="index.php?role=admin">Masuk sebagai Admin</a> |
    <a href="index.php?role=user">Masuk sebagai User</a>
</body>
</html>
