<script>
    lucide.createIcons();
    let name=document.querySelector('.name-text');
    let main_name=document.querySelector('.main-name');
    let role=document.querySelector('.role-text');
    
 window.addEventListener('DOMContentLoaded', async () => {
            try {
                const res = await fetch('<?php echo $api ?>helpers/student_session.php', 
                { credentials: 'include' });
                const data = await res.json(); 

                if (!data.logged_in) {
                    
                    window.location.href = './';
                }
            } catch (err) {
                console.error('Session check failed', err);
            }
        });


    // handle logout
    async function handleLogout() {
      document.getElementById("logout-btn")?.addEventListener("click", async () => {
        try {32
          const res = await fetch('<?php echo $api; ?>helpers/logout.php', {
            method: 'POST',
            credentials: 'include',
            headers: {
              'Content-Type': 'application/json'
            }
          });
          const data = await res.json();
          if (data.success) {
            alert("Logout successful!");
            window.location.href = "./";
          } else {
            alert("Logout failed!");
          }
        } catch (err) {
          alert("Logout error: " + err.message);
        }
      });
    }


    window.addEventListener('DOMContentLoaded', () => {
      checkSession();
      handleLogout();

    });
  </script>