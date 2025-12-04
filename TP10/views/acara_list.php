<?php
require_once __DIR__ . '/../viewmodels/AcaraViewModel.php';

$viewModel = new AcaraViewModel();
$viewModel->loadAllAcara();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Acara K-Pop</title>
</head>
<body>

    <h1>Daftar Acara K-Pop</h1>

    <?php if (!empty($viewModel->successMessage)): ?>
        <p style="color: green;"><?php echo $viewModel->successMessage; ?></p>
    <?php endif; ?>

    <p><a href="index.php?page=acara&action=create">Tambah Acara Baru</a></p>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Acara</th>
                <th>Jenis</th>
                <th>Lokasi</th>
                <th>Tanggal Acara</th>
                <th>Grup</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($viewModel->acaraList as $acara): ?>
                <tr>
                    <td><?php echo htmlspecialchars($acara['id']); ?></td>
                    <td><?php echo htmlspecialchars($acara['nama_acara']); ?></td>
                    <td><?php echo htmlspecialchars($acara['jenis_acara']); ?></td>
                    <td><?php echo htmlspecialchars($acara['lokasi']); ?></td>
                    <td><?php echo htmlspecialchars($acara['tgl_acara']); ?></td>
                    <td><?php echo htmlspecialchars($acara['nama_grup']); ?></td>
                    <td>
                        <a href="index.php?page=acara&action=edit&id=<?php echo $acara['id']; ?>">Edit</a> |
                        <a href="index.php?page=acara&action=delete&id=<?php echo $acara['id']; ?>" onclick="return confirm('Yakin ingin menghapus acara ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>