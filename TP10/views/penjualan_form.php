<?php
require_once __DIR__ . '/../viewmodels/PenjualanViewModel.php';

$viewModel = new PenjualanViewModel();
$is_edit = false;

if (isset($_GET['id'])) {
    $id_penjualan = $_GET['id'];
    $is_edit = true;
    
    if (!$viewModel->loadPenjualan($id_penjualan)) {
        header("Location: index.php?page=penjualan");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($viewModel->handleFormSubmission($_POST)) {
        header("Location: index.php?page=penjualan&message=" . urlencode($viewModel->successMessage));
        exit;
    }
}

$form_title = $is_edit ? "Edit Penjualan ID: " . htmlspecialchars($viewModel->id) : "Tambah Data Penjualan Baru";

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
    <p><a href="index.php?page=penjualan">Kembali ke Daftar Penjualan</a></p>

    <?php if (!empty($viewModel->errorMessage)): ?>
        <p style="color: red;"><?php echo $viewModel->errorMessage; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <?php if ($is_edit): ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($viewModel->id); ?>">
        <?php endif; ?>

        <label for="id_album">Album (Foreign Key):</label><br>
        <select id="id_album" name="id_album" required>
            <option value="">-- Pilih Album --</option>
            <?php foreach ($viewModel->albumOptions as $album): ?>
                <option value="<?php echo htmlspecialchars($album['id']); ?>" 
                    <?php echo (isset($viewModel->id_album) && $viewModel->id_album == $album['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($album['judul_album']); ?> (<?php echo htmlspecialchars($album['nama_grup']); ?>)
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="jumlah_terjual">Jumlah Terjual:</label><br>
        <input type="number" id="jumlah_terjual" name="jumlah_terjual" required min="1"
               value="<?php echo htmlspecialchars($viewModel->jumlah_terjual ?? ''); ?>"><br><br>

        <label for="negara">Negara (Opsional):</label><br>
        <input type="text" id="negara" name="negara" 
               value="<?php echo htmlspecialchars($viewModel->negara ?? ''); ?>"><br><br>

        <label for="sumber_chart">Sumber Chart (Opsional):</label><br>
        <input type="text" id="sumber_chart" name="sumber_chart" 
               value="<?php echo htmlspecialchars($viewModel->sumber_chart ?? ''); ?>"><br><br>
        
        <button type="submit"><?php echo $is_edit ? "Simpan Perubahan" : "Tambah Data Penjualan"; ?></button>
    </form>

</body>
</html>