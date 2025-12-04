<?php
require_once __DIR__ . '/../viewmodels/GrupViewModel.php';

$viewModel = new GrupViewModel();
$is_edit = false;

// Cek apakah ini mode Edit (ada ID di URL)
if (isset($_GET['id'])) {
    $id_grup = $_GET['id'];
    $is_edit = true;
    
    // Data Binding: Muat data grup yang akan diedit ke ViewModel
    if (!$viewModel->loadGrup($id_grup)) {
        // Jika data tidak ditemukan, kembali ke halaman list
        header("Location: index.php?page=grup");
        exit;
    }
}

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses form melalui ViewModel
    if ($viewModel->handleFormSubmission($_POST)) {
        // Jika sukses, redirect ke halaman list dengan pesan sukses
        header("Location: index.php?page=grup&message=" . urlencode($viewModel->successMessage));
        exit;
    }
    // Jika gagal, error message sudah tersimpan di $viewModel->errorMessage
}

// Tentukan judul form
$form_title = $is_edit ? "Edit Grup: " . htmlspecialchars($viewModel->nama_grup) : "Tambah Grup Baru";

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $form_title; ?></title>
</head>
<body>

    <h1><?php echo $form_title; ?></h1>
    <p><a href="index.php?page=grup">Kembali ke Daftar Grup</a></p>

    <?php if (!empty($viewModel->errorMessage)): ?>
        <p style="color: red;"><?php echo $viewModel->errorMessage; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <?php if ($is_edit): ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($viewModel->id); ?>">
        <?php endif; ?>

        <label for="nama_grup">Nama Grup:</label><br>
        <input type="text" id="nama_grup" name="nama_grup" required 
               value="<?php echo htmlspecialchars($viewModel->nama_grup ?? ''); ?>"><br><br>

        <label for="agensi">Agensi:</label><br>
        <input type="text" id="agensi" name="agensi" required 
               value="<?php echo htmlspecialchars($viewModel->agensi ?? ''); ?>"><br><br>
        
        <label for="tahun_debut">Tahun Debut:</label><br>
        <input type="number" id="tahun_debut" name="tahun_debut" required min="1990" max="<?php echo date('Y'); ?>" 
               value="<?php echo htmlspecialchars($viewModel->tahun_debut ?? ''); ?>"><br><br>

        <button type="submit"><?php echo $is_edit ? "Simpan Perubahan" : "Tambah Grup"; ?></button>
    </form>

</body>
</html>