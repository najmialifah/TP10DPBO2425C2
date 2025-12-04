<?php
require_once __DIR__ . '/../viewmodels/MemberViewModel.php';

$viewModel = new MemberViewModel();
$is_edit = false;

if (isset($_GET['id'])) {
    $id_member = $_GET['id'];
    $is_edit = true;
    
    if (!$viewModel->loadMember($id_member)) {
        header("Location: index.php?page=member");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($viewModel->handleFormSubmission($_POST)) {
        header("Location: index.php?page=member&message=" . urlencode($viewModel->successMessage));
        exit;
    }
}

$form_title = $is_edit ? "Edit Member: " . htmlspecialchars($viewModel->nama_lengkap) : "Tambah Member Baru";

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $form_title; ?></title>
</head>
<body>

    <h1><?php echo $form_title; ?></h1>
    <p><a href="index.php?page=member">Kembali ke Daftar Member</a></p>

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

        <label for="nama_lengkap">Nama Lengkap:</label><br>
        <input type="text" id="nama_lengkap" name="nama_lengkap" required 
               value="<?php echo htmlspecialchars($viewModel->nama_lengkap ?? ''); ?>"><br><br>

        <label for="nama_panggung">Nama Panggung (Opsional):</label><br>
        <input type="text" id="nama_panggung" name="nama_panggung" 
               value="<?php echo htmlspecialchars($viewModel->nama_panggung ?? ''); ?>"><br><br>
        
        <label for="kewarganegaraan">Kewarganegaraan (Opsional):</label><br>
        <input type="text" id="kewarganegaraan" name="kewarganegaraan" 
               value="<?php echo htmlspecialchars($viewModel->kewarganegaraan ?? ''); ?>"><br><br>

        <button type="submit"><?php echo $is_edit ? "Simpan Perubahan" : "Tambah Member"; ?></button>
    </form>

</body>
</html>