<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// pastikan user sudah login
if (!isset($_SESSION['user_role'])) {
  header('Location: /pert6-web-blog/public/login.php');
  exit;
}

// cek role, hanya admin yang boleh masuk
if ($_SESSION['user_role'] !== 'admin') {
  header('Location: /pert6-web-blog/public/index.php');
  exit;
}

// variabel dasar
$base = '/Pelatihan-Web/latihan2/public';
$avatar_url = "https://cdn-icons-png.flaticon.com/128/3177/3177440.png";

$user_name = $_SESSION['user_name'] ?? 'Admin Kampus';
$user_role = $_SESSION['user_role'] ?? 'admin';
?>

<aside class="w-64 bg-white border-r hidden md:block">
  <div class="p-6">
    <a href="<?= $base ?>/admin/admin_dashboard.php" class="text-lg font-semibold text-indigo-600 flex items-center gap-2">
      Dashboard
    </a>
  </div>

  <nav class="px-4 py-6 space-y-2 text-gray-700">
    <a href="<?= $base ?>/admin/admin_dashboard.php"
       class="flex items-center gap-3 px-3 py-2 rounded hover:bg-indigo-50 <?= basename($_SERVER['PHP_SELF']) === 'admin_dashboard.php' ? 'bg-indigo-50 font-semibold' : '' ?>">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8v8" />
      </svg>
      Dashboard
    </a>

    <a href="<?= $base ?>/index.php"
   class="flex items-center gap-3 px-3 py-2 rounded hover:bg-indigo-50 <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'bg-indigo-50 font-semibold' : '' ?>">
  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
      d="M4 10l8-6 8 6v10a2 2 0 01-2 2h-4v-6H10v6H6a2 2 0 01-2-2V10z" />
  </svg>
  Beranda Utama
</a>


    <a href="<?= $base ?>/admin/kelola_user.php"
       class="flex items-center gap-3 px-3 py-2 rounded hover:bg-indigo-50 <?= basename($_SERVER['PHP_SELF']) === 'kelola_user.php' ? 'bg-indigo-50 font-semibold' : '' ?>">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11c1.657 0 3-1.343 3-3S17.657 5 16 5s-3 1.343-3 3 1.343 3 3 3zM8 11c1.657 0 3-1.343 3-3S9.657 5 8 5 5 6.343 5 8s1.343 3 3 3zm8 2c-1.49 0-2.774.576-3.707 1.515A5.967 5.967 0 008 13c-1.49 0-2.774.576-3.707 1.515A5.978 5.978 0 004 18h16c0-1.657-.895-3.128-2.293-4.028A5.96 5.96 0 0016 13z" />
      </svg>
      Manajemen User
    </a>

    <a href="<?= $base ?>/admin/kelola_event.php"
       class="flex items-center gap-3 px-3 py-2 rounded hover:bg-indigo-50 <?= basename($_SERVER['PHP_SELF']) === 'kelola_event.php' ? 'bg-indigo-50 font-semibold' : '' ?>">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-8-4h8M4 6h16v12H4z" />
      </svg>
      Kelola Kegiatan
    </a>

    <a href="<?= $base ?>/logout.php" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-indigo-50 text-red-600">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
      </svg>
      Logout
    </a>
  </nav>

  <!-- Profile Logged in -->
  <div class="p-4 border-t text-sm text-gray-600">
    <div class="flex items-center gap-3">
      <img src="<?= $avatar_url ?>" alt="avatar" class="w-8 h-8 rounded-full object-cover border">
      <div>
        <div class="text-xs text-gray-500 mb-1">Signed in as</div>
        <div class="font-medium"><?= e($user_name) ?></div>
        <div class="text-xs text-gray-500 mt-1">Role: <?= e($user_role) ?></div>
      </div>
    </div>
  </div>
</aside>
