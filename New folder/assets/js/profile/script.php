<script>
      
        const profileName = document.getElementById('profileName');
        const profileRole = document.getElementById('profileRole');
        const profileRoll = document.getElementById('profileRoll');
        const profileDept = document.getElementById('profileDept');
        const profileYear = document.getElementById('profileYear');
        const profileEmail = document.getElementById('profileEmail');
        const profileImage = document.getElementById('profileImage');
        const problemsSolved = document.getElementById('problemsSolved');
        const testsTaken = document.getElementById('testsTaken');
        const avgScore = document.getElementById('avgScore');
        const rank = document.getElementById('rank');
        const logoutBtn = document.getElementById('logoutBtn');

        // Modal elements
        const editProfileBtn = document.getElementById('editProfileBtn');
        const editProfileModal = document.getElementById('editProfileModal');
        const closeEditModal = document.getElementById('closeEditModal');
        const cancelEdit = document.getElementById('cancelEdit');
        const profileForm = document.getElementById('profileForm');
        const editName = document.getElementById('editName');
        const editEmail = document.getElementById('editEmail');
        const editDept = document.getElementById('editDept');
        const editYear = document.getElementById('editYear');

        // Password modal elements
        const changePasswordBtn = document.getElementById('changePasswordBtn');
        const changePasswordModal = document.getElementById('changePasswordModal');
        const closePasswordModal = document.getElementById('closePasswordModal');
        const cancelPassword = document.getElementById('cancelPassword');
        const passwordForm = document.getElementById('passwordForm');
        const currentPassword = document.getElementById('currentPassword');
        const newPassword = document.getElementById('newPassword');
        const confirmPassword = document.getElementById('confirmPassword');

        // Photo modal elements
        const changePhotoBtn = document.getElementById('changePhotoBtn');
        const profilePhotoModal = document.getElementById('profilePhotoModal');
        const closePhotoModal = document.getElementById('closePhotoModal');
        const cancelPhoto = document.getElementById('cancelPhoto');
        const savePhoto = document.getElementById('savePhoto');
        const photoInput = document.getElementById('photoInput');
        const previewImage = document.getElementById('previewImage');

        // Toast
        const successToast = document.getElementById('successToast');
        const toastMessage = document.getElementById('toastMessage');

        // Initialize profile data
        profileName.textContent = userData.name;
        profileRole.textContent = userData.role;
        profileRoll.textContent = userData.roll;
        profileDept.textContent = userData.dept;
        profileYear.textContent = userData.year;
        profileEmail.textContent = userData.email;
        profileImage.src = userData.profileImage;
        problemsSolved.textContent = userData.stats.problemsSolved;
        testsTaken.textContent = userData.stats.testsTaken;
        avgScore.textContent = userData.stats.avgScore;
        rank.textContent = userData.stats.rank;

        // Function to show toast
        function showToast(message) {
            toastMessage.textContent = message;
            successToast.classList.remove('translate-x-full');
            setTimeout(() => {
                successToast.classList.add('translate-x-full');
            }, 3000);
        }

        // Edit Profile functionality
        editProfileBtn.addEventListener('click', () => {
            editName.value = userData.name;
            editEmail.value = userData.email;
            editDept.value = userData.dept;
            editYear.value = userData.year;
            editProfileModal.classList.remove('hidden');
        });

        // Close modals
        [closeEditModal, cancelEdit].forEach(btn => {
            btn.addEventListener('click', () => {
                editProfileModal.classList.add('hidden');
            });
        });

        [closePasswordModal, cancelPassword].forEach(btn => {
            btn.addEventListener('click', () => {
                changePasswordModal.classList.add('hidden');
                passwordForm.reset();
            });
        });

        [closePhotoModal, cancelPhoto].forEach(btn => {
            btn.addEventListener('click', () => {
                profilePhotoModal.classList.add('hidden');
                selectedPhotoSrc = '';
            });
        });

        // Save profile changes
        profileForm.addEventListener('submit', (e) => {
            e.preventDefault();
            userData.year = editYear.value;
            profileYear.textContent = userData.year;
            editProfileModal.classList.add('hidden');
            showToast('Profile updated successfully!');
        });

        // Password change functionality
        changePasswordBtn.addEventListener('click', () => {
            changePasswordModal.classList.remove('hidden');
        });

        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-target');
                const targetInput = document.getElementById(targetId);
                const icon = btn.querySelector('i');
                
                if (targetInput.type === 'password') {
                    targetInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    targetInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Password form submission
        passwordForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            if (newPassword.value !== confirmPassword.value) {
                alert('New passwords do not match!');
                return;
            }
            
            if (newPassword.value.length < 8) {
                alert('Password must be at least 8 characters long!');
                return;
            }
            
            changePasswordModal.classList.add('hidden');
            passwordForm.reset();
            showToast('Password changed successfully!');
        });

        // Profile photo functionality
        let selectedPhotoSrc = '';
        changePhotoBtn.addEventListener('click', () => {
            previewImage.src = profileImage.src;
            selectedPhotoSrc = profileImage.src;
            profilePhotoModal.classList.remove('hidden');
        });

        // Handle file input
        photoInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = (e) => {
                    selectedPhotoSrc = e.target.result;
                    previewImage.src = selectedPhotoSrc;
                };
                reader.readAsDataURL(file);
            }
        });

        // Save photo
        savePhoto.addEventListener('click', () => {
            if (selectedPhotoSrc) {
                profileImage.src = selectedPhotoSrc;
                userData.profileImage = selectedPhotoSrc;
                profilePhotoModal.classList.add('hidden');
                showToast('Profile photo updated successfully!');
            }
        });

        // Click on profile image to change photo
        profileImage.addEventListener('click', () => {
            changePhotoBtn.click();
        });

        // Logout functionality
        logoutBtn.addEventListener('click', () => {
            // Add your logout logic here
            alert('Logout functionality would be implemented here');
        });

        // Close modals when clicking outside
        [editProfileModal, changePasswordModal, profilePhotoModal].forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    if (modal === changePasswordModal) {
                        passwordForm.reset();
                    }
                    if (modal === profilePhotoModal) {
                        selectedPhotoSrc = '';
                    }
                }
            });
        });
    </script>