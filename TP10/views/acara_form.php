<?php
require_once __DIR__ . '/../viewmodels/AcaraViewModel.php';

$viewModel = new AcaraViewModel();
$is_edit = false;

if (isset($_GET['id'])) {
    $id_acara = $_GET['id'];
    $is_edit = true;
    
    if (!$viewModel->loadAcara($id_acara)) {
        header("Location: index.php?page=acara");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($viewModel->handleFormSubmission($_POST)) {
        header("Location: index.php?page=acara&message=" . urlencode($viewModel->successMessage));
        exit;
    }
}

$form_title = $is_edit ? "Edit Acara: " . htmlspecialchars($viewModel->nama_acara) : "Tambah Acara Baru";

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
    <p><a href="index.php?page=acara">Kembali ke Daftar Acara</a></p>

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

        <label for="nama_acara">Nama Acara:</label><br>
        <input type="text" id="nama_acara" name="nama_acara" required 
               value="<?php echo htmlspecialchars($viewModel->nama_acara ?? ''); ?>"><br><br>

        <label for="jenis_acara">Jenis Acara (Opsional):</label><br>
        <input type="text" id="jenis_acara" name="jenis_acara" 
               value="<?php echo htmlspecialchars($viewModel->jenis_acara ?? ''); ?>"><br><br>

        <label for="lokasi">Lokasi (Opsional):</label><br>
        <input type="text" id="lokasi" name="lokasi" 
               value="<?php echo htmlspecialchars($viewModel->lokasi ?? ''); ?>"><br><br>
        
        <label for="tgl_acara">Tanggal Acara:</label><br>
        <input type="date" id="tgl_acara" name="tgl_acara" required 
               value="<?php echo htmlspecialchars($viewModel->tgl_acara ?? ''); ?>"><br><br>

        <button type="submit"><?php echo $is_edit ? "Simpan Perubahan" : "Tambah Acara"; ?></button>
    </form>

</body>
</html>