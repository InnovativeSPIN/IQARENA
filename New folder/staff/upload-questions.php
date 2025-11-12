<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Questions</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">
    <?php include('./header.php') ?>

    <main class="container mx-auto px-4 py-6">
        <?php include('./nav.php') ?>
        <section id="page-title" class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Upload Questions</h2>
            <p class="text-gray-600 mt-1">Select a quiz and upload your questions in CSV/XLSX format.</p>
        </section>

<section id="upload-form-section" class="bg-white rounded-3xl shadow-xl p-8 max-w-xl mx-auto">
    <form id="upload-questions-form" enctype="multipart/form-data" class="flex flex-col gap-6">

        <div class="flex flex-col relative">
            <label class="font-semibold text-gray-700 mb-2">Select Topic</label>
            <div class="relative">
                <button type="button" class="w-full p-3 border border-gray-300 rounded-xl shadow-sm bg-white text-left focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200" id="topicBtn">
                    --Select Topic--
                </button>
                <ul class="absolute z-10 w-full bg-white border border-gray-300 rounded-xl shadow-lg mt-1 hidden" id="topicList">
                    <li class="p-3 hover:bg-orange-100 cursor-pointer" data-value="topic1">Topic 1</li>
                    <li class="p-3 hover:bg-orange-100 cursor-pointer" data-value="topic2">Topic 2</li>
                    <li class="p-3 hover:bg-orange-100 cursor-pointer" data-value="topic3">Topic 3</li>
                </ul>
                <input type="hidden" name="topic" id="topicInput">
            </div>
        </div>
        <div class="flex flex-col">
            <label for="questionsFile" class="mb-2 font-semibold text-gray-700">Upload Questions File (CSV/XLSX)</label>
            <input type="file" name="questionsFile" id="questionsFile" accept=".xlsx, .xlsm, .csv" required
                class="p-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none w-full transition duration-200 cursor-pointer">
            <a href="/templates/questions-template.xlsx" download
               class="text-orange-500 hover:text-orange-600 mt-2 text-sm">Download template file</a>
        </div>
        <div class="flex justify-center mt-4">
            <button type="submit"
                class="px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white rounded-2xl shadow-lg font-semibold transition duration-200">
                Upload Questions
            </button>
        </div>

    </form>
</section>

    </main>
    <?php include('../resource/api.php') ?>

    <script>
        window.addEventListener('DOMContentLoaded', async () => {
            try {
                const response = await fetch('<?php echo $api; ?>faculty/test/testRoutes.php');
                const result = await response.json();

                if (result.success) {
                    const quizSelect = document.getElementById('quizSelect');
                    quizSelect.innerHTML = '<option value="">Select a quiz</option>';
                    result.data.forEach(test => {
                        const option = document.createElement('option');
                        option.value = test.test_id;
                        option.textContent = test.title;
                        quizSelect.appendChild(option);
                    });
                } else {
                    console.error('Failed to load tests:', result.message);
                }
            } catch (err) {
                console.error('Error fetching quiz list:', err);
            }
        });

        document.getElementById('upload-questions-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = document.getElementById('upload-questions-form');
            const formData = new FormData(form);

            try {
                const response = await fetch('<?php echo $api; ?>faculty/question/questionRoutes.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                alert(result.message || result.error);

                if (result.message) form.reset();
            } catch (error) {
                console.error('Request failed:', error);
            }
        });
    </script>
    <script>
function setupDropdown(btnId, listId, inputId) {
    const btn = document.getElementById(btnId);
    const list = document.getElementById(listId);
    const input = document.getElementById(inputId);

    btn.addEventListener('click', () => list.classList.toggle('hidden'));

    list.querySelectorAll('li').forEach(item => {
        item.addEventListener('click', () => {
            btn.textContent = item.textContent;
            input.value = item.dataset.value;
            list.classList.add('hidden');
        });
    });

    document.addEventListener('click', e => {
        if (!btn.contains(e.target) && !list.contains(e.target)) {
            list.classList.add('hidden');
        }
    });
}

setupDropdown('topicBtn', 'topicList', 'topicInput');
</script>
    <?php include('../resource/logout.php') ?>
    <?php include('../resource/check_session.php') ?>

</body>
</html>
