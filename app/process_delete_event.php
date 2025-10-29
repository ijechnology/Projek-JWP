<?php
require_once __DIR__ . '/auth.php';
require_admin();
require_once __DIR__ . '/../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf']) || $_POST['csrf'] !== ($_SESSION['csrf_event_mgmt'] ?? '')) {
        $_SESSION['flash_error'] = 'Token tidak valid.';
        header("Location: /Pelatihan-Web/latihan2/public/admin/kelola_event.php");
        exit;
    }

    $id = $_POST['id'];
    $target_dir = __DIR__ . '/../uploads/';

    // hapus gambar fisik
    $old = $conn->query("SELECT image FROM events WHERE id=$id")->fetch_assoc();
    if (!empty($old['image'])) @unlink($target_dir . $old['image']);

    $stmt = $conn->prepare("DELETE FROM events WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['flash'] = 'Event berhasil dihapus.';
    } else {
        $_SESSION['flash_error'] = 'Gagal menghapus event.';
    }

    header("Location: /Pelatihan-Web/latihan2/public/admin/kelola_event.php");
    exit;
}
