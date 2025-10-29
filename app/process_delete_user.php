<?php
session_start();
require_once __DIR__ . '/../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['flash'] = "User berhasil dihapus!";
    } else {
        $_SESSION['flash_error'] = "Gagal menghapus user!";
    }
}

header("Location: ../public/admin/kelola_user.php");
exit;
?>
