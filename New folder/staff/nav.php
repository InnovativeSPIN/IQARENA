<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>


<section id="nav-section" class="mb-10">
  <nav class="bg-white shadow-lg rounded-2xl px-4 py-3 flex items-center justify-between md:justify-center flex-wrap md:flex-nowrap">
    
    <button id="menu-toggle" class="md:hidden text-gray-700 focus:outline-none">
      <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>

    <div id="nav-links" class="hidden md:flex gap-6 text-gray-700 font-medium text-lg flex-wrap justify-center w-full md:w-auto">
      
      <a href="./" <?php if ($current_page == "index.php") echo 'aria-current="page"'; ?>
         class="relative px-3 py-2 rounded-xl transition-all duration-300 
                hover:text-orange-600 hover:bg-orange-50
                aria-[current=page]:bg-orange-400 aria-[current=page]:text-white 
                aria-[current=page]:shadow-md">
         Dashboard
      </a>

      <a href="create-test.php" <?php if ($current_page == "create-test.php") echo 'aria-current="page"'; ?>
         class="relative px-3 py-2 rounded-xl transition-all duration-300 
                hover:text-orange-600 hover:bg-orange-50
                aria-[current=page]:bg-orange-400 aria-[current=page]:text-white 
                aria-[current=page]:shadow-md">
         Create Test
      </a>

      <a href="recent-test.php" <?php if ($current_page == "recent-test.php") echo 'aria-current="page"'; ?>
         class="relative px-3 py-2 rounded-xl transition-all duration-300 
                hover:text-orange-600 hover:bg-orange-50
                aria-[current=page]:bg-orange-400 aria-[current=page]:text-white 
                aria-[current=page]:shadow-md">
         Recent Test
      </a>

      <a href="topic.php" <?php if ($current_page == "topic.php") echo 'aria-current="page"'; ?>
         class="relative px-3 py-2 rounded-xl transition-all duration-300 
                hover:text-orange-600 hover:bg-orange-50
                aria-[current=page]:bg-orange-400 aria-[current=page]:text-white 
                aria-[current=page]:shadow-md">
         Topics
      </a>

      <a href="upload-questions.php" <?php if ($current_page == "upload-questions.php") echo 'aria-current="page"'; ?>
         class="relative px-3 py-2 rounded-xl transition-all duration-300 
                hover:text-orange-600 hover:bg-orange-50
                aria-[current=page]:bg-orange-400 aria-[current=page]:text-white 
                aria-[current=page]:shadow-md">
         Upload Questions
      </a>

      <a href="leaderboard.php" <?php if ($current_page == "leaderboard.php") echo 'aria-current="page"'; ?>
         class="relative px-3 py-2 rounded-xl transition-all duration-300 
                hover:text-orange-600 hover:bg-orange-50
                aria-[current=page]:bg-orange-400 aria-[current=page]:text-white 
                aria-[current=page]:shadow-md">
         Leaderboard
      </a>

      <a href="reports.php" <?php if ($current_page == "reports.php") echo 'aria-current="page"'; ?>
         class="relative px-3 py-2 rounded-xl transition-all duration-300 
                hover:text-orange-600 hover:bg-orange-50
                aria-[current=page]:bg-orange-400 aria-[current=page]:text-white 
                aria-[current=page]:shadow-md">
         Reports
      </a>
    </div>
  </nav>
</section>

<script>
  const menuToggle = document.getElementById('menu-toggle');
  const navLinks = document.getElementById('nav-links');

  menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('hidden');
    navLinks.classList.toggle('flex');
    navLinks.classList.toggle('flex-col');
    navLinks.classList.toggle('gap-4');
    navLinks.classList.toggle('mt-4');
  });
</script>
