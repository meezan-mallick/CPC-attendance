<?= $this->extend('main') ?>
<?= $this->section('content') ?>

<div class="container-fluid mt-4">
    <div class="container">
        <div>
            <h2>Students List - <?= esc($program_name) ?> (<?= esc($semester) ?> Semester, Batch - <?= esc($batch) ?>)</h2>

            <div class="mb-3">
                <a href="<?= site_url('students') ?>" class="btn btn-warning">🔙 Back to Course Selection</a>
                <a href="<?= site_url('students/download-sample') ?>" class="btn btn-success">⬇ Download Sample Excel</a>
            </div>

        </div>
        <!-- Display Success/Error Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <hr>

        <!-- Bulk Delete Button -->
        <button id="bulk-delete-btn" class="btn btn-danger btn-sm mb-3" disabled>
            <i class="bi bi-trash"></i> Delete Selected
        </button>

        <!-- Students Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>#</th>
                        <th>Enrollment No.</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Mobile No</th>
                        <th>Batch</th>
                        <th>Placement Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($students)): ?>
                        <tr>
                            <td colspan="9" class="text-center text-danger">
                                No students found for <?= esc($program_name) ?> (<?= esc($semester) ?> Semester).
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($students as $index => $student): ?>
                            <tr>
                                <td><input type="checkbox" class="student-checkbox" value="<?= $student['id'] ?>"></td>
                                <td><?= $index + 1 ?></td>
                                <td><?= esc($student['university_enrollment_no']) ?></td>
                                <td><?= esc($student['full_name']) ?></td>
                                <td><?= esc($student['email']) ?></td>
                                <td><?= esc($student['mobile_number']) ?></td>
                                <td><?= ($student['batch'] == 0) ? 'Single Class' : 'Batch ' . esc($student['batch']); ?></td>
                                <td>
                                    <?= ($student['placement_status'])
                                        ? '<span class="badge bg-success">Placed</span>'
                                        : '<span class="badge bg-danger">Not Placed</span>'; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= site_url('students/edit/' . $student['id']) ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <a href="<?= site_url('students/delete/' . $student['id']) ?>"
                                        class="btn btn-sm btn-danger delete-student-btn"
                                        data-id="<?= $student['id'] ?>">
                                        <i class="bi bi-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- JavaScript for Bulk Selection & Deletion -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selectAllCheckbox = document.getElementById("select-all");
        const checkboxes = document.querySelectorAll(".student-checkbox");
        const bulkDeleteBtn = document.getElementById("bulk-delete-btn");

        // Select All Toggle
        selectAllCheckbox.addEventListener("change", function() {
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            toggleBulkDeleteButton();
        });

        // Enable/Disable Bulk Delete Button
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener("change", toggleBulkDeleteButton);
        });

        function toggleBulkDeleteButton() {
            const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            bulkDeleteBtn.disabled = !anyChecked;
        }

        // Bulk Delete Functionality
        bulkDeleteBtn.addEventListener("click", function() {
            const selectedIds = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);

            if (selectedIds.length === 0) {
                alert("Please select at least one student to delete.");
                return;
            }

            if (!confirm("Are you sure you want to delete the selected students?")) {
                return;
            }

            fetch("<?= site_url('students/bulk-delete') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({
                        student_ids: selectedIds
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert("Error deleting students.");
                    }
                })
                .catch(error => console.error("Bulk Delete Error:", error));
        });
    });
</script>

<?= $this->endSection() ?>