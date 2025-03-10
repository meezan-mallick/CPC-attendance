<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

  <div class="m-4">
    <div class="header">
      <div class="heading">
        <h2>Allocates Subjects</h2>
      </div>
      <div>

        <a href="subjectsallocation/assign" class="add-p">
          <button class="btn btn-primary">Allocate</button>
        </a>
      </div>
    </div>
    <hr>
    <div class="table-wrapper data-table">
      <table class="table">
        <thead>
          <tr class="text-center">
            <th>ID</th>
            <th>College Code</th>
            <th>Program Name</th>
            <th>Semester</th>
            <th>Subject Name</th>
            <th>Faculty Name</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody>
        <?php foreach ($allocatedsubjects as $subject) : ?>
            <tr>
              <td><?= esc($subject['id']) ?></td>
              <td><?= esc($subject['college_code']) ?></td>
              <td><?= esc($subject['program_name']) ?></td>
              <td><?= esc($subject['semester_number']) ?></td>
              <td><?= esc($subject['subject_name']) ?></td>
              <td><?= esc($subject['faculty_name']) ?></td>
           
              <td>
                <a class="btn btn-sm btn-warning" href="<?= site_url('subjectsallocation/edit/' . $subject['id']) ?>">Edit</a> |
                <a class="btn btn-sm btn-danger" href="<?= site_url('subjectsallocation/delete/' . $subject['id']) ?>" onclick="return confirm('Are you sure?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
           
        </tbody>
      </table>
    </div>
  </div>

  <?= $this->endSection() ?>