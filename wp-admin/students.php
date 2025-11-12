<?php

$page_name = "Students ";


?>
<?php include('./head.php') ?>

<?php include('./sidebar.php') ?>


<!-- Student Content -->
<main class="p-6">
    <!-- Action Bar -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="flex items-center space-x-3">
            <div class="relative">
                <input type="text" placeholder="Search students..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 w-full md:w-64">
                <i data-feather="search" class="absolute left-3 top-2.5 text-gray-400"></i>
            </div>
            <div>
                <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-primary-500 focus:border-primary-500">
                    <option>All Departments</option>
                    <option>Computer Science</option>
                    <option>Electrical Engineering</option>
                    <option>Mechanical Engineering</option>
                    <option>Civil Engineering</option>
                    <option>Electronics</option>
                    <option>Information Technology</option>
                    <option>Chemical Engineering</option>
                </select>
            </div>
            <div>
                <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-primary-500 focus:border-primary-500">
                    <option>All Years</option>
                    <option>1st Year</option>
                    <option>2nd Year</option>
                    <option>3rd Year</option>
                    <option>4th Year</option>
                </select>
            </div>
        </div>
        <div class="flex space-x-3">
             <button id="StudentModel"
                class="flex items-center px-4 py-2 border border-primary-600 bg-orange-400 text-white rounded-lg hover:bg-primary-500">
                <i data-feather="upload" class="mr-2"></i>
                Add Student
            </button>
            <button id="openModalBtn"
                class="flex items-center px-4 py-2 border border-primary-600 text-primary-600 rounded-lg hover:bg-primary-50">
                <i data-feather="upload" class="mr-2"></i>
                Bulk Upload
            </button>
            <button class="flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                <i data-feather="download" class="mr-2"></i>
                Export
            </button>
        </div>
    </div>

    <!-- Student Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Roll No
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Department
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Year
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">

                </tbody>
            </table>
        </div>
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </a>
                <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </a>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing
                        <span class="font-medium">1</span>
                        to
                        <span class="font-medium">5</span>
                        of
                        <span class="font-medium">124</span>
                        results
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <i data-feather="chevron-left" class="h-5 w-5"></i>
                        </a>
                        <a href="#" aria-current="page" class="z-10 bg-primary-50 border-primary-500 text-primary-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                            1
                        </a>
                        <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                            2
                        </a>
                        <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                            3
                        </a>
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                            ...
                        </span>
                        <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                            8
                        </a>
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Next</span>
                            <i data-feather="chevron-right" class="h-5 w-5"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Student Modal (Hidden by default) -->
   <!-- Add Student Modal -->
