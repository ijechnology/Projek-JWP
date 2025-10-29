<?php
// public/logout.php

// Mulai session jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    // Hapus semua data session
    $_SESSION = [];
    session_unset();
    session_destroy();

    // Hapus cookie session (jika ada)
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }

    // Mulai ulang session buat set flash
    session_start();
    $_SESSION['flash'] = 'Berhasil logout. Silakan login kembali.';
} catch (Exception $e) {
    session_start();
    $_SESSION['flash_error'] = 'Terjadi kesalahan saat logout.';
}

// Redirect ke halaman login
header('Location: /Pelatihan-Web/latihan2/public/login.php');
exit;
