<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../app/functions.php';

$logged = isset($_SESSION['user_id']);
$current = basename($_SERVER['PHP_SELF']);

function dashboard_link_for_role() {
  $role = $_SESSION['user_role'] ?? 'user';
  return $role === 'admin' ? 'admin/admin_dashboard.php' : 'users/users_dashboard.php';
}
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>UPN Events</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      .page-container { max-width: 1100px; margin-left:auto; margin-right:auto; }
    </style>
  </head>
  <body class="bg-white">

<header class="bg-indigo-200 border-b">
  <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8 relative">
    <!-- Logo -->
    <div class="flex lg:flex-1">
      <a href="index.php" class="-m-1.5 p-1.5 flex items-center gap-2">
        <img src="https://cdn-icons-png.flaticon.com/128/10691/10691802.png" class="h-8 w-auto" alt="Logo" />
        <span class="font-semibold text-gray-800">UPN Events</span>
      </a>
    </div>

    <!-- Menu utama -->
    <div class="hidden lg:flex gap-x-10 items-center">
      <!-- Dropdown Beranda -->
      <div class="relative">
        <button id="dropdownButton" class="flex items-center gap-1 text-sm font-semibold text-gray-900 hover:text-indigo-600">
          Beranda
          <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>

        <!-- Dropdown -->
        <div id="dropdownMenu" class="absolute left-0 mt-3 w-72 origin-top-right bg-white border border-gray-100 rounded-2xl shadow-lg hidden z-50">
          <div class="p-4 space-y-3">
            <a href="index.php" class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition">
              <div class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-lg">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                  <path d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                  <path d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                </svg>
              </div>
              <div>
                <p class="font-semibold text-gray-900">Home Page</p>
              </div>
            </a>

            <a href="articles.php" class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition">
              <div class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-lg">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                  <path d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672Z"/>
                  <path d="M12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75"/>
                </svg>
              </div>
              <div>
                <p class="font-semibold text-gray-900">All Events</p>
                <p class="text-gray-600 text-sm">All events at UPN</p>
              </div>
            </a>

            <a href="about.php" class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition">
              <div class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-lg">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                  <path d="M7.864 4.243A7.5 7.5 0 0 1 19.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 0 0 4.5 10.5a7.464 7.464 0 0 1-1.15 3.993"/>
                </svg>
              </div>
              <div>
                <p class="font-semibold text-gray-900">About</p>
                <p class="text-gray-600 text-sm">Get to know about this web</p>
              </div>
            </a>
          </div>
        </div>
      </div>

      <a href="articles.php" class="text-sm font-semibold text-gray-900 hover:text-indigo-600">Events</a>
      <a href="about.php" class="text-sm font-semibold text-gray-900 hover:text-indigo-600">About</a>
    </div>

    <!-- Login / Profile -->
    <div class="hidden lg:flex lg:flex-1 lg:justify-end items-center gap-4">
      <?php if (!$logged): ?>
        <!-- Not logged -->
        <a href="login.php" class="text-sm font-semibold text-gray-900 hover:text-indigo-600 <?= $current === 'login.php' ? 'underline' : '' ?>">Login</a>
      <?php else: ?>
        <!-- Logged in -->
        <div class="relative" id="profileDropdownRoot">
          <button id="profileBtn" aria-expanded="false" aria-haspopup="true"
                  class="flex items-center gap-3 px-3 py-1 rounded hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-200">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user_name'] ?? 'User') ?>&background=4f46e5&color=fff&rounded=true"
                 alt="avatar" class="w-8 h-8 rounded-full border border-gray-300 shadow-sm">
            <span class="text-sm font-medium text-gray-800"><?= e($_SESSION['user_name'] ?? 'User') ?></span>
            <svg id="caret" class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- Dropdown Profile -->
          <div id="profileDropdown"
     class="hidden absolute right-0 mt-2 w-40 bg-white text-gray-800 rounded-md shadow-lg ring-1 ring-black/10 z-50 overflow-hidden">

  <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
    <a href="<?= dashboard_link_for_role() ?>" class="block px-4 py-2 text-sm hover:bg-gray-100">Dashboard</a>
  <?php endif; ?>

  <form action="logout.php" method="POST" class="m-0">
    <button type="submit"
            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
      Logout
    </button>
  </form>
</div>

      <?php endif; ?>
    </div>
  </nav>
</header>

<script>
  // Dropdown Beranda
  const dropdownButton = document.getElementById('dropdownButton');
  const dropdownMenu = document.getElementById('dropdownMenu');

  dropdownButton.addEventListener('click', (e) => {
    e.stopPropagation();
    dropdownMenu.classList.toggle('hidden');
  });

  document.addEventListener('click', (e) => {
    if (!dropdownMenu.classList.contains('hidden') && !dropdownMenu.contains(e.target) && !dropdownButton.contains(e.target)) {
      dropdownMenu.classList.add('hidden');
    }
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') dropdownMenu.classList.add('hidden');
  });

  // Dropdown Profile
  const profileBtn = document.getElementById('profileBtn');
  const profileDropdown = document.getElementById('profileDropdown');

  if (profileBtn) {
    profileBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      profileDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
      if (!profileDropdown.classList.contains('hidden') && !profileDropdown.contains(e.target) && !profileBtn.contains(e.target)) {
        profileDropdown.classList.add('hidden');
      }
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') profileDropdown.classList.add('hidden');
    });
  }
</script>

</body>
</html>
