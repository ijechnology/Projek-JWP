<?php
require_once __DIR__ . '/../../app/auth.php';
require_admin();
require_once __DIR__ . '/../../config/config.php';

// CSRF
if (empty($_SESSION['csrf_add_event'])) {
  $_SESSION['csrf_add_event'] = bin2hex(random_bytes(24));
}
$csrf_token = $_SESSION['csrf_add_event'];

include __DIR__ . '/_header_admin.php';
include __DIR__ . '/_sidebar_admin.php';
?>

<main class="flex-1 bg-gray-50 min-h-screen p-8">
  <div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-900 mb-4">Tambah Event</h1>

    <form method="POST" action="/Pelatihan-Web/latihan2/app/process_create_event.php" enctype="multipart/form-data"
          class="bg-white p-6 rounded-lg shadow border border-gray-200">
      <input type="hidden" name="csrf" value="<?= $csrf_token ?>">

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Judul</label>
        <input type="text" name="title" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea name="description" rows="4" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Tanggal</label>
        <input type="date" name="date" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Kategori</label>
        <input type="text" name="category" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
      </div>

      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700">Gambar (opsional)</label>
        <input type="file" name="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-600">
      </div>

      <div class="flex justify-end gap-3">
        <a href="kelola_event.php" class="px-4 py-2 text-gray-700 border rounded-md">Batal</a>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
          Simpan
        </button>
      </div>
    </form>
  </div>
</main>

<?php include __DIR__ . '/_footer_admin.php'; ?>
