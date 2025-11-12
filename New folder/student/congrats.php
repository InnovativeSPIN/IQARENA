<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quiz Completed!</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
:root {
    --color-primary: #F97316;
    --color-primary-hover: #EA580C;
    --color-background: #FFFFFF;
    --color-surface: #F5F5F5;
    --text: #1A120B;
    --text-secondary: #D97706;
    --card-border: #E5E7EB;
    --shadow: rgba(0, 0, 0, 0.1);
    --gradient-primary: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
}

body {
    background: var(--color-background);
    color: var(--text);
    font-family: 'Arial', sans-serif;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow-x: hidden;
    position: relative;
}

.full-page-animation {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    border: none;
}

.center-card {
    text-align: center;
    z-index: 10;
    animation: fadeIn 1s ease-out;
}

.progress-circle {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 1rem auto;
}

.progress-circle svg {
    width: 100%;
    height: 100%;
    transform: rotate(-90deg);
}

.progress-circle .background-circle {
    fill: none;
    stroke: var(--color-surface);
    stroke-width: 8;
}

.progress-circle .progress-ring {
    fill: none;
    stroke: var(--color-primary);
    stroke-width: 8;
    stroke-dasharray: 339.29;
    stroke-dashoffset: 339.29;
    transition: stroke-dashoffset 1.5s ease-out, stroke 0.3s;
}

.progress-circle .percentage {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--color-primary);
}

.btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    margin: 0.5rem;
}

.btn-primary {
    background: var(--gradient-primary);
    color: #FFFFFF;
}

.btn-primary:hover {
    background: var(--color-primary-hover);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
}

.btn-secondary {
    background: #E5E7EB;
    color: var(--text);
    border: 1px solid var(--card-border);
}

.btn-secondary:hover {
    background: #D1D5DB;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
</head>
<body>

<iframe src="https://lottie.host/embed/df5d03f5-657c-4fb6-a16e-94c35207613c/oKtw2PfFjZ.lottie" class="full-page-animation"></iframe>

<div class="center-card">
    <p class="subtitle text-2xl font-bold mb-4" id="quiz-message">Congratulations!</p>

    <div class="progress-circle">
        <svg>
            <circle class="background-circle" cx="60" cy="60" r="54"></circle>
            <circle class="progress-ring" cx="60" cy="60" r="54" id="progress-ring"></circle>
        </svg>
        <div class="percentage" id="quiz-percentage">0%</div>
    </div>

    <p class="text-lg font-semibold mb-2" id="quiz-score">Score: 0 / 0</p>
    <p class="text-md text-gray-500 mb-4" id="quiz-student-name">Student</p>

    <div class="flex justify-center gap-4">
        <a href="leaderboard.php" class="btn btn-primary">Leaderboard</a>
        <a href="index.php" class="btn btn-secondary">Dashboard</a>
    </div>
</div>

<script>
// Read score and total from URL params
const params = new URLSearchParams(window.location.search);
const score = parseFloat(params.get('score') || 0);
const total = parseFloat(params.get('total') || 0);
const percentage = total > 0 ? (score / total) * 100 : 0;

// Update frontend
document.getElementById('quiz-percentage').innerText = Math.round(percentage) + '%';
document.getElementById('quiz-score').innerText = `Score: ${score} / ${total}`;
document.getElementById('quiz-message').innerText = (percentage >= 50) ? "Congratulations!" : "Better luck next time!";
document.getElementById('quiz-student-name').innerText = "Student"; // Optional: can be dynamic

// Update progress ring
const progressRing = document.getElementById('progress-ring');
const offset = 339.29 - (339.29 * percentage / 100);
progressRing.style.strokeDashoffset = offset;
progressRing.style.stroke = (percentage >= 50) ? '#F97316' : '#EF4444';
</script>

</body>
</html>
