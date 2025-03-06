<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="m-4">

        <div class="container-fluid">
            <div class="container">
                
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error_import')): ?>
                    <div class="alert alert-warning"><?= session()->getFlashdata('error_import') ?></div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>


                <hr>
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Enrollment No.</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Mobile No</th>
                            <th>Placement Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($students)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-danger">No students found for <?= esc($program_name) ?> (<?= esc($semester) ?> Semester).</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($students as $index => $student): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($student['university_enrollment_no']) ?></td>
                                    <td><?= esc($student['full_name']) ?></td>
                                    <td><?= esc($student['email']) ?></td>
                                    <td><?= esc($student['mobile_number']) ?></td>
                                    <td>
                                        <?= ($student['placement_status']) ? '<span class="text-success">Placed</span>' : '<span class="text-danger">Not Placed</span>'; ?>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('students/edit/' . $student['id']) ?>" class="btn btn-sm btn-primary">✏ Edit</a>
                                        <a href="<?= site_url('students/delete/' . $student['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?');">🗑 Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="mt-3">
                    <form action="<?= site_url('students/import/' . $program_id . '/' . $semester . '/' . $batch) ?>" method="post" enctype="multipart/form-data">
                        <label>Import Students from Excel:</label>
                        <input type="file" name="student_file" class="form-control" required>
                        <button type="submit" class="btn btn-primary mt-2">📤 Upload & Import</button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>













<div class="d-flex justify-content-between align-items-center">
    <h2>Students List - <?= esc($program_name) ?> (Semester <?= esc($semester) ?>, Batch <?= esc($batch) ?>)</h2>
    <div>
        <a href="<?= site_url('students/import') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-upload"></i> Import Students
        </a>
        <a href="<?= site_url('students/download-sample') ?>" class="btn btn-success btn-sm">
            <i class="bi bi-file-earmark-arrow-down"></i> Download Sample Excel
        </a>
    </div>
</div>