<div id="addStudentModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i data-feather="user-plus" class="w-5 h-5 text-primary-600 mr-2"></i>
                Add New Student
            </h3>
            <button type="button" id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                ✕
            </button>
        </div>

        <!-- Form -->
        <form id="studentForm" class="space-y-4">
            <!-- Roll Number -->
            <div>
                <label for="roll_no" class="block text-sm font-medium text-gray-700">Roll Number</label>
                <input type="text" name="roll_no" id="roll_no"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-primary-500"
                    required>
            </div>

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" name="name" id="name"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-primary-500"
                    required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-primary-500"
                    required>
            </div>

            <!-- Department and Year -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                    <select id="department_id" name="department_id"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-primary-500"
                        required>
                        <option value="">Select Department</option>
                        <?php
                        include("../resource/conn.php");
                        $sql = "SELECT id, short_name, full_name FROM departments";
                        $result = $conn->query($sql);
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($row['id']) . '">' .
                                    htmlspecialchars($row['full_name']) . ' (' . htmlspecialchars($row['short_name']) . ')</option>';
                            }
                        } else {
                            echo '<option value="">No Departments Found</option>';
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                    <select id="year" name="year"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-primary-500"
                        required>
                        <option value="">Select Year</option>
                        <option value="1">1st Year</option>
                        <option value="2">2nd Year</option>
                        <option value="3">3rd Year</option>
                        <option value="4">4th Year</option>
                    </select>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" id="cancelModalBtn"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700">
                    Save Student
                </button>
            </div>
        </form>
    </div>
</div>


    <div id="bulkUploadModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Bulk Upload</h2>
                <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>

            <form id="uploadForm" action="./backend/uploadquestions.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                <!-- Department -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Department</label>
                    <select name="department" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-600">
                        <option value="">Select Department</option>
                        <?php
                        include("../resource/conn.php");
                        $sql = "SELECT id, short_name, full_name FROM departments";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($row['id']) . '">'
                                    . htmlspecialchars($row['full_name']) . ' (' . htmlspecialchars($row['short_name']) . ')</option>';
                            }
                        } else {
                            echo '<option value="">No Departments Found</option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- Year -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Year</label>
                    <select name="year" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-600">
                        <option value="">Select Year</option>
                        <option value="1">1st Year</option>
                        <option value="2">2nd Year</option>
                        <option value="3">3rd Year</option>
                        <option value="4">4th Year</option>
                    </select>
                </div>

                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Upload File</label>
                    <input type="file" name="file" required
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-600">
                </div>


                <!-- Submit -->
                <div class="flex justify-between  items-center">
       <a href="./resource/stu_template.csv">
            <button 
                        class="px-4 py-2 text-orange-800">
                        Template 
                    </button>
       </a>
                    <button type="submit"
                        class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                        Upload
                    </button>
                </div>
            </form>

            <div id="result" class="mt-4 text-sm"></div>
        </div>
    </div>



</main>


<script>
    const modal = document.getElementById("bulkUploadModal");
    const openBtn = document.getElementById("openModalBtn");
    const closeBtn = document.getElementById("closeModalBtn");

    openBtn.onclick = () => {
        modal.classList.remove("hidden");
        modal.classList.add("flex");
    };
    closeBtn.onclick = () => {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    };
    window.onclick = (e) => {
        if (e.target === modal) {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }
    };
</script>


<script>
    document.getElementById('uploadForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        const resultDiv = document.getElementById('result');
        resultDiv.innerHTML = "Uploading...";

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            console.log(data)

            if (data.status === "success") {
                resultDiv.innerHTML = `<span class="text-green-600">${data.message} Inserted: ${data.inserted}</span>`;
            } else {
                resultDiv.innerHTML = `<span class="text-red-600">${data.message}</span>`;
            }
        } catch (err) {
            resultDiv.innerHTML = `<span class="text-red-600">Error: ${err.message}</span>`;
        }
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("addStudentModal");
    const openBtn = document.querySelector("#StudentModel");
    const cancelBtn = modal.querySelector("button:nth-child(2)"); 
    const overlay = modal.querySelector(".bg-gray-500"); 

   
    openBtn.addEventListener("click", (e) => {
        e.preventDefault(); 
        modal.classList.remove("hidden");
    });

    
    cancelBtn.addEventListener("click", () => {
        modal.classList.add("hidden");
    });


    overlay.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

 
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && !modal.classList.contains("hidden")) {
            modal.classList.add("hidden");
        }
    });
});
</script>
<script>
document.getElementById("studentForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

 


   fetch("./backend/addStudents.php", {
    method: "POST",
    body: formData
})
.then(response => response.text()) 
.then(text => {
    console.log("Raw response:", text);
    try {
        const data = JSON.parse(text);
        console.log("Parsed JSON:", data);

        alert(data.message);
        if (data.status === "success") {
            document.getElementById("studentForm").reset();
            document.getElementById("addStudentModal").classList.add("hidden");
        }
    } catch (err) {
        console.error("JSON parse error:", err, "Response was:", text);
        alert("Server returned invalid JSON. Check console for details.");
    }
})
.catch(err => {
    console.error("Fetch error:", err);
    alert("Error: " + err);
});

});
</script>


</body>

</html>