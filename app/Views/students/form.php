<?= $this->extend('main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Add a New Student</h2>

    <?php if (session()->getFlashdata('error_import')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error_import') ?></div>
    <?php endif; ?>

    <form action="<?= site_url('students/store') ?>" method="post">
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name:</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label for="mobile_number" class="form-label">Mobile Number:</label>
            <input type="text" name="mobile_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="program_id" class="form-label">Program:</label>
            <select name="program_id" class="form-select">
                <option value="">-- Select Program --</option>
                <?php foreach ($programs as $program): ?>
                    <option value="<?= $program['id'] ?>" <?= ($program_id == $program['id']) ? 'selected' : '' ?>>
                        <?= esc($program['program_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="semester" class="form-label">Semester:</label>
            <input type="number" name="semester" class="form-control" value="<?= esc($semester) ?>">
        </div>

        <div class="mb-3">
            <label for="batch" class="form-label">Batch (Leave blank for Single Class):</label>
            <input type="number" name="batch" class="form-control" value="<?= esc($batch) ?>">
        </div>

        <button type="submit" class="btn btn-primary">➕ Add Student</button>
        <a href="<?= site_url('students?course=' . $program_id . '&semester=' . $semester . '&batch=' . $batch) ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?= $this->endSection() ?>