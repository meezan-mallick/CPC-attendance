<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
  <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
  <?php elseif (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>
  <div class="m-4">
    <div class="header">
      <div class="heading">
        <h2>Your Subjects</h2>
      </div>
      <div>

      </div>
    </div>
    <hr>

    <div class="row">
      <div class="table-responsive">
        <table id="dataTable" class="table table-hover table-striped table-bordered text-center">
          <thead class="table-dark">
            <tr class="text-center">
              <th>ID</th>
              <th>Subject Name</th>
              <th>Program Name</th>
              <th>Co ordinator</th>
              <th>Semester</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($subjects as $subject) : ?>
              <tr>
                <td><?= esc($subject['id']) ?></td>
                <td class="text-center"><?= esc($subject['subject_name']) ?></td>
                <td class=" text-left"><?= esc($subject['program_name']) ?></td>
                <td class=" text-left"><?= esc($subject['coordinator']) ?></td>
                <td class="text-center"><?= esc($subject['semester_number']) ?></td>
                <td class="text-center">
                  <a class="btn btn-sm btn-warning" href="<?= site_url('topics-list/' . $subject['program_id'] . '/' . $subject['semester_number'] . '/' . $subject['subject_id']) ?>">Take Attendance</a>
                </td>
              </tr>
            <?php endforeach; ?>

          </tbody>
        </table>
      </div>
    </div>


  </div>

  <?= $this->endSection() ?>