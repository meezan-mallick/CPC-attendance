<?= $this->extend('layout/main'); ?>
<?= $this->section('content'); ?>

<h2>Import Students</h2>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger"><?= session('error'); ?></div>
<?php endif; ?>

<form action="<?= base_url('students/processImport/' . $program_id . '/' . $semester_id . '/' . $batch_id) ?>" method="POST" enctype="multipart/form-data">
    <label for="student_file">Upload Excel File:</label>
    <input type="file" name="student_file" required>
    <button type="submit">Upload</button>
</form>

<?= $this->endSection(); ?>