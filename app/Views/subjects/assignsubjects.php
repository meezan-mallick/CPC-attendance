<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
  <div class="m-4">
    <div class="header">
      <div class="heading">
        <h2>Allocated Subjects</h2>
      </div>
      <div>
        <a href="subjectsallocation/assign" class="add-p">
          <button class="btn btn-primary">Allocate</button>
        </a>
      </div>
    </div>

    <hr>

    <!-- Filter Section -->
    <div class="row mb-3">
      <div class="col-md-4">
        <label for="program_filter" class="form-label">Filter by Program:</label>
        <select id="program_filter" class="form-select">
          <option value="">All Programs</option>
          <?php if (!empty($programs)) : ?>
            <?php foreach ($programs as $program) : ?>
              <option value="<?= esc($program['id']) ?>"><?= esc($program['program_name']) ?></option>
            <?php endforeach; ?>
          <?php else : ?>
            <option value="">No Assigned Programs</option>
          <?php endif; ?>
        </select>
      </div>

      <div class="col-md-4">
        <label for="semester_filter" class="form-label">Filter by Semester:</label>
        <select id="semester_filter" class="form-select">
          <option value="">All Semesters</option>
          <?php foreach ($semesters as $semester) : ?>
            <option value="<?= esc($semester['semester_number']) ?>">Semester <?= esc($semester['semester_number']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-4">
        <label for="faculty_filter" class="form-label">Filter by Faculty/Coordinator:</label>
        <select id="faculty_filter" class="form-select">
          <option value="">All Faculties & Coordinators</option>
          <?php foreach ($faculties as $faculty) : ?>
            <option value="<?= esc($faculty['full_name']) ?>"><?= esc($faculty['full_name']) ?> (<?= esc($faculty['role']) ?>)</option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <!-- Table Wrapper -->
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

        <tbody id="subject_allocation_table">
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
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $(".form-select").change(function() {
      var program = $("#program_filter").val();
      var semester = $("#semester_filter").val();
      var faculty = $("#faculty_filter").val();

      $.ajax({
        url: "<?= site_url('subjectsallocation/filter') ?>",
        type: "POST",
        data: {
          program: program,
          semester: semester,
          faculty: faculty
        },
        success: function(response) {
          $("#subject_allocation_table").html(response);
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error: ", xhr.responseText);
        }
      });
    });
  });
</script>

<?= $this->endSection() ?>