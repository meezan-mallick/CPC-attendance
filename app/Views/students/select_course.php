<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
    <div class="container mt-4">
        <h2 class="mb-4">Select Course, Semester, and Batch</h2>

        <div class="card shadow p-4">
            <form action="<?= base_url('students/list') ?>" method="GET">
                <div class="row">
                    <!-- Course Dropdown -->
                    <div class="col-md-4 col-12">
                        <label for="course" class="form-label">Select Course:</label>
                        <select id="course" name="course" class="form-select" required>
                            <option value="">-- Select Course --</option>
                            <?php foreach ($programs as $program): ?>
                                <option value="<?= $program['id']; ?>"><?= $program['program_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Semester Dropdown -->
                    <div class="col-md-4 col-12">
                        <label for="semester" class="form-label">Select Semester:</label>
                        <select id="semester" name="semester" class="form-select" required>
                            <option value="">-- Select Semester --</option>
                        </select>
                    </div>

                    <!-- Batch Number Input -->
                    <div class="col-md-4 col-12">
                        <label for="batch" class="form-label">Batch Number:</label>
                        <input type="number" id="batch" name="batch" class="form-control" min="1" placeholder="Enter Batch No (Optional)">
                        <small class="text-muted">Leave blank if this is a single class.</small>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100">Proceed</button>
                </div>
            </form>
        </div>
    </div>

    <!-- jQuery AJAX Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Ensure the dropdowns exist before running the script
            var courseDropdown = $("#course");
            var semesterDropdown = $("#semester");
            var batchDropdown = $("#batch");

            if (courseDropdown.length === 0 || semesterDropdown.length === 0 || batchDropdown.length === 0) {
                console.error("Dropdown elements not found. Ensure correct HTML structure.");
                return; // Stop execution if elements are missing
            }

            // Fetch Semesters when Course is Selected
            courseDropdown.change(function() {
                var course_id = $(this).val();
                console.log("Selected Course ID:", course_id); // Debugging

                if (course_id) {
                    $.ajax({
                        url: "<?= base_url('students/getSemesters') ?>",
                        type: "POST",
                        data: {
                            program_id: course_id
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log("AJAX Response:", response); // Debugging

                            semesterDropdown.html('<option value="">-- Select Semester --</option>');

                            if (response.length > 0) {
                                $.each(response, function(index, semester) {
                                    semesterDropdown.append('<option value="' + semester.id + '">' + semester.semester_name + '</option>');
                                });
                            } else {
                                alert("No semesters found for the selected course.");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", xhr.responseText); // Debugging
                            alert("An error occurred. Check the console for details.");
                        }
                    });
                } else {
                    semesterDropdown.html('<option value="">-- Select Semester --</option>');
                }
            });


        });
    </script>

</div>
<?= $this->endSection(); ?>