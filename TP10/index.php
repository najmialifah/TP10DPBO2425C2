<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Kode HTML Navigasi Global
echo '<nav style="margin-bottom: 20px;">
    <a href="index.php?page=grup">Daftar Grup</a> |
    <a href="index.php?page=member">Daftar Member</a> |
    <a href="index.php?page=album">Daftar Album</a> |
    <a href="index.php?page=acara">Daftar Acara</a> |
    <a href="index.php?page=penjualan">Daftar Penjualan</a>
</nav>
<hr>'; 

// Memuat semua ViewModel yang diperlukan
require_once __DIR__ . '/viewmodels/GrupViewModel.php';
require_once __DIR__ . '/viewmodels/MemberViewModel.php';
require_once __DIR__ . '/viewmodels/AlbumViewModel.php';
require_once __DIR__ . '/viewmodels/AcaraViewModel.php';
require_once __DIR__ . '/viewmodels/PenjualanViewModel.php'; // AKTIF

$page = $_GET['page'] ?? 'grup'; 
$action = $_GET['action'] ?? 'list';

$message = $_GET['message'] ?? '';

// Logika Routing
switch ($page) {
    case 'grup':
        $viewModel = new GrupViewModel();
        if (!empty($message)) { $viewModel->successMessage = urldecode($message); }
        switch ($action) {
            case 'list': include 'views/grup_list.php'; break;
            case 'create': case 'edit': include 'views/grup_form.php'; break;
            case 'delete':
                if (isset($_GET['id'])) {
                    if ($viewModel->handleDelete($_GET['id'])) { header("Location: index.php?page=grup&message=" . urlencode($viewModel->successMessage)); } 
                    else { header("Location: index.php?page=grup&message=" . urlencode("Gagal menghapus data grup.")); }
                } else { header("Location: index.php?page=grup"); }
                exit;
        }
        break;

    case 'member':
        $viewModel = new MemberViewModel();
        if (!empty($message)) { $viewModel->successMessage = urldecode($message); }
        switch ($action) {
            case 'list': include 'views/member_list.php'; break;
            case 'create': case 'edit': include 'views/member_form.php'; break;
            case 'delete':
                if (isset($_GET['id'])) {
                    if ($viewModel->handleDelete($_GET['id'])) { header("Location: index.php?page=member&message=" . urlencode($viewModel->successMessage)); } 
                    else { header("Location: index.php?page=member&message=" . urlencode("Gagal menghapus data member.")); }
                } else { header("Location: index.php?page=member"); }
                exit;
        }
        break;

    case 'album':
        $viewModel = new AlbumViewModel();
        if (!empty($message)) { $viewModel->successMessage = urldecode($message); }
        switch ($action) {
            case 'list': include 'views/album_list.php'; break;
            case 'create': case 'edit': include 'views/album_form.php'; break;
            case 'delete':
                if (isset($_GET['id'])) {
                    if ($viewModel->handleDelete($_GET['id'])) { header("Location: index.php?page=album&message=" . urlencode($viewModel->successMessage)); } 
                    else { header("Location: index.php?page=album&message=" . urlencode("Gagal menghapus data album.")); }
                } else { header("Location: index.php?page=album"); }
                exit;
        }
        break;

    case 'acara':
        $viewModel = new AcaraViewModel();
        if (!empty($message)) { $viewModel->successMessage = urldecode($message); }
        switch ($action) {
            case 'list': include 'views/acara_list.php'; break;
            case 'create': case 'edit': include 'views/acara_form.php'; break;
            case 'delete':
                if (isset($_GET['id'])) {
                    if ($viewModel->handleDelete($_GET['id'])) { header("Location: index.php?page=acara&message=" . urlencode($viewModel->successMessage)); } 
                    else { header("Location: index.php?page=acara&message=" . urlencode("Gagal menghapus data acara.")); }
                } else { header("Location: index.php?page=acara"); }
                exit;
        }
        break;
        
    case 'penjualan': // ROUTING FINAL UNTUK PENJUALAN
        $viewModel = new PenjualanViewModel();
        if (!empty($message)) { $viewModel->successMessage = urldecode($message); }
        switch ($action) {
            case 'list': include 'views/penjualan_list.php'; break;
            case 'create': case 'edit': include 'views/penjualan_form.php'; break;
            case 'delete':
                if (isset($_GET['id'])) {
                    if ($viewModel->handleDelete($_GET['id'])) { header("Location: index.php?page=penjualan&message=" . urlencode($viewModel->successMessage)); } 
                    else { header("Location: index.php?page=penjualan&message=" . urlencode("Gagal menghapus data penjualan.")); }
                } else { header("Location: index.php?page=penjualan"); }
                exit;
        }
        break;

    default:
        echo "Selamat datang di K-Pop Data App (MVVM).";
        break;
}

?>