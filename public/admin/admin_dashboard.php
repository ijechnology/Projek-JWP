<?php
include __DIR__ . '../../../app/auth.php';
require_admin();
include __DIR__ . '/_header_admin.php';
include __DIR__ . '/_sidebar_admin.php';

// pastikan session aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- main content dashboard -->
<main class="flex-1 p-10">
  <div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-2">Admin Dashboard</h1>
    <p class="text-gray-600 mb-6">
      Selamat datang, <?= e(current_user_name()) ?>!
    </p>

    <!-- notifikasi -->
    <?php if (isset($_SESSION['flash'])): ?>
      <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-2 rounded-md">
        <?= htmlspecialchars($_SESSION['flash']) ?>
      </div>
      <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash_error'])): ?>
      <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-2 rounded-md">
        <?= htmlspecialchars($_SESSION['flash_error']) ?>
      </div>
      <?php unset($_SESSION['flash_error']); ?>
    <?php endif; ?>
    <!-- end of notif -->

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white rounded-lg p-6 shadow">
        <h3 class="font-semibold">Kelola User</h3>
        <p class="text-sm text-gray-500 mt-2">Tambah user</p>
        <a href="kelola_user.php" class="text-indigo-600 mt-3 inline-block">Buka manajemen user →</a>
      </div>

      <div class="bg-white rounded-lg p-6 shadow">
        <h3 class="font-semibold">Kelola Kegiatan</h3>
        <p class="text-sm text-gray-500 mt-2">Tambah / edit / hapus kegiatan</p>
        <a href="kelola_event.php" class="text-indigo-600 mt-3 inline-block">Buka manajemen kegiatan →</a>
      </div>
    </div>
  </div>
</main>
<!-- end of main -->

<?php include __DIR__ . '/_footer_admin.php'; ?>
