<?php
require_once __DIR__ . '/../viewmodels/MemberViewModel.php';

$viewModel = new MemberViewModel();
$viewModel->loadAllMember();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Member K-Pop</title>
</head>
<body>

    <h1>Daftar Member K-Pop</h1>

    <?php if (!empty($viewModel->successMessage)): ?>
        <p style="color: green;"><?php echo $viewModel->successMessage; ?></p>
    <?php endif; ?>

    <p><a href="index.php?page=member&action=create">Tambah Member Baru</a></p>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Nama Panggung</th>
                <th>Grup</th>
                <th>Kewarganegaraan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($viewModel->memberList as $member): ?>
                <tr>
                    <td><?php echo htmlspecialchars($member['id']); ?></td>
                    <td><?php echo htmlspecialchars($member['nama_lengkap']); ?></td>
                    <td><?php echo htmlspecialchars($member['nama_panggung']); ?></td>
                    <td><?php echo htmlspecialchars($member['nama_grup']); ?></td>
                    <td><?php echo htmlspecialchars($member['kewarganegaraan']); ?></td>
                    <td>
                        <a href="index.php?page=member&action=edit&id=<?php echo $member['id']; ?>">Edit</a> |
                        <a href="index.php?page=member&action=delete&id=<?php echo $member['id']; ?>" onclick="return confirm('Yakin ingin menghapus member ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>