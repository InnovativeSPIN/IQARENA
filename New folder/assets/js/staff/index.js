        const quizzes = [
            {
                id: "1",
                title: "Data Structures & Algorithms",
                subject: "Computer Science",
                instructor: "Dr. Sarah Johnson",
                duration: 90,
                totalQuestions: 50,
                enrolledStudents: 28,
                maxStudents: 30,
                status: "active"
            },
            {
                id: "2",
                title: "React Fundamentals",
                subject: "Web Development",
                instructor: "Prof. Mike Chen",
                duration: 60,
                totalQuestions: 30,
                enrolledStudents: 15,
                maxStudents: 25,
                status: "upcoming"
            },
            {
                id: "3",
                title: "Database Management",
                subject: "Computer Science",
                instructor: "Dr. Emily Davis",
                duration: 120,
                totalQuestions: 40,
                enrolledStudents: 22,
                maxStudents: 30,
                status: "completed"
            }
        ];

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

       
        document.getElementById('search-input').addEventListener('input', (e) => {
            renderQuizzes(e.target.value, document.getElementById('filter-status').value);
        });

        document.getElementById('filter-status').addEventListener('change', (e) => {
            renderQuizzes(document.getElementById('search-input').value, e.target.value);
        });

       
        function manageQuiz(quizId) {
            alert(`Managing quiz ID: ${quizId}`);
            
        }

        
        renderQuizzes();