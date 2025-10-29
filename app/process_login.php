<?php
require_once __DIR__ . '/../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// hanya terima POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../public/login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    $_SESSION['flash_error'] = 'Email dan password wajib diisi.';
    header('Location: ../public/login.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['flash_error'] = 'Format email tidak valid.';
    header('Location: ../public/login.php');
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT id, username, password, role FROM users WHERE email = ? LIMIT 1");
if (!$stmt) {
    $_SESSION['flash_error'] = 'Terjadi kesalahan server.';
    header('Location: ../public/login.php');
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) === 0) {
    mysqli_stmt_close($stmt);
    $_SESSION['flash_error'] = 'Email atau password salah.';
    header('Location: ../public/login.php');
    exit;
}

mysqli_stmt_bind_result($stmt, $id, $name, $password_hash, $role);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!password_verify($password, $password_hash)) {
    $_SESSION['flash_error'] = 'Email atau password salah.';
    header('Location: ../public/login.php');
    exit;
}

session_regenerate_id(true);
$_SESSION['user_id'] = (int)$id;
$_SESSION['user_name'] = $name;
$_SESSION['user_email'] = $email;
$_SESSION['user_role'] = $role;
$_SESSION['last_login'] = date('Y-m-d H:i:s');

$_SESSION['flash_success'] = 'Berhasil login.';

header('Location: ../public/index.php');
exit;
