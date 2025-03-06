<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

  <div class="m-4">
    <div class="header">
      <div class="heading">
        <h2>All Subjects</h2>
      </div>

      <div>

        <a href="subjects/add" class="add-p">
          <button class="btn btn-primary">Add new</button>
        </a>
      </div>
    </div>
    <hr>
    <div style="margin-bottom:1vw;text-align:center">

      <!-- Filter Form -->

      <form method="get" action="<?= site_url('subjects') ?>">
        <div class="row">
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



    </div>
    <hr>

    <div class="table-wrapper data-table">
      <table>
        <thead>

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
              <td><?= esc($subject['program_name']) ?></td>
              <td><?= esc($subject['semester_number']) ?></td>
              <td><?= esc($subject['subject_code']) ?></td>
              <td><?= esc($subject['subject_name']) ?></td>
              <td><?= esc($subject['credit']) ?></td>
              <td>FACULTY NAME</td>
              <td><?= esc($subject['type']) ?></td>
              <td>
                <a class="btn btn-sm btn-warning" href="<?= site_url('subjects/edit/' . $subject['id']) ?>">Edit</a> |
                <a class="btn btn-sm btn-danger" href="<?= site_url('subjects/delete/' . $subject['id']) ?>" onclick="return confirm('Are you sure?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>

        </tbody>
      </table>
    </div>
  </div>

  <?= $this->endSection() ?>