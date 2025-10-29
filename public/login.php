<?php
// Pastikan session hanya dimulai sekali
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil flash message kalau ada
$flash_success = $_SESSION['flash_success'] ?? null;
$flash_error = $_SESSION['flash_error'] ?? null;
unset($_SESSION['flash_success'], $_SESSION['flash_error']);

// Setelah itu baru include header
include __DIR__ . '/_header.php';
?>

<div class="max-w-2xl mx-auto px-4 py-10">
  <?php if ($flash_success): ?>
    <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
      <?= htmlspecialchars($flash_success) ?>
    </div>
  <?php elseif ($flash_error): ?>
    <div class="mb-4 bg-red-100 text-red-800 px-4 py-2 rounded">
      <?= htmlspecialchars($flash_error) ?>
    </div>
  <?php endif; ?>

  <h2 class="text-2xl font-semibold mb-2">Login</h2>
  <p class="text-sm text-gray-600 mb-6">Masuk untuk mengelola artikel atau mengirim komentar.</p>

  <form action="../app/process_login.php" method="POST" class="bg-white p-6 rounded-lg shadow space-y-4">
    <div>
      <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
      <input id="email" name="email" type="email" required class="mt-1 block w-full px-3 py-2 border rounded" />
    </div>

    <div>
      <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
      <input id="password" name="password" type="password" required class="mt-1 block w-full px-3 py-2 border rounded" />
    </div>

    <div class="flex items-center gap-3">
      <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Login</button>
    </div>
  </form>
</div>

<?php include __DIR__ . '/_footer.php'; ?>
