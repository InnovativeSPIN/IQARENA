<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Topic</title>

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-100 min-h-screen font-sans">

    <?php include('./header.php') ?>

    <main class="container mx-auto p-6 flex flex-col gap-8">
        <section id="nav-section">
            <?php include('./nav.php') ?>
        </section>

       <div class="flex gap-3">
         <div>
            <button id="open-topic-popup" class="px-3 py-2 bg-orange-200 border-white border-2">
                Add Topics
            </button>
        </div>
        <div>
            <button id="open-topic-popup" class="px-3 py-2 bg-orange-200 border-white border-2">
                Add Sub Topics
            </button>
        </div>
       </div>

        <!-- Topic Popup Modal -->
        <div id="topic-popup" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="bg-white p-10 rounded-3xl shadow-xl max-w-3xl w-full relative">
                <button id="close-topic-popup" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                <h2 class="text-3xl font-bold text-gray-800 mb-2 text-center">Create New Topic</h2>
                <p class="text-gray-500 mb-6 text-center">Add a topic with a descriptive summary for students.</p>
                <form id="create-topic-form" class="flex flex-col gap-8">
                    <div class="flex flex-col">
                        <label for="topicName" class="mb-2 font-semibold text-gray-700">Topic Name</label>
                        <input type="text" id="topicName" name="topicName" placeholder="Enter topic name" required
                            class="p-4 border border-gray-300 rounded-2xl shadow-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200 w-full text-gray-800 font-medium" />
                    </div>
                    <div class="flex flex-col">
                        <label for="topicDescription" class="mb-2 font-semibold text-gray-700">Description</label>
                        <textarea id="topicDescription" name="description" rows="5" placeholder="Enter topic description"
                            class="p-4 border border-gray-300 rounded-2xl shadow-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200 w-full text-gray-800 font-medium"></textarea>
                    </div>
                    <div class="flex justify-center">
                        <button type="submit"
                            class="px-5 py-3 bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white rounded shadow-xl font-semibold text-lg transition duration-200">
                            Create Topic
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sub Topic Popup Modal -->
        <div id="subtopic-popup" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="bg-white p-10 rounded-3xl shadow-xl max-w-3xl w-full relative">
                <button id="close-subtopic-popup" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                <h2 class="text-3xl font-bold text-gray-800 mb-2 text-center">Create Sub Topic</h2>
                <p class="text-gray-500 mb-6 text-center">Select a topic and add a sub topic with description.</p>
                <form id="create-subtopic-form" class="flex flex-col gap-8">
                    <div class="flex flex-col">
                        <label for="parentTopic" class="mb-2 font-semibold text-gray-700">Select Topic</label>
                        <select id="parentTopic" name="parentTopic" required class="p-4 border border-gray-300 rounded-2xl shadow-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200 w-full text-gray-800 font-medium">
                            <option value="">Select a topic</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label for="subTopicName" class="mb-2 font-semibold text-gray-700">Sub Topic Name</label>
                        <input type="text" id="subTopicName" name="subTopicName" placeholder="Enter sub topic name" required
                            class="p-4 border border-gray-300 rounded-2xl shadow-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200 w-full text-gray-800 font-medium" />
                    </div>
                    <div class="flex flex-col">
                        <label for="subTopicDescription" class="mb-2 font-semibold text-gray-700">Description</label>
                        <textarea id="subTopicDescription" name="subTopicDescription" rows="5" placeholder="Enter sub topic description"
                            class="p-4 border border-gray-300 rounded-2xl shadow-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200 w-full text-gray-800 font-medium"></textarea>
                    </div>
                    <div class="flex justify-center">
                        <button type="submit"
                            class="px-5 py-3 bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white rounded shadow-xl font-semibold text-lg transition duration-200">
                            Create Sub Topic
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </main>
    <?php include('../resource/api.php') ?>


    <?php include('./sessionHandle.php') ?>


    <!-- insert topics -->
    <script>
        document.getElementById('create-topic-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            const topicName = document.getElementById('topicName').value.trim();
            const topicDescription = document.getElementById('topicDescription').value.trim();
            let added_by = localStorage.getItem("roll_id");
            console.log(added_by)
            const payload = {
                title: topicName,
                description: topicDescription,
                added_by: added_by
            };
            try {
                const res = await fetch('<?php echo $api; ?>faculty/topics/topicRoutes.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const result = await res.json();
                if (result.success) {
                    alert('Topic created successfully!');
                     
          window.location.href = './topic.php';
                    document.getElementById('create-topic-form').reset();
                } else {
                    alert('Error: ' + (result.error || 'Failed to create topic'));
                }
            } catch (err) {
                alert('Network error: ' + err.message);
            }
        });


        // open pop up model
        document.getElementById('open-topic-popup').addEventListener('click', function () {
            document.getElementById('topic-popup').classList.remove('hidden');
        });
        document.getElementById('close-topic-popup').addEventListener('click', function () {
            document.getElementById('topic-popup').classList.add('hidden');
        });
 
        window.addEventListener('click', function (e) {
            var popup = document.getElementById('topic-popup');
            if (!popup.classList.contains('hidden') && e.target === popup) {
                popup.classList.add('hidden');
            }
        });

        // Open subtopic modal
 document.querySelectorAll('#open-topic-popup')[1].addEventListener('click', function () {
    document.getElementById('subtopic-popup').classList.remove('hidden');
    // Fetch topics for select
    fetch('<?php echo $api; ?>faculty/topics/topicRoutes.php')
        .then(res => res.json())
        .then(topics => {
            const select = document.getElementById('parentTopic');
            select.innerHTML = '<option value="">Select a topic</option>';
            topics.forEach(topic => {
                select.innerHTML += `<option value="${topic.topic_id}">${topic.title}</option>`;
            });
        });
 });
 document.getElementById('close-subtopic-popup').addEventListener('click', function () {
    document.getElementById('subtopic-popup').classList.add('hidden');
 });
 window.addEventListener('click', function (e) {
    var popup = document.getElementById('subtopic-popup');
    if (!popup.classList.contains('hidden') && e.target === popup) {
        popup.classList.add('hidden');
    }
 });

// Handle subtopic form submit
 document.getElementById('create-subtopic-form').addEventListener('submit', async function (e) {
    e.preventDefault();
    const parentTopic = document.getElementById('parentTopic').value;
    const subTopicName = document.getElementById('subTopicName').value.trim();
    const subTopicDescription = document.getElementById('subTopicDescription').value.trim();
    let added_by = localStorage.getItem("roll_id");
    const payload = {
        parent_topic_id: parentTopic,
        title: subTopicName,
        description: subTopicDescription,
        added_by: added_by
    };
    try {
        const res = await fetch('<?php echo $api; ?>faculty/topics/subTopicRoutes.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        const result = await res.json();
        if (result.success) {
            alert('Sub Topic created successfully!');
            document.getElementById('create-subtopic-form').reset();
            document.getElementById('subtopic-popup').classList.add('hidden');
        } else {
            alert('Error: ' + (result.error || 'Failed to create sub topic'));
        }
    } catch (err) {
        alert('Network error: ' + err.message);
    }
 });
    </script>

</body>

</html>
