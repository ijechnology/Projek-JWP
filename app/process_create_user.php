<?php
session_start();
require_once __DIR__ . '/../config/config.php'; // koneksi database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Cek apakah username sudah ada
    $check_username = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check_username->bind_param("s", $username);
    $check_username->execute();
    $result_username = $check_username->get_result();

    // Cek apakah email sudah ada
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $result_email = $check_email->get_result();

    if ($result_username->num_rows > 0) {
        $_SESSION['flash_error'] = "Username sudah digunakan!";
        header("Location: ../public/admin/kelola_user.php");
        exit;
    } elseif ($result_email->num_rows > 0) {
        $_SESSION['flash_error'] = "Email sudah digunakan!";
        header("Location: ../public/admin/kelola_user.php");
        exit;
    }

    // Insert data baru
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $role);

    if ($stmt->execute()) {
        $_SESSION['flash'] = "User berhasil ditambahkan!";
        header("Location: ../public/admin/admin_dashboard.php");
        exit;
    } else {
        $_SESSION['flash_error'] = "Terjadi kesalahan saat menambahkan user.";
        header("Location: ../public/admin/kelola_user.php");
        exit;
    }
}
?>
