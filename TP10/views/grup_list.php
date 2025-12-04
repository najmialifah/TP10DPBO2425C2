<?php
require_once __DIR__ . '/../viewmodels/GrupViewModel.php';

$viewModel = new GrupViewModel();
$viewModel->loadAllGrup();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Grup K-Pop</title>
</head>
<body>

    <h1>Daftar Grup K-Pop</h1>

    <?php if (!empty($viewModel->successMessage)): ?>
        <p style="color: green;"><?php echo $viewModel->successMessage; ?></p>
    <?php endif; ?>

    <p><a href="index.php?page=grup&action=create">Tambah Grup Baru</a></p>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Grup</th>
                <th>Agensi</th>
                <th>Tahun Debut</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($viewModel->grupList as $grup): ?>
                <tr>
                    <td><?php echo htmlspecialchars($grup['id']); ?></td>
                    <td><?php echo htmlspecialchars($grup['nama_grup']); ?></td>
                    <td><?php echo htmlspecialchars($grup['agensi']); ?></td>
                    <td><?php echo htmlspecialchars($grup['tahun_debut']); ?></td>
                    <td>
                        <a href="index.php?page=grup&action=edit&id=<?php echo $grup['id']; ?>">Edit</a> |
                        <a href="index.php?page=grup&action=delete&id=<?php echo $grup['id']; ?>" onclick="return confirm('Yakin ingin menghapus grup ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>