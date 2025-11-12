 <script>
        window.addEventListener('DOMContentLoaded', async () => {
            try {
                const res = await fetch('<?php echo $api; ?>helpers/sessionStatus.php', {
                    credentials: 'include'
                });
                const data = await res.json();

                if (data.logged_in) {
                    switch (data.role) {
                        case 'student':
                            window.location.href = './student/';
                            break;
                        case 'faculty':
                            window.location.href = './staff/';
                            break;
                        case 'hod':
                            window.location.href = './hod/panel.html';
                            break;
                        case 'vice_principal':
                            window.location.href = './vp/review.html';
                            break;
                        case 'principal':
                            window.location.href = './principal/report.html';
                            break;
                        default:
                            alert("Unknown role.");
                    }
                }
            } catch (err) {
                console.error("Session check failed", err);
            }
        });
    </script>