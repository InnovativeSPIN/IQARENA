<?php
include("../resource/conn.php");
include("../resource/session.php");

include("../backend/faculty/Createtopic.php");


$topicStmt = $conn->prepare("
    SELECT t.topic_id, t.title AS topic_title, t.description AS topic_desc,
           s.sub_topic_id, s.title AS sub_title, s.description AS sub_desc
    FROM topics t
    LEFT JOIN sub_topics s ON s.topic_id = t.topic_id
    WHERE t.by_admin = 1 OR t.added_by = ?
    ORDER BY t.created_at DESC, s.sub_topic_id ASC
");
$topicStmt->bind_param("i", $_SESSION['id']);
$topicStmt->execute();
$result = $topicStmt->get_result();

$topics = [];
while ($row = $result->fetch_assoc()) {
    $tid = $row['topic_id'];
    if (!isset($topics[$tid])) {
        $topics[$tid] = [
            'title' => $row['topic_title'],
            'description' => $row['topic_desc'],
            'subtopics' => []
        ];
    }
    if ($row['sub_topic_id']) {
        $topics[$tid]['subtopics'][] = [
            'id' => $row['sub_topic_id'],
            'title' => $row['sub_title'],
            'description' => $row['sub_desc']
        ];
    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Topics, Subtopics & Upload Questions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/resource/style.css">
</head>

<body>

    <!-- Header -->
    <?php include('./header.php') ?>
    <main class="container mx-auto p-6 flex flex-col gap-6">
        <main class="container mx-auto px-4 py-6">
            <?php include('./nav.php') ?>
            <section id="page-title" class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 text-center uppercase">Topics</h2>
            </section>
            <!-- Add Buttons -->
            <div class="flex gap-3 justify-end">
                <button id="open-topic-popup" class="px-3 py-2 bg-orange-200 border border-white rounded">Add Topic</button>
                <button id="open-subtopic-popup" class="px-3 py-2 bg-orange-200 border border-white rounded">Add Subtopic</button>
            </div>

            <div class="flex gap-6">
                <!-- Topics List -->
                <div class="w-1/4 bg-white rounded-2xl shadow p-4">
                    <h2 class="font-bold text-xl mb-2">Topics</h2>
                    <ul id="topicList" class="space-y-2">
                        <?php foreach ($topics as $tid => $topic): ?>
                            <li>
                                <button class="topic-btn w-full text-left px-3 py-2 rounded hover:bg-orange-100"
                                    data-topic-id="<?= $tid ?>" data-first-sub="<?= $topic['subtopics'][0]['id'] ?? 0 ?>"
                                    data-topic-desc="<?= htmlspecialchars($topic['description']) ?>">
                                    <?= htmlspecialchars($topic['title']) ?>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div id="topicDescription" class="mt-4 text-gray-600 text-sm"></div>
                </div>

                <!-- Subtopics List -->
                <div class="w-1/4 bg-white rounded-2xl shadow p-4">
                    <h2 class="font-bold text-xl mb-2">Subtopics</h2>
                    <ul id="subtopicList" class="space-y-2"></ul>
                    <div id="subtopicDescription" class="mt-4 text-gray-600 text-sm"></div>
                </div>

                    <!-- Available Questions by Subtopic -->
                    <div class="w-1/6 bg-gradient-to-br from-orange-50 to-white border border-orange-200 rounded-xl shadow-sm p-2 flex flex-col items-center" id="available-questions-container">
                        <h2 class="font-bold text-base mb-1 text-orange-700 tracking-wide">Available Questions</h2>
                        <ul id="availableQuestionsList" class="space-y-1 w-full"></ul>
                    </div>
                <!-- Upload Questions -->
                <div class="flex-1">
                    <section id="upload-form-section" class="bg-white rounded-3xl shadow-xl p-8 hidden">
                        <form id="upload-questions-form" enctype="multipart/form-data" class="flex flex-col gap-6" action="../backend/faculty/uploadQuestions.php" method="post">
                            <input type="hidden" name="topic_id" id="uploadTopicId">
                            <input type="hidden" name="subtopic_id" id="uploadSubtopicId">

                            <div class="flex flex-col">
                                <label for="questionsFile" class="mb-2 font-semibold text-gray-700">
                                    Upload Questions File (CSV/XLSX)
                                </label>
                                <input type="file" name="questionsFile" id="questionsFile" accept=".xlsx,.xlsm,.csv" required
                                    class="p-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none w-full transition duration-200 cursor-pointer">
                                <div class="mt-2 flex gap-4">
                                    <!-- <a href="../templates/questions-template.xlsx" download
                                        class="text-orange-500 hover:text-orange-600 text-sm">
                                        Download Excel template
                                    </a> -->
                                    <a href="../templates/questions-template.csv" download
                                        class="text-orange-500 hover:text-orange-600 text-sm">
                                        Download CSV template
                                    </a>
                                </div>
                            </div>

                            <div class="flex justify-center mt-4">
                                <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white rounded-2xl shadow-lg font-semibold transition duration-200">
                                    Upload Questions
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </main>

        <?php include('../resource/footer.php') ?>

        <!-- Topic Modal -->
        <div id="topic-popup" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="bg-white p-10 rounded-3xl shadow-xl max-w-3xl w-full relative">
                <button id="close-topic-popup" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                <h2 class="text-3xl font-bold text-gray-800 mb-2 text-center">Create New Topic</h2>
                <p class="text-gray-500 mb-6 text-center">Add a topic with description for students.</p>
                <form id="create-topic-form" class="flex flex-col gap-6" action="./topic.php" method="post">
                    <input type="text" name="topicName" placeholder="Topic Name" required
                        class="p-4 border rounded-2xl w-full">
                    <textarea name="description" placeholder="Description" rows="5" required class="p-4 border rounded-2xl w-full"></textarea>
                    <button type="submit" class="px-5 py-3 bg-orange-500 text-white rounded shadow font-semibold">Create Topic</button>
                </form>
            </div>
        </div>

        <!-- Subtopic Modal -->
        <div id="subtopic-popup" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="bg-white p-10 rounded-3xl shadow-xl max-w-3xl w-full relative">
                <button id="close-subtopic-popup" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                <h2 class="text-3xl font-bold text-gray-800 mb-2 text-center">Create Sub Topic</h2>
                <p class="text-gray-500 mb-6 text-center">Select a topic and add a sub topic with description.</p>
                <form id="create-subtopic-form" class="flex flex-col gap-6" action="../backend/faculty/subTopic.php" method="POST">
                    <select name="parentTopic" required class="p-4 border rounded-2xl w-full">
                        <option value="">Select Topic</option>
                        <?php foreach ($topics as $tid => $topic): ?>
                            <option value="<?= $tid ?>"><?= htmlspecialchars($topic['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="subTopicName" placeholder="Subtopic Name" required class="p-4 border rounded-2xl w-full">
                    <textarea name="subTopicDescription" placeholder="Description" rows="5" required class="p-4 border rounded-2xl w-full"></textarea>
                    <button type="submit" class="px-5 py-3 bg-orange-500 text-white rounded shadow font-semibold">Create Subtopic</button>
                </form>
            </div>
        </div>



        <script>
            const topics = <?= json_encode($topics) ?>;
            const topicList = document.getElementById('topicList');
            const subtopicList = document.getElementById('subtopicList');
            const uploadForm = document.getElementById('upload-form-section');
            const uploadTopicId = document.getElementById('uploadTopicId');
            const uploadSubtopicId = document.getElementById('uploadSubtopicId');
            const topicDescription = document.getElementById('topicDescription');
            const subtopicDescription = document.getElementById('subtopicDescription');

            // Modal for displaying questions
            let questionModal = document.createElement('div');
            questionModal.id = 'question-modal';
            questionModal.style.display = 'none';
            questionModal.className = 'fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50';
            questionModal.innerHTML = `<div class="bg-white p-8 rounded-3xl shadow-xl max-w-2xl w-full relative">
                <button id="close-question-modal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Questions</h2>
                <div id="question-list" class="space-y-4 max-h-[60vh] overflow-y-auto"></div>
            </div>`;
            document.body.appendChild(questionModal);
            document.getElementById('close-question-modal').onclick = function() {
                questionModal.style.display = 'none';
            };

            // Helper to fetch question count for each subtopic
            async function fetchSubtopicCounts(topicId) {
                const res = await fetch(`../backend/faculty/get_subtopic_question_count.php?topic_id=${topicId}`);
                return await res.json();
            }

            // Helper to fetch questions for a subtopic
            async function fetchQuestions(subTopicId) {
                const res = await fetch(`../backend/faculty/get_questions_by_subtopic.php?sub_topic_id=${subTopicId}`);
                return await res.json();
            }

            // Render subtopics with clickable badge
                async function renderSubtopicsWithBadge(topicId) {
                    // Only render badges and modal triggers in the new container
                    const availableQuestionsList = document.getElementById('availableQuestionsList');
                    availableQuestionsList.innerHTML = '';
                    const subtopics = topics[topicId]?.subtopics || [];
                    const counts = await fetchSubtopicCounts(topicId);
                    const countMap = {};
                    counts.forEach(s => { countMap[s.sub_topic_id] = s.question_count; });
                    subtopics.forEach(sub => {
                        const li = document.createElement('li');
                        li.className = 'flex items-center justify-between gap-1 px-2 py-1 rounded hover:bg-orange-50 transition';
                        li.innerHTML = `<span class="font-medium text-xs text-gray-700 truncate" title="${sub.title}">${sub.title}</span>
                            <span id="availableQuestionsBadge-${sub.id}" class="cursor-pointer px-2 py-0.5 rounded-full bg-orange-200 text-orange-800 text-xs font-bold border border-orange-300 shadow-sm hover:bg-orange-300 transition" data-count-id="${sub.id}">${countMap[sub.id] || 0}</span>`;
                        // Click badge to show questions
                        li.querySelector(`[data-count-id]`).onclick = async function(e) {
                            e.stopPropagation();
                            const questions = await fetchQuestions(sub.id);
                            const qList = document.getElementById('question-list');
                            if (questions.length === 0) {
                                qList.innerHTML = '<div class="text-gray-500">No questions found for this subtopic.</div>';
                            } else {
                                qList.innerHTML = questions.map(q => {
                                    return `<div class='p-4 border rounded-xl bg-gray-50 relative'>
                                        <form class='edit-question-form space-y-2' data-question-id='${q.question_id}' autocomplete='off'>
                                            <div class='font-semibold mb-2'>
                                                <input type='text' name='question_text' value="${q.question_text.replace(/"/g, '&quot;')}" class='w-full border rounded px-2 py-1 text-sm'/>
                                            </div>
                                            <div class='grid grid-cols-2 gap-2 text-sm'>
                                                <div><span class='font-bold'>A:</span> <input type='text' name='option_a' value="${q.option_a.replace(/"/g, '&quot;')}" class='border rounded px-2 py-1 w-full'/></div>
                                                <div><span class='font-bold'>B:</span> <input type='text' name='option_b' value="${q.option_b.replace(/"/g, '&quot;')}" class='border rounded px-2 py-1 w-full'/></div>
                                                <div><span class='font-bold'>C:</span> <input type='text' name='option_c' value="${q.option_c.replace(/"/g, '&quot;')}" class='border rounded px-2 py-1 w-full'/></div>
                                                <div><span class='font-bold'>D:</span> <input type='text' name='option_d' value="${q.option_d.replace(/"/g, '&quot;')}" class='border rounded px-2 py-1 w-full'/></div>
                                            </div>
                                            <div class='mt-2 text-xs text-green-700'>
                                                <label class='font-bold mr-2'>Correct:</label>
                                                <select name='correct_option' class='border rounded px-2 py-1'>
                                                    ${['A','B','C','D'].map(opt => `<option value='${opt}' ${q.correct_option === opt ? 'selected' : ''}>${opt}</option>`).join('')}
                                                </select>
                                            </div>
                                            <div class='flex gap-2 mt-2'>
                                                <button type='submit' class='px-3 py-1 bg-orange-500 text-white rounded text-xs font-semibold hover:bg-orange-600 transition'>Save</button>
                                                <span class='edit-status text-xs text-gray-500'></span>
                                            </div>
                                        </form>
                                    </div>`;
                                }).join('');
                                // Attach submit handler for all forms
                                qList.querySelectorAll('.edit-question-form').forEach(form => {
                                    form.onsubmit = async function(ev) {
                                        ev.preventDefault();
                                        const statusSpan = form.querySelector('.edit-status');
                                        statusSpan.textContent = 'Saving...';
                                        const fd = new FormData(form);
                                        fd.append('question_id', form.getAttribute('data-question-id'));
                                        const res = await fetch('../backend/faculty/update_question.php', {
                                            method: 'POST',
                                            body: fd
                                        });
                                        const result = await res.json();
                                        if (result.success) {
                                            statusSpan.textContent = 'Saved!';
                                            statusSpan.classList.remove('text-red-500');
                                            statusSpan.classList.add('text-green-600');
                                        } else {
                                            statusSpan.textContent = 'Error: ' + (result.error || 'Update failed');
                                            statusSpan.classList.remove('text-green-600');
                                            statusSpan.classList.add('text-red-500');
                                        }
                                        setTimeout(() => { statusSpan.textContent = ''; }, 2000);
                                    };
                                });
                            }
                            questionModal.style.display = 'flex';
                        };
                        availableQuestionsList.appendChild(li);
                    });
                }

            // Patch topic button click to render subtopics with counts
            topicList.querySelectorAll('.topic-btn').forEach(btn => {
                btn.onclick = function() {
                    const topicId = this.getAttribute('data-topic-id');
                    renderSubtopicsWithBadge(topicId);
                    topicDescription.textContent = this.getAttribute('data-topic-desc');
                };
            });

            function renderSubtopics(topicId, defaultSubId) {
                subtopicList.innerHTML = '';
                subtopicDescription.textContent = '';
                if (!topics[topicId] || topics[topicId].subtopics.length === 0) {
                    subtopicList.innerHTML = '<li class="text-gray-400">No subtopics</li>';
                    uploadForm.classList.add('hidden');
                    return;
                }

                topics[topicId].subtopics.forEach(sub => {
                    const li = document.createElement('li');
                    const btn = document.createElement('button');
                    btn.textContent = sub.title;
                    btn.className = 'subtopic-btn w-full text-left px-3 py-2 rounded hover:bg-orange-100';
                    btn.dataset.subId = sub.id;

                    if (sub.id === defaultSubId) {
                        btn.classList.add('bg-orange-200');
                        uploadForm.classList.remove('hidden');
                        uploadTopicId.value = topicId;
                        uploadSubtopicId.value = sub.id;
                        subtopicDescription.textContent = sub.description || '';
                    }

                    btn.onclick = () => {
                        document.querySelectorAll('.subtopic-btn').forEach(b => b.classList.remove('bg-orange-200'));
                        btn.classList.add('bg-orange-200');
                        uploadForm.classList.remove('hidden');
                        uploadTopicId.value = topicId;
                        uploadSubtopicId.value = sub.id;
                        subtopicDescription.textContent = sub.description || '';
                    };

                    li.appendChild(btn);
                    subtopicList.appendChild(li);
                });
            }

            // Topic click
            document.querySelectorAll('.topic-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const topicId = btn.dataset.topicId;
                    const firstSub = parseInt(btn.dataset.firstSub) || 0;
                    document.querySelectorAll('.topic-btn').forEach(b => b.classList.remove('bg-orange-200'));
                    btn.classList.add('bg-orange-200');
                    topicDescription.textContent = btn.dataset.topicDesc || '';
                    renderSubtopics(topicId, firstSub);
                });
            });

            const firstTopicBtn = document.querySelector('.topic-btn');
            if (firstTopicBtn) firstTopicBtn.click();

            // Modal open/close
            ['topic', 'subtopic'].forEach(type => {
                const openBtn = document.getElementById(`open-${type}-popup`);
                const closeBtn = document.getElementById(`close-${type}-popup`);
                const popup = document.getElementById(`${type}-popup`);

                openBtn.addEventListener('click', () => popup.classList.remove('hidden'));
                closeBtn.addEventListener('click', () => popup.classList.add('hidden'));
                window.addEventListener('click', (e) => {
                    if (e.target === popup) popup.classList.add('hidden');
                });
            });
        </script>

</body>

</html>