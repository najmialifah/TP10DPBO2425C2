<?php
require_once __DIR__ . '/../viewmodels/AlbumViewModel.php';

$viewModel = new AlbumViewModel();
$is_edit = false;

if (isset($_GET['id'])) {
    $id_album = $_GET['id'];
    $is_edit = true;
    
    // Data Binding: Muat data album yang akan diedit ke ViewModel
    if (!$viewModel->loadAlbum($id_album)) {
        header("Location: index.php?page=album");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses form melalui ViewModel
    if ($viewModel->handleFormSubmission($_POST)) {
        // Jika sukses, redirect ke halaman list dengan pesan sukses
        header("Location: index.php?page=album&message=" . urlencode($viewModel->successMessage));
        exit;
    }
    // Jika gagal, error message sudah tersimpan di $viewModel->errorMessage
}

// Tentukan judul form
$form_title = $is_edit ? "Edit Album: " . htmlspecialchars($viewModel->judul_album) : "Tambah Album Baru";

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $form_title; ?></title>
</head>
<body>

    <?php include __DIR__ . '/template/header.php'; ?>

    <h1><?php echo $form_title; ?></h1>
    <p><a href="index.php?page=album">Kembali ke Daftar Album</a></p>

    <?php if (!empty($viewModel->errorMessage)): ?>
        <p style="color: red;"><?php echo $viewModel->errorMessage; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <?php if ($is_edit): ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($viewModel->id); ?>">
        <?php endif; ?>

        <label for="id_grup">Grup (Foreign Key):</label><br>
        <select id="id_grup" name="id_grup" required>
            <option value="">-- Pilih Grup --</option>
            <?php foreach ($viewModel->grupOptions as $grup): ?>
                <option value="<?php echo htmlspecialchars($grup['id']); ?>" 
                    <?php echo (isset($viewModel->id_grup) && $viewModel->id_grup == $grup['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($grup['nama_grup']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="judul_album">Judul Album:</label><br>
        <input type="text" id="judul_album" name="judul_album" required 
               value="<?php echo htmlspecialchars($viewModel->judul_album ?? ''); ?>"><br><br>

        <label for="jenis_album">Jenis Album:</label><br>
        <input type="text" id="jenis_album" name="jenis_album" 
               value="<?php echo htmlspecialchars($viewModel->jenis_album ?? ''); ?>"><br><br>
        
        <label for="tgl_rilis">Tanggal Rilis:</label><br>
        <input type="date" id="tgl_rilis" name="tgl_rilis" required 
               value="<?php echo htmlspecialchars($viewModel->tgl_rilis ?? ''); ?>"><br><br>

        <button type="submit"><?php echo $is_edit ? "Simpan Perubahan" : "Tambah Album"; ?></button>
    </form>

</body>
</html>