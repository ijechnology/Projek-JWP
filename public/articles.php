<?php
// public/events.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/functions.php';
require_once __DIR__ . '/../app/auth.php';

$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';

// pagination
$perPage = 6;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $perPage;

// build where + params for search
$whereSql = '';
$params = [];
$types = '';
if ($searchQuery !== '') {
  $whereSql = "WHERE (title LIKE ? OR description LIKE ?)";
  $like = '%' . $searchQuery . '%';
  $params[] = $like; $params[] = $like;
  $types .= 'ss';
}

// count total
$sqlCount = "SELECT COUNT(*) AS cnt FROM events $whereSql";
$stmt = mysqli_prepare($conn, $sqlCount);
if ($whereSql) mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
$totalItems = (int)($row['cnt'] ?? 0);
mysqli_stmt_close($stmt);

$totalPages = (int) max(1, ceil($totalItems / $perPage));

// fetch events with limit
$sql = "SELECT id, title, description, image, date, category, created_at
        FROM events
        $whereSql
        ORDER BY created_at DESC
        LIMIT ? OFFSET ?";

$stmt = mysqli_prepare($conn, $sql);

if ($whereSql) {
  mysqli_stmt_bind_param($stmt, $types . 'ii', ...array_merge($params, [$perPage, $offset]));
} else {
  mysqli_stmt_bind_param($stmt, 'ii', $perPage, $offset);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$events = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// helper pagination url
function build_page_url($p) {
  $params = $_GET;
  $params['page'] = $p;
  return htmlspecialchars($_SERVER['PHP_SELF'] . '?' . http_build_query($params));
}

// include header
include __DIR__ . '/_header.php';
?>

<main class="max-w-7xl mx-auto px-6 py-10">
  <!-- Header + Search -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-8">
    <h2 class="text-3xl font-bold text-gray-800">Event</h2>

    <form method="GET" action="articles.php" class="flex gap-2 w-full md:w-auto">
      <input 
        type="search" 
        name="q" 
        value="<?= htmlspecialchars($searchQuery) ?>" 
        placeholder="Cari event..." 
        class="flex-grow md:flex-none px-4 py-2 rounded-lg border border-gray-300 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 text-gray-700 placeholder-gray-400 transition"
      />
      <button class="bg-indigo-500 hover:bg-indigo-600 text-white px-5 py-2 rounded-lg shadow-md font-medium transition">
        Cari
      </button>
    </form>
  </div>

  <!-- Event cards -->
<!-- Event cards -->
<div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
  <?php if (count($events) > 0): ?>
    <?php foreach ($events as $e): ?>
      <a href="singlepost.php?id=<?= urlencode($e['id']) ?>" 
         class="bg-white rounded-xl shadow-md hover:shadow-lg transition border border-gray-100 overflow-hidden flex flex-col group">
        
        <?php 
$imagePath = !empty($e['image']) 
    ? "/Pelatihan-Web/latihan2/uploads/" . htmlspecialchars($e['image']) 
    : "/Pelatihan-Web/latihan2/public/assets/no-image.png"; // optional fallback image
?>
<img src="<?= $imagePath ?>" 
     alt="<?= htmlspecialchars($e['title']) ?>" 
     class="w-full h-48 object-cover group-hover:opacity-90 transition">


        <div class="p-5 flex flex-col flex-grow">
          <h3 class="text-lg font-semibold text-gray-800 group-hover:text-indigo-600 transition line-clamp-2">
            <?= e($e['title']) ?>
          </h3>

          <p class="text-sm text-gray-500 mt-1">
            <?= date('d M Y', strtotime($e['date'] ?? $e['created_at'])) ?>
          </p>

          <?php
            $desc = strip_tags($e['description'] ?? '');
            $excerpt = mb_substr($desc, 0, 160);
          ?>
          <p class="text-sm text-gray-600 mt-3 flex-grow line-clamp-3">
            <?= e($excerpt) ?><?= (mb_strlen($desc) > 160 ? '...' : '') ?>
          </p>

          <?php if (!empty($e['category'])): ?>
            <p class="mt-4 text-sm text-gray-500">
              <strong>Kategori:</strong> <?= e($e['category']) ?>
            </p>
          <?php endif; ?>
        </div>
      </a>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="col-span-full bg-white p-8 rounded-xl text-center shadow border border-gray-100">
      <h3 class="text-lg font-medium text-gray-800">Tidak ada event ditemukan</h3>
      <p class="mt-2 text-sm text-gray-600">Coba ubah kata kunci pencarian atau tunggu admin menambahkan event baru.</p>
    </div>
  <?php endif; ?>
</div>


  </div>

  <!-- Pagination -->
  <?php if ($totalPages > 1): ?>
    <div class="mt-10 flex items-center justify-between border-t border-gray-200 bg-white px-5 py-4 rounded-lg shadow-sm">
      <!-- Mobile -->
      <div class="flex flex-1 justify-between sm:hidden">
        <?php if ($page > 1): ?>
          <a href="<?= build_page_url($page - 1) ?>" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
        <?php else: ?>
          <span class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">Previous</span>
        <?php endif; ?>

        <?php if ($page < $totalPages): ?>
          <a href="<?= build_page_url($page + 1) ?>" class="ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
        <?php else: ?>
          <span class="ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">Next</span>
        <?php endif; ?>
      </div>

      <!-- Desktop -->
      <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <p class="text-sm text-gray-700">
          Menampilkan
          <span class="font-medium"><?= $offset + 1 ?></span>
          sampai
          <span class="font-medium"><?= min($offset + $perPage, $totalItems) ?></span>
          dari
          <span class="font-medium"><?= $totalItems ?></span>
          event
        </p>

        <nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md shadow-xs">
          <?php if ($page > 1): ?>
            <a href="<?= build_page_url($page - 1) ?>" class="inline-flex items-center rounded-l-md px-3 py-2 text-gray-500 bg-white hover:bg-gray-50 border border-gray-300" aria-label="Previous">‹</a>
          <?php else: ?>
            <span class="inline-flex items-center rounded-l-md px-3 py-2 text-gray-300 bg-white border border-gray-300">‹</span>
          <?php endif; ?>

          <?php for ($p = 1; $p <= $totalPages; $p++): ?>
            <?php if ($p == $page): ?>
              <a href="<?= build_page_url($p) ?>" class="inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white border border-indigo-600"><?= $p ?></a>
            <?php else: ?>
              <a href="<?= build_page_url($p) ?>" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 hover:bg-gray-50"><?= $p ?></a>
            <?php endif; ?>
          <?php endfor; ?>

          <?php if ($page < $totalPages): ?>
            <a href="<?= build_page_url($page + 1) ?>" class="inline-flex items-center rounded-r-md px-3 py-2 text-gray-500 bg-white hover:bg-gray-50 border border-gray-300" aria-label="Next">›</a>
          <?php else: ?>
            <span class="inline-flex items-center rounded-r-md px-3 py-2 text-gray-300 bg-white border border-gray-300">›</span>
          <?php endif; ?>
        </nav>
      </div>
    </div>
  <?php endif; ?>
</main>

<?php include __DIR__ . '/_footer.php'; ?>
