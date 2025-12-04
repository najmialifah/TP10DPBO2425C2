<?php
require_once __DIR__ . '/../viewmodels/AlbumViewModel.php';
require_once __DIR__ . '/../viewmodels/GrupViewModel.php'; 

$viewModel = new AlbumViewModel();
$viewModel->loadAllAlbum();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Album K-Pop</title>
</head>
<body>

    <h1>Daftar Album K-Pop</h1>

    <?php if (!empty($viewModel->successMessage)): ?>
        <p style="color: green;"><?php echo $viewModel->successMessage; ?></p>
    <?php endif; ?>

    <p><a href="index.php?page=album&action=create">Tambah Album Baru</a></p>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Album</th>
                <th>Jenis Album</th>
                <th>Grup</th>
                <th>Tanggal Rilis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($viewModel->albumList as $album): ?>
                <tr>
                    <td><?php echo htmlspecialchars($album['id']); ?></td>
                    <td><?php echo htmlspecialchars($album['judul_album']); ?></td>
                    <td><?php echo htmlspecialchars($album['jenis_album']); ?></td>
                    <td><?php echo htmlspecialchars($album['nama_grup']); ?></td>
                    <td><?php echo htmlspecialchars($album['tgl_rilis']); ?></td>
                    <td>
                        <a href="index.php?page=album&action=edit&id=<?php echo $album['id']; ?>">Edit</a> |
                        <a href="index.php?page=album&action=delete&id=<?php echo $album['id']; ?>" onclick="return confirm('Yakin ingin menghapus album ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>