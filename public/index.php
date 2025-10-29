<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/functions.php';

include '_header.php';

// ambil 3 event terbaru
$events = [];
$sql = "SELECT id, title, description, image, created_at FROM events ORDER BY created_at DESC LIMIT 3";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $events[] = $row;
  }
}
?>

<!-- HERO: Carousel -->
<section class="mt-4 mb-12 relative z-0">
  <div class="relative max-w-6xl mx-auto">
    <div id="carousel" class="relative overflow-hidden rounded-lg shadow-lg">
      <!-- Slides -->
      <div class="carousel-slides relative h-[420px] md:h-[520px]">
        <div class="carousel-item absolute inset-0 transition-opacity duration-700 ease-in-out opacity-100" data-index="0">
          <img src="../uploads/upn.jpg" alt="Kampus 1" class="w-full h-full object-cover">
          <div class="absolute inset-0 bg-gradient-to-b from-black/40 to-black/30"></div>
          <div class="absolute inset-0 flex flex-col justify-center items-start md:items-center text-left md:text-center px-6 md:px-12 text-white">
            <h2 class="text-3xl md:text-5xl font-extrabold drop-shadow-lg leading-tight">Selamat Datang di Web Event UPN</h2>
            <p class="mt-4 text-sm md:text-lg text-white/90 max-w-3xl">Platform kegiatan-kegiatan di UPN Veteran Yogyakarta.</p>
            <div class="mt-6 flex flex-col sm:flex-row gap-3 z-50">
              <a href="articles.php" class="inline-block bg-indigo-600 text-white px-5 py-3 rounded-lg shadow hover:bg-indigo-700">Jelajahi Kegiatan</a>
              <a href="about.php" class="inline-block border border-white text-white px-5 py-3 rounded-lg hover:bg-white hover:text-indigo-600 transition">Tentang Kami</a>
            </div>
          </div>
        </div>

        <div class="carousel-item absolute inset-0 transition-opacity duration-700 ease-in-out opacity-0" data-index="1">
          <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=1600" alt="Kampus 2" class="w-full h-full object-cover">
          <div class="absolute inset-0 bg-gradient-to-b from-black/40 to-black/30"></div>
          <div class="absolute inset-0 flex flex-col justify-center items-start md:items-center text-left md:text-center px-6 md:px-12 text-white">
            <h2 class="text-3xl md:text-5xl font-extrabold drop-shadow-lg leading-tight">Kegiatan-Kegiatan Terbaru</h2>
            <p class="mt-4 text-sm md:text-lg text-white/90 max-w-3xl">Temukan kegiatan yang diselenggarakan oleh mahasiswa, dosen, dan kampus di UPN Veteran Yogyakarta.</p>
            <div class="mt-6 flex flex-col sm:flex-row gap-3">
              <a href="articles.php" class="inline-block bg-indigo-600 text-white px-5 py-3 rounded-lg shadow hover:bg-indigo-700">Lihat Kegiatan</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Controls -->
      <!-- tambahkan z-index tinggi biar tombol bisa diklik -->
      <button id="prevBtn" class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow focus:outline-none z-50" aria-label="Previous slide">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
      </button>
      <button id="nextBtn" class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow focus:outline-none z-50" aria-label="Next slide">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </button>

      <!-- Indicators -->
      <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-40">
        <button class="carousel-dot w-3 h-3 rounded-full bg-white/70" data-to="0" aria-label="Slide 1"></button>
        <button class="carousel-dot w-3 h-3 rounded-full bg-white/50" data-to="1" aria-label="Slide 2"></button>
      </div>
    </div>
  </div>
</section>

<!-- Event Terbaru -->
<main class="page-container px-4 py-10 relative z-10">
  <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Event Terbaru</h2>

  <?php if (count($events) > 0): ?>
    <div class="grid md:grid-cols-3 gap-6">
      <?php foreach ($events as $event): ?>
        <div class="bg-white rounded-xl border border-gray-100 shadow hover:shadow-md transition overflow-hidden">
          <?php 
    $imagePath = "/Pelatihan-Web/latihan2/uploads/" . htmlspecialchars($event['image']);
  ?>
  <img
    src="<?= $imagePath ?>"
    alt="<?= e($event['title']) ?>"
    class="w-full h-72 object-cover rounded-lg mb-6 shadow"
  >
          <div class="p-4">
            <h3 class="font-semibold text-lg text-gray-800 mb-2"><?= htmlspecialchars($event['title']) ?></h3>
            <p class="text-sm text-gray-600 line-clamp-3"><?= htmlspecialchars($event['description']) ?></p>
            <a href="singlepost.php?id=<?= $event['id'] ?>" class="text-indigo-600 text-sm font-semibold mt-3 inline-block">Baca Selengkapnya →</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="text-center text-gray-500">Belum ada event yang tersedia.</p>
  <?php endif; ?>
</main>

<?php include '_footer.php'; ?>

<!-- Tambahkan JS carousel -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const slides = document.querySelectorAll('.carousel-item');
  const dots = document.querySelectorAll('.carousel-dot');
  let current = 0;

  function showSlide(index) {
    slides.forEach((s, i) => {
      s.style.opacity = i === index ? '1' : '0';
      s.style.zIndex = i === index ? '1' : '0';
    });
    dots.forEach((d, i) => {
      d.classList.toggle('bg-white/90', i === index);
      d.classList.toggle('bg-white/50', i !== index);
    });
    current = index;
  }

  document.getElementById('prevBtn').addEventListener('click', () => {
    showSlide((current - 1 + slides.length) % slides.length);
  });

  document.getElementById('nextBtn').addEventListener('click', () => {
    showSlide((current + 1) % slides.length);
  });

  dots.forEach((d, i) => {
    d.addEventListener('click', () => showSlide(i));
  });
});
</script>
