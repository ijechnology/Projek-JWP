<?php
require_once __DIR__ . '/auth.php';
require_admin();
require_once __DIR__ . '/../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf']) || $_POST['csrf'] !== ($_SESSION['csrf_add_event'] ?? '')) {
        $_SESSION['flash_error'] = 'Token tidak valid.';
        header("Location: /Pelatihan-Web/latihan2/public/admin/add_event.php");
        exit;
    }

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $date = $_POST['date'];
    $category = trim($_POST['category']);

    $image_name = null;
    if (!empty($_FILES['image']['name'])) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_name = uniqid() . '_' . basename($_FILES['image']['name']);
        $target_dir = __DIR__ . '/../uploads/';
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        move_uploaded_file($image_tmp, $target_dir . $image_name);
    }

    $stmt = $conn->prepare("
        INSERT INTO events (title, description, date, category, image, created_at)
        VALUES (?, ?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param("sssss", $title, $description, $date, $category, $image_name);

    if ($stmt->execute()) {
        $_SESSION['flash'] = 'Event berhasil ditambahkan!';
    } else {
        $_SESSION['flash_error'] = 'Gagal menambahkan event.';
    }

    header("Location: /Pelatihan-Web/latihan2/public/admin/kelola_event.php");
    exit;
}
