<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="header d-flex justify-content-between align-items-center">
          <h2>Manage Subjects</h2>
          <a href="<?= site_url('subjects/add') ?>" class="add-p">
            <button class="btn btn-primary px-3 py-2">Add New Subject</button>
          </a>
        </div>
      </div>
    </div>
    <hr>

    <form method="get" action="<?= site_url('subjects') ?>">
      <div class="row d-flex justify-content-between align-items-center">
        <div class="col-md-5">
          <label>Filter by Program:</label>
          <select class="form-inputs" name="program_id" id="programFilter" onchange="this.form.submit()">
            <option value="">All Programs</option>
            <?php foreach ($programs as $program): ?>
              <option value="<?= esc($program['id']) ?>" <?= ($selectedProgram == $program['id']) ? 'selected' : '' ?>>
                <?= esc($program['program_name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-5 ">
          <label style="margin-left: 3vw;">Filter by Semester:</label>
          <select class="form-inputs" name="semester_number" id="semesterFilter" onchange="this.form.submit()">
            <option value="">All Semesters</option>
            <?php for ($i = 1; $i <= 10; $i++): ?>
              <option value="<?= $i ?>" <?= ($selectedSemester == $i) ? 'selected' : '' ?>>
                Semester <?= $i ?>
              </option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-md-2">
          <button class="btn btn-primary ml-4" type="submit">Filter</button>

          <a class="btn btn-warning" href="<?= site_url('subjects') ?>">Reset</a>
        </div>
      </div>

    </form>
    <hr>

    <!-- Subjects List -->
    <div class="row">
      <div class="table-responsive">
        <table id="dataTable" class="table table-hover table-striped table-bordered text-center">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Program</th>
              <th>Semester</th>
              <th>Subject Code</th>
              <th>Subject Name</th>
              <th>Credits</th>
              <th>Faculty Name</th>
              <th>Type</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($subjects as $subject) : ?>
              <tr>
                <td><?= esc($subject['id']) ?></td>
                <td style="width: 17vw;"><?= esc($subject['program_name']) ?></td>
                <td><?= esc($subject['semester_number']) ?></td>
                <td><?= esc($subject['subject_code']) ?></td>
                <td><?= esc($subject['subject_name']) ?></td>
                <td><?= esc($subject['credit']) ?></td>
                <td><?= esc($subject['faculty_name']) ?></td>
                <td><?= esc($subject['type']) ?></td>
                <td>
                  <a class="btn btn-sm btn-warning" href="<?= site_url('subjects/edit/' . $subject['id']) ?>"><i class="bi bi-pencil-square"></i></a> |
                  <a class="btn btn-sm btn-danger" href="<?= site_url('subjects/delete/' . $subject['id']) ?>" onclick="return confirm('Are you sure?')"><i class="bi bi-trash-fill"></i></a>
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