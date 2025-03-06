<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

  <div class="m-4">
    <div class="header">
      <div class="heading">
        <h2>All Programs</h2>
      </div>
      <div>

        <a href="programs/add" class="add-p">
          <button class="btn btn-primary">Add new</button>
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
            <th>Co ordinator</th>
            <th>Duration</th>
            <th>Total Semester</th>
            <th>Type</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody>

          <?php foreach ($programs as $program) : ?>
            <tr>
              <td><?= esc($program['id']) ?></td>
              <td class="text-center"><?= esc($program['college_code']) ?></td>
              <td class=" text-left"><?= esc($program['program_name']) ?></td>
              <td class="text-center"><?= "-" ?></td>
              <td class="text-center"><?= esc($program['program_duration']) ?></td>
              <td class="text-center"><?= esc($program['total_semesters']) ?></td>
              <td class="text-center"><?= $program['program_type'] ? 'Integrated' : 'Masters' ?></td>
              <td class="text-center">
                <a class="btn btn-sm btn-warning" href="<?= site_url('programs/edit/' . $program['id']) ?>">Edit</a> |
                <a class="btn btn-sm btn-danger" href="<?= site_url('programs/delete/' . $program['id']) ?>" onclick="return confirm('Are you sure?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>

        </tbody>
      </table>
    </div>
  </div>

  <?= $this->endSection() ?>