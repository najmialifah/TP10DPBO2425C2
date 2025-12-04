<?php
require_once __DIR__ . '/../viewmodels/PenjualanViewModel.php';

$viewModel = new PenjualanViewModel();
$viewModel->loadAllPenjualan();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Penjualan Album</title>
</head>
<body>

    <h1>Daftar Penjualan Album</h1>

    <?php if (!empty($viewModel->successMessage)): ?>
        <p style="color: green;"><?php echo $viewModel->successMessage; ?></p>
    <?php endif; ?>

    <p><a href="index.php?page=penjualan&action=create">Tambah Data Penjualan Baru</a></p>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Album</th>
                <th>Grup</th>
                <th>Jumlah Terjual</th>
                <th>Negara</th>
                <th>Sumber Chart</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($viewModel->penjualanList as $jual): ?>
                <tr>
                    <td><?php echo htmlspecialchars($jual['id']); ?></td>
                    <td><?php echo htmlspecialchars($jual['judul_album']); ?></td>
                    <td><?php echo htmlspecialchars($jual['nama_grup']); ?></td>
                    <td><?php echo number_format($jual['jumlah_terjual'], 0, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($jual['negara']); ?></td>
                    <td><?php echo htmlspecialchars($jual['sumber_chart']); ?></td>
                    <td>
                        <a href="index.php?page=penjualan&action=edit&id=<?php echo $jual['id']; ?>">Edit</a> |
                        <a href="index.php?page=penjualan&action=delete&id=<?php echo $jual['id']; ?>" onclick="return confirm('Yakin ingin menghapus data penjualan ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>