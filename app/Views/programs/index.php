<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="header d-flex justify-content-between align-items-center">
          <h2>Manage Programs</h2>
          <a href="<?= site_url('programs/add') ?>" class="add-p">
            <button class="btn btn-primary px-3 py-2">Add New Program</button>
          </a>
        </div>
      </div>
    </div>
    <hr>

    <!-- Programs List -->
    <div class="row">
      <div class="table-responsive">
        <table id="dataTable" class="table table-hover table-striped table-bordered text-center">
          <thead class="table-dark">
            <tr>
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
                  <a class="btn btn-sm btn-warning" href="<?= site_url('programs/edit/' . $program['id']) ?>"><i class="bi bi-pencil-square"></i></a> |
                  <a class="btn btn-sm btn-danger" href="<?= site_url('programs/delete/' . $program['id']) ?>" onclick="return confirm('Are you sure?')"><i class="bi bi-trash-fill"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>