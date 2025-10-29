<?php include __DIR__ . '/_header.php'; ?>

<section class="max-w-6xl mx-auto px-4 py-16">
  <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Tentang UPN Events</h2>
  <div class="grid md:grid-cols-3 gap-8">
    
    <!-- Card 1 -->
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
   
      <h3 class="text-lg font-semibold text-center text-gray-800">Visi</h3>
      <p class="text-sm text-gray-600 mt-3 text-center">Menjadi pusat informasi kegiatan kampus yang akurat, interaktif, dan mudah diakses oleh seluruh civitas akademika.</p>
    </div>

    <!-- Card 2 -->
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
      
      <h3 class="text-lg font-semibold text-center text-gray-800">Misi</h3>
      <p class="text-sm text-gray-600 mt-3 text-center">Menghubungkan mahasiswa, dosen, dan pihak kampus melalui publikasi event, pengumuman, serta dokumentasi kegiatan kampus.</p>
    </div>

    <!-- Card 3 -->
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
      
      <h3 class="text-lg font-semibold text-center text-gray-800">Tujuan</h3>
      <p class="text-sm text-gray-600 mt-3 text-center">Mendukung promosi event antar fakultas dan memperkuat semangat kolaborasi di lingkungan UPN Veteran Yogyakarta.</p>
    </div>

  </div>
</section>

<section class="bg-white py-12">
  <div class="max-w-5xl mx-auto px-4">
    <h2 class="text-2xl font-semibold text-gray-800 text-center">Kontributor</h2>
    <p class="mt-2 text-gray-600 text-center max-w-2xl mx-auto">
      Dikelola oleh tim mahasiswa dan staf kampus yang berkomitmen menyajikan informasi kegiatan kampus secara rutin dan akurat.
    </p>

    <div class="mt-8 bg-gray-50 p-6 rounded-lg shadow-sm flex flex-col sm:flex-row items-center sm:items-start sm:space-x-6 text-center sm:text-left">
      <img src="../public/uploads/profile.jpg" alt="Profile" class="w-20 h-20 rounded-full object-cover shadow mb-4 sm:mb-0">
      <div>
        <h4 class="text-lg font-medium text-gray-800">Nurul Izzah</h4>
        <p class="text-sm text-gray-500">Developer & Ops</p>
        <a href="mailto:izzaanrl@gmail.com" class="mt-1 inline-block text-sm text-indigo-600 hover:underline">
          izzaanrl@gmail.com
        </a>
      </div>
    </div>
  </div>
</section>


<section class="py-12 bg-indigo-50">
  <div class="max-w-5xl mx-auto px-4 text-center">
    <h2 class="text-2xl font-semibold text-gray-800">Capaian Singkat</h2>
    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="bg-white p-4 rounded-lg shadow">
        <div class="text-3xl font-bold text-indigo-700">200+</div>
        <div class="text-sm text-gray-600 mt-1">Event Terdaftar</div>
      </div>
      <div class="bg-white p-4 rounded-lg shadow">
        <div class="text-3xl font-bold text-indigo-700">50+</div>
        <div class="text-sm text-gray-600 mt-1">Penyelenggara</div>
      </div>
      <div class="bg-white p-4 rounded-lg shadow">
        <div class="text-3xl font-bold text-indigo-700">10</div>
        <div class="text-sm text-gray-600 mt-1">Fakultas Terlibat</div>
      </div>
      <div class="bg-white p-4 rounded-lg shadow">
        <div class="text-3xl font-bold text-indigo-700">8k+</div>
        <div class="text-sm text-gray-600 mt-1">Pengunjung / bulan</div>
      </div>
    </div>
  </div>
</section>

<section class="bg-white py-12">
  <div class="max-w-3xl mx-auto px-4 text-center">
    <h2 class="text-2xl font-semibold text-gray-800">Ingin Publikasikan Acara?</h2>
    <p class="mt-2 text-gray-600">Kirimkan detail acara kampus Anda agar bisa ditampilkan di UPN Events.</p>
    <div class="mt-6 flex justify-center">
      <a href="mailto:izzaanrl@gmail.com" class="inline-block px-6 py-3 rounded-lg bg-indigo-600 text-white font-medium shadow hover:bg-indigo-700">Kirim Event</a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/_footer.php'; ?>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('section').forEach((s) => {
      s.classList.add('transition-opacity', 'duration-700', 'opacity-100');
    });
  });
</script>
