<header>
  <div class="container header-content">
 <div>
  <img src="http://localhost/CODING-QUIZ-APP/assets/img/logo/logo.png" alt="" width="180px" height="120px">
 </div>
    <div class="text-center flex flex-col justify-center items-center uppercase">
      <h1>
        
        Theni Melapettai Hindu Nadargal Uravinmurai 
      </h1>
      <h1 class="">
        NADAR SARASWATHI COLLEGE OF ENGINEERING & TECHNOLOGY

      </h1>
  <h2>Welcome back, <?php echo $_SESSION['name'] ?></h2>
    </div>
    <div class="profile-section">
      <a href="../profile.php" class="profile-link">
        <div class="profile">
          <img src="../assets/images/Infinity castle desktop wallpaper.jpg" alt="Profile">
        </div>
      </a>
   <a href="../resource/logout.php">
        <button id="logout-btn" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg">Logout</button>
      </a>
    </div>
  </div>
</header>

<style>

    body{

         font-family: 'Times New Roman', Times, serif!important ;
    }


header h1 {
  font-size: 1.8rem;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 0.5rem; 
  color: #000000ff; 
}

.student-icon {
  width: 28px;
  height: 28px;
  color: #f97316;
}

.profile-section {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.profile {
  width: 45px;
  height: 45px;
  border-radius: 50%;
  overflow: hidden;
  border: 2px solid #f97316; 
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.profile img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.profile:hover {
  transform: scale(1.08);
  box-shadow: 0 0 12px rgba(249, 115, 22, 0.7);
}

.logout-link {
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f97316;
  padding: 0.5rem;
  border-radius: 50%;
  transition: background 0.3s ease, transform 0.2s ease;
}

.logout-link i {
  color: white;
  width: 20px;
  height: 20px;
}

.logout-link:hover {
  background: #ea580c; 
  transform: rotate(-10deg) scale(1.05);
}

</style>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
    







