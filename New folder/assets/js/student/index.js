        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;

        function setTheme(theme) {
            body.setAttribute('data-theme', theme);
            themeToggle.innerHTML = theme === 'dark' ? '<i data-lucide="sun"></i>' : '<i data-lucide="moon"></i>';
            localStorage.setItem('theme', theme);
            lucide.createIcons();
        }

        // Load saved theme or default to light
        const savedTheme = localStorage.getItem('theme') || 'light';
        setTheme(savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = body.getAttribute('data-theme') || 'light';
            setTheme(currentTheme === 'light' ? 'dark' : 'light');
        });

        lucide.createIcons();

        function renderQuizzes(searchTerm = '', filterStatus = 'all') {
            const quizGrid = document.getElementById('quiz-grid');
            quizGrid.innerHTML = '';
            const filteredQuizzes = quizzes.filter(quiz => {
                const matchesSearch = quiz.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
                                    quiz.subject.toLowerCase().includes(searchTerm.toLowerCase());
                const matchesFilter = filterStatus === 'all' || quiz.status === filterStatus;
                return matchesSearch && matchesFilter;
            });

            if (filteredQuizzes.length === 0) {
                quizGrid.innerHTML = `
                    <div class="no-results">
                        <i data-lucide="book-open"></i>
                        <h3>No quizzes found</h3>
                        <p>Try adjusting your search or filter criteria.</p>
                    </div>
                `;
                lucide.createIcons();
                return;
            }

            filteredQuizzes.forEach(quiz => {
                const quizCard = document.createElement('div');
                quizCard.className = 'quiz-card';
                quizCard.innerHTML = `
                    <h3>${quiz.title}</h3>
                    <p>${quiz.subject}</p>
                    <p>Instructor: ${quiz.instructor}</p>
                    <div class="quiz-details">
                        <span><i data-lucide="clock"></i>${quiz.duration} min</span>
                        <span><i data-lucide="book-open"></i>${quiz.totalQuestions} Qs</span>
                        <span><i data-lucide="users"></i>${quiz.enrolledStudents}/${quiz.maxStudents}</span>
                    </div>
                    <div class="quiz-actions">
                        <button onclick="manageQuiz('${quiz.id}')">Manage</button>
                    </div>
                `;
                quizGrid.appendChild(quizCard);
            });
            lucide.createIcons();
        }

        function manageQuiz(quizId) {
            alert(`Managing quiz ID: ${quizId}`);
        }

        renderQuizzes();