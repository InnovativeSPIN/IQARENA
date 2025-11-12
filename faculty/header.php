
  <header class="flex justify-between items-center bg-white shadow p-4 px-10">
    <div>
      <img src="http://localhost/CODING-QUIZ-APP/assets/img/logo/logo.png" alt="" style="width: 120px;height:70px;">
    </div>
  <?php
    // Fetch department name using department_id from session
    $dept_name = '';
    if (isset($_SESSION['department_id'])) {
      $dept_id = $_SESSION['department_id'];
      include_once '../resource/conn.php';
      $dept_query = mysqli_query($conn, "SELECT full_name FROM departments WHERE id = '" . intval($dept_id) . "'");
      if ($dept_query && mysqli_num_rows($dept_query) > 0) {
       $dept_row = mysqli_fetch_assoc($dept_query);
       $dept_name = $dept_row['full_name'];
      }
    }
  ?>
  <h2 class="text-2xl font-bold text-gray-800 tracking-tight">
    Welcome Back, <?php echo $_SESSION['name']; ?> <span class="name-text"></span>
    <?php if ($dept_name) { echo "<span class='text-orange-500 text-lg font-semibold ml-2'>($dept_name)</span>"; } ?>
  </h2>
    <div class="flex items-center space-x-4">
      <img src="../assets/images/avatar.pAnd the status Computer started started in. 400 and started. ng" alt="Profile" class="w-10 h-10 rounded-full border">
      <div>
        <p class="font-semibold text-gray-700"><span class="main-name"x`></span></p>
        <p class="text-sm text-gray-500"><span class="role-text"></span></p>
      </div>
      <a href="../resource/logout.php">
        <button id="logout-btn" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg">Logout</button>
      </a>
    </div>
  </header>
