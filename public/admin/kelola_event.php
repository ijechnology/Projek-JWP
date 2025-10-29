<?php
require_once __DIR__ . '/../../app/auth.php';
require_admin();
require_once __DIR__ . '/../../config/config.php';

// CSRF token
if (empty($_SESSION['csrf_event_mgmt'])) {
    $_SESSION['csrf_event_mgmt'] = bin2hex(random_bytes(24));
}
$csrf_token = $_SESSION['csrf_event_mgmt'];

// Flash message
$flash = $_SESSION['flash'] ?? $_SESSION['flash_error'] ?? null;
unset($_SESSION['flash'], $_SESSION['flash_error']);

// Ambil semua event
$sql = "SELECT e.id, e.title, e.category, e.date, e.image, e.created_at, u.username AS created_by 
        FROM events e
        LEFT JOIN users u ON e.created_by = u.id
        ORDER BY e.date DESC";
$result = $conn->query($sql);

include __DIR__ . '/_header_admin.php';
include __DIR__ . '/_sidebar_admin.php';
?>

<main class="flex-1 bg-gray-50 min-h-screen p-8">
  <div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900">Kelola Event</h1>
        <p class="text-sm text-gray-500 mt-1">Tambah, ubah, atau hapus event yang terdaftar.</p>
      </div>
      <a href="/Pelatihan-Web/latihan2/public/admin/add_event.php"
         class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md shadow">
        Tambah Event
      </a>
    </div>

    <!-- Flash -->
    <?php if ($flash): ?>
      <div class="mb-6 rounded-md p-4 <?= isset($_SESSION['flash']) ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-green-50 border border-green-200 text-green-700' ?>">
        <?= htmlspecialchars($flash) ?>
      </div>
    <?php endif; ?>

    <!-- Table -->
    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-100">
            <?php if ($result->num_rows > 0): ?>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 text-sm text-gray-700"><?= $row['id'] ?></td>
                  <td class="px-6 py-4 text-sm font-medium text-gray-900"><?= htmlspecialchars($row['title']) ?></td>
                  <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($row['category']) ?></td>
                  <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($row['date']) ?></td>
                  <td class="px-6 py-4">
                    <?php if (!empty($row['image'])): ?>
                      <img src="/Pelatihan-Web/latihan2/uploads/<?= htmlspecialchars($row['image']) ?>" alt="event-img" class="h-12 w-12 object-cover rounded">
                    <?php else: ?>
                      <span class="text-gray-400 text-sm">Tidak ada</span>
                    <?php endif; ?>
                  </td>
                  <td class="px-6 py-4 text-sm">
                    <div class="flex gap-3">
                      <a href="/Pelatihan-Web/latihan2/public/admin/edit_event.php?id=<?= $row['id'] ?>"
                         class="px-3 py-1.5 bg-yellow-100 text-yellow-800 rounded-md text-sm hover:bg-yellow-200">
                        Edit
                      </a>
                      <form method="post" action="/Pelatihan-Web/latihan2/app/process_delete_event.php" onsubmit="return confirm('Yakin ingin menghapus event ini?');">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="csrf" value="<?= $csrf_token ?>">
                        <button type="submit"
                          class="px-3 py-1.5 bg-red-600 text-white text-sm rounded-md hover:bg-red-700">
                          Hapus
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada event.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<?php include __DIR__ . '/_footer_admin.php'; ?>
