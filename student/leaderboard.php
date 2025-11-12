<?php
include '../resource/conn.php'; // Database connection

// Fetch top 3 unique students by their highest score from completed tests
$query = "SELECT u.name, MAX(st.score) AS score FROM student_tests st JOIN users u ON st.student_id = u.id WHERE st.status = 'completed' GROUP BY st.student_id ORDER BY score DESC LIMIT 3";
$result = mysqli_query($conn, $query);
if (!$result) {
    echo '<div style="color:red;">Error fetching leaderboard. Please check the database table and connection.</div>';
    exit;
}
$top_students = [];
while ($row = mysqli_fetch_assoc($result)) {
    $top_students[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <style>

        :root {
            --color-primary: #FF9800;
            --color-primary-hover: #F57C00;
            --color-secondary: #FFA726;
            --color-accent: #FFD54F;
            --color-white: #FFFFFF;
            --color-dark: #F5F5F5;
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: var(--color-white);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            overflow-x: hidden;
            position: relative;
        }


        .leaderboard-container {
            text-align: center;
            padding: 2rem 1rem;
            max-width: 900px;
            width: 100%;
            position: relative;
            z-index: 1;
            background: var(--color-white);
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(255, 152, 0, 0.15);
            margin-top: 2rem;
        }


        h2 {
            color: var(--color-primary);
            font-size: 2.5rem;
            margin-bottom: 2rem;
            font-weight: bold;
            text-shadow: 0 2px 8px rgba(255, 152, 0, 0.15);
            animation: fadeIn 1s ease-in;
            letter-spacing: 1px;
        }

        .leaderboard {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 2rem;
            margin-top: 200px;
            position: relative;
        }

        .podium {
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.5s ease;
        }

        .podium:hover {
            transform: translateY(-10px);
        }

        .podium.first {
            order: 2;
            margin-top: -50px;
        }

        .podium.second {
            order: 1;
        }

        .podium.third {
            order: 3;
        }


        .podium-card {
            background: var(--color-accent);
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(255, 152, 0, 0.18);
            width: 200px;
            text-align: center;
            border: 3px solid;
            animation: slideUp 0.8s ease-out;
            color: var(--color-primary);
        }

        .podium.first .podium-card {
            border-color: var(--color-primary);
            background: linear-gradient(180deg, var(--color-secondary), var(--color-accent));
            color: var(--color-primary-hover);
            
        }

        .podium.second .podium-card {
            border-color: var(--color-primary-hover);
            background: var(--color-accent);
        }

        .podium.third .podium-card {
            border-color: var(--color-secondary);
            background: var(--color-accent);
        }

        .podium-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid var(--color-white);
            margin-bottom: 1rem;
            object-fit: cover;
        }

        .podium-card h3 {
            margin: 0.5rem 0;
            font-size: 1.5rem;
        }


        .podium-card .score {
            font-size: 2rem;
            font-weight: bold;
            margin: 0.5rem 0;
            color: var(--color-primary-hover);
        }

        .podium-card .name {
            font-size: 1.2rem;
            margin: 0;
        }

      
        .crown {
            width: 50px;
            height: 50px;
            margin-bottom: 1rem;
            fill: var(--color-primary);
            animation: bounce 2s infinite;
        }

        @keyframes slideUp {
            from { transform: translateY(100px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }


        @media (max-width: 768px) {
            .leaderboard {
                flex-direction: column;
                align-items: center;
            }

            .podium.first {
                margin-top: 0;
            }

            .podium-card {
                width: 80%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="leaderboard-container">
        <h2 style="margin-top:0;">Top 3 Students Leaderboard</h2>
        <div class="leaderboard">
            <?php if (!empty($top_students)): ?>
                <?php if (isset($top_students[0])): ?>
                    <div class="podium first">
                        <svg class="crown" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M5 16L3 5l5.5 3L12 2l3.5 6L21 5l-2 11H5zm2.5-6.5L8 8l2.5 2.5L13 8l.5 1.5L12 12l2.5 2.5L16 12l.5 3H7.5l-.5-3 2.5-2.5L7.5 9.5z"/>
                        </svg>
                        <div class="podium-card">
                            <!-- <img src="https://via.placeholder.com/100" alt="Profile"> -->
                            <h3>1st Place</h3>
                            <div class="name"><?php echo htmlspecialchars($top_students[0]['name']); ?></div>
                            <div class="score"><?php echo $top_students[0]['score']; ?></div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (isset($top_students[1])): ?>
                    <div class="podium second">
                        <div class="podium-card">
                            <!-- <img src="https://via.placeholder.com/100" alt="Profile"> -->
                            <h3>2nd Place</h3>
                            <div class="name"><?php echo htmlspecialchars($top_students[1]['name']); ?></div>
                            <div class="score"><?php echo $top_students[1]['score']; ?></div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (isset($top_students[2])): ?>
                    <div class="podium third">
                        <div class="podium-card">
                            <!-- <img src="https://via.placeholder.com/100" alt="Profile"> -->
                            <h3>3rd Place</h3>
                            <div class="name"><?php echo htmlspecialchars($top_students[2]['name']); ?></div>
                            <div class="score"><?php echo $top_students[2]['score']; ?></div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p style="color: var(--color-white);">No data available for the leaderboard.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>