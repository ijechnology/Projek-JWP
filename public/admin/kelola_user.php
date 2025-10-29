<?php
require_once __DIR__ . '/../../app/auth.php';
require_admin();
require_once __DIR__ . '/../../config/config.php';

// CSRF token
if (empty($_SESSION['csrf_add_user'])) {
    $_SESSION['csrf_add_user'] = bin2hex(random_bytes(24));
}
$csrf_token = $_SESSION['csrf_add_user'];

// ambil semua user
$users = [];
$stmt = $conn->prepare("SELECT id, username, email, role, created_at FROM users ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

include __DIR__ . '/_header_admin.php';
include __DIR__ . '/_sidebar_admin.php';
?>

<main class="flex-1 bg-gray-50 min-h-screen p-8">
  <div class="max-w-5xl mx-auto bg-white shadow-sm rounded-lg border border-gray-200 relative overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-5 border-b border-gray-100">
      <h1 class="text-2xl font-bold text-gray-900">Kelola User</h1>
      <p class="mt-1 text-sm text-gray-600">Tambah atau hapus pengguna dari sistem.</p>
    </div>

    <!-- Flash Message -->
    <?php if (isset($_SESSION['flash']) || isset($_SESSION['flash_error'])): ?>
      <?php
        $is_success = isset($_SESSION['flash']);
        $message = htmlspecialchars($_SESSION['flash'] ?? $_SESSION['flash_error']);
        unset($_SESSION['flash'], $_SESSION['flash_error']);
      ?>
      <div id="flash-message"
           class="mx-6 mt-6 p-4 rounded-md border transition-opacity duration-500 opacity-100
                  <?= $is_success ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-700' ?>">
        <?= $message ?>
      </div>
      <script>
        setTimeout(() => {
          const flash = document.getElementById('flash-message');
          if (flash) {
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 500);
          }
        }, 3000);
      </script>
    <?php endif; ?>

    <!-- Form Tambah User -->
    <form action="/Pelatihan-Web/latihan2/app/process_create_user.php" method="post" class="px-6 py-6 space-y-6 border-b border-gray-100">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf_token) ?>">

      <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4">
        <label for="username" class="w-36 text-sm font-medium text-gray-700">Username</label>
        <input id="username" name="username" type="text" required
          class="flex-1 rounded-md border border-gray-300 py-2 px-3 text-gray-900
                 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
      </div>

      <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4">
        <label for="email" class="w-36 text-sm font-medium text-gray-700">Email</label>
        <input id="email" name="email" type="email" placeholder="nama@gmail.com" required
          class="flex-1 rounded-md border border-gray-300 py-2 px-3 text-gray-900
                 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
      </div>

      <div class="flex flex-col sm:flex-row sm:items-start sm:space-x-4">
        <label for="password" class="w-36 text-sm font-medium text-gray-700">Password</label>
        <div class="flex-1">
          <input id="password" name="password" type="password" minlength="6" required
            class="w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900
                   focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
          <p class="mt-2 text-xs text-gray-500">Minimal 6 karakter.</p>
        </div>
      </div>

      <div class="flex flex-col sm:flex-row sm:items-start sm:space-x-4">
        <label for="role" class="w-36 text-sm font-medium text-gray-700">Role</label>
        <div class="flex-1">
          <select id="role" name="role" required
            class="w-48 rounded-md border border-gray-300 bg-white py-2 px-3 text-sm
                   focus:ring-indigo-500 focus:border-indigo-500">
            <option value="admin">Admin</option>
            <option value="user">User</option>
          </select>
        </div>
      </div>

      <div class="flex justify-end gap-3 pt-6">
        <a href="/Pelatihan-Web/latihan2/public/admin/admin_dashboard.php"
          class="px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition">
          Kembali
        </a>
        <button type="submit"
          class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition">
          Tambah User
        </button>
      </div>
    </form>

    <!-- Daftar User -->
    <div class="px-6 py-6">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Daftar User</h2>
      <?php if (empty($users)): ?>
        <p class="text-gray-500 text-sm">Belum ada user.</p>
      <?php else: ?>
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm border border-gray-200 rounded-md">
            <thead class="bg-gray-100 border-b border-gray-200 text-gray-700">
              <tr>
                <th class="px-4 py-2 text-left font-medium">ID</th>
                <th class="px-4 py-2 text-left font-medium">Username</th>
                <th class="px-4 py-2 text-left font-medium">Email</th>
                <th class="px-4 py-2 text-left font-medium">Role</th>
                <th class="px-4 py-2 text-left font-medium">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <?php foreach ($users as $user): ?>
                <tr class="hover:bg-gray-50">
                  <td class="px-4 py-2"><?= htmlspecialchars($user['id']) ?></td>
                  <td class="px-4 py-2"><?= htmlspecialchars($user['username']) ?></td>
                  <td class="px-4 py-2"><?= htmlspecialchars($user['email']) ?></td>
                  <td class="px-4 py-2"><?= htmlspecialchars($user['role']) ?></td>
                  <td class="px-4 py-2">
                    <form action="/Pelatihan-Web/latihan2/app/process_delete_user.php" method="post" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                      <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                      <button type="submit"
                        class="px-3 py-1 rounded-md bg-red-600 hover:bg-red-700 text-white text-xs font-medium">
                        Hapus
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php include __DIR__ . '/_footer_admin.php'; ?>
