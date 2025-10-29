<?php
// public/singlepost.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/functions.php';
require_once __DIR__ . '/../app/auth.php';

// ambil id dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
  header('Location: articles.php');
  exit;
}

// ambil event dari database
$stmt = $conn->prepare("
  SELECT id, title, description, image, date, category, created_at
  FROM events
  WHERE id = ?
  LIMIT 1
");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$event = $res->fetch_assoc();
$stmt->close();

// kalau event tidak ditemukan
if (!$event) {
  include __DIR__ . '/_header.php';
  echo '<div class="max-w-3xl mx-auto py-10 text-center">
          <h2 class="text-2xl font-semibold text-gray-700">Event tidak ditemukan</h2>
          <a href="articles.php" class="text-indigo-600 hover:underline">← Kembali ke daftar event</a>
        </div>';
  include __DIR__ . '/_footer.php';
  exit;
}

include __DIR__ . '/_header.php';
?>

<article class="max-w-4xl mx-auto py-10">
  <!-- Judul -->
  <h1 class="text-3xl font-bold text-gray-800 mb-3"><?= e($event['title']) ?></h1>

  <!-- Info tanggal -->
  <div class="text-sm text-gray-500 mb-6">
    <?= date('d M Y', strtotime($event['date'] ?? $event['created_at'])) ?>
    <?php if (!empty($event['category'])): ?>
      • <span class="text-gray-600"><?= e($event['category']) ?></span>
    <?php endif; ?>
  </div>

  <!-- Gambar utama -->
  <?php if (!empty($event['image'])): ?>
  <?php 
    $imagePath = "/Pelatihan-Web/latihan2/uploads/" . htmlspecialchars($event['image']);
  ?>
  <img
    src="<?= $imagePath ?>"
    alt="<?= e($event['title']) ?>"
    class="w-full h-72 object-cover rounded-lg mb-6 shadow"
  >
<?php else: ?>
  <img
    src="/Pelatihan-Web/latihan2/public/assets/no-image.png"
    alt="Tidak ada gambar"
    class="w-full h-72 object-cover rounded-lg mb-6 shadow opacity-70"
  >
<?php endif; ?>


  <!-- Isi deskripsi -->
  <div class="prose prose-indigo max-w-none">
    <?= nl2br(e($event['description'])) ?>
  </div>

  <!-- Tombol kembali -->
  <div class="mt-10">
    <a href="articles.php" class="text-indigo-600 hover:underline">← Kembali ke daftar event</a>
  </div>
</article>

<?php include __DIR__ . '/_footer.php'; ?>
