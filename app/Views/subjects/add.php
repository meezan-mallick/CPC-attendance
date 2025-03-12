<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

  <div class="container add-form">
    <?php
    if (!empty($programs)) {
    ?>

      <form action="<?= site_url('subjects/store') ?>" method="POST">
        <div class="header p-4">
          <a class="btn btn-sm btn-warning" href="<?= site_url('subjects') ?>">
            < Back to Subject List</a>
              <div>
                <h2>ADD NEW SUBJECT</h2>
              </div>
              <?php if (session()->getFlashdata('errors')): ?>
                <div style="color: red;">
                  <?= implode('<br>', session()->getFlashdata('errors')); ?>
                </div>
              <?php endif; ?>
              <?php
              if (isset($validation)) { ?>
                <div class="row" style="color: crimson;">
                  <?= $validation->listErrors(); ?>
                </div><?php
                    }
                      ?>
              <button class="submit" type="submit">
                Add
              </button>
        </div>
        <div class="container">
          <hr>
        </div>

        <div class="row">

          <div class="col-md-3 col-12">
            <label For="program_id">Program</label>

            <select class="form-inputs" name="program_id" id="program_id" required onchange="updateSemesters()">
              <option value="">Select Program</option>
              <?php foreach ($programs as $program): ?>
                <option value="<?= esc($program['id']) ?>" data-semesters="<?= esc($program['total_semesters']) ?>">
                  <?= esc($program['program_name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-3 col-12">
            <label>Semester:</label>
            <select class="form-inputs" name="semester_number" id="semester_number" required>
              <option value="">Select Semester</option>
            </select>
          </div>

          <div class="col-md-3 col-12">
            <label For="subject_code">Subject Code</label>

            <input
              class="form-inputs"
              type="text"
              name="subject_code"
              id="subject_code"
              placeholder="Enter Subject Code" />
          </div>

          <div class="col-md-3 col-12">
            <label For="subject_name">Subject Name</label>

            <input
              class="form-inputs"
              type="text"
              name="subject_name"
              id="subject_name"
              placeholder="Enter Subject Name" />
          </div>

        </div>

        <div class="row">
          <div class="col-md-3 col-12">
            <label For="credit">Subject Credit</label>

            <input
              class="form-inputs"
              type="text"
              name="credit"
              id="credit"
              placeholder="Enter Subject Credit" />
          </div>
          <div class="col-md-3 col-12">
            <label For="type">Subject Type</label>

            <select class="form-inputs" name="type" required>
              <option selected value="Theory">Theory</option>
              <option value="Practical">Practical</option>
            </select>
          </div>
          <div class="col-md-3 col-12">
            <label For="internal_marks">Internal Marks</label>
            <input
              class="form-inputs"
              type="number"
              name="internal_marks"
              id="internal_marks"
              placeholder="Enter Subject Internal Marks" />
          </div>
          <div class="col-md-3 col-12">
            <label For="internal_marks">External Marks</label>
            <input
              class="form-inputs"
              type="number"
              name="external_marks"
              id="internal_marks"
              placeholder="Enter Subject External Marks" />
          </div>

        </div>

      </form>
    <?php } else {
    ?>

      <div class="row" style="color: crimson;">
        <h1>No Programs found, Please Add Programs First</h1>
      </div>

    <?php } ?>
  </div>
  <script>
    function updateSemesters() {
      let programDropdown = document.getElementById("program_id");
      let selectedOption = programDropdown.options[programDropdown.selectedIndex];
      let totalSemesters = selectedOption.getAttribute("data-semesters");

      let semesterDropdown = document.getElementById("semester_number");
      semesterDropdown.innerHTML = '<option value="">Select Semester</option>'; // Reset options

      for (let i = 1; i <= totalSemesters; i++) {
        let option = document.createElement("option");
        option.value = i;
        option.textContent = "Semester " + i;
        semesterDropdown.appendChild(option);
      }
    }
  </script>

  <?= $this->endSection() ?>