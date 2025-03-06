<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta charset="ISO-8859-1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="/assets/css/dashboard.css">

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>

  <?php include APPPATH . 'Views/navbar.php'; ?>


  <div class="main-wrapper">
    <?php include APPPATH . 'Views/header.php'; ?>



    <div class="container add-form">

      <?php

      if (!empty($programs)) {

      ?>
        <a href="<?= site_url('subjects') ?>" style="display: inline-block;margin-left:40px; padding: 8px 12px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
          ← Back to Subjects List
        </a>
        <form action="<?= site_url('subjects/update/' . $subject['id']) ?>" method="post">
          <div class="header">


            <div>
              <h2>Update Subject</h2>
            </div>
            <?php if (session()->getFlashdata('errors')): ?>
              <div style="color: red;">
                <?= implode('<br>', session()->getFlashdata('errors')); ?>
              </div>
            <?php endif; ?>
            <div class="submit-btn">
              <button class="submit" type="submit">
                Update
              </button>
            </div>
          </div>

          <!-- {/*Add Subject DETAILS */} -->
          <fieldset>
            <legend>Subject Details</legend>
            <div class="form-container">
              <div class="row">

                <div>
                  <label For="program_id">Program</label>

                  <select class="form-inputs" name="program_id" id="program_id" required onchange="updateSemesters()">
                    <option value="">Select Program</option>
                    <?php foreach ($programs as $program): ?>
                      <option value="<?= esc($program['id']) ?>"
                        data-semesters="<?= esc($program['total_semesters']) ?>"
                        <?= ($program['id'] == $subject['program_id']) ? 'selected' : '' ?>>
                        <?= esc($program['program_name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div>
                  <label>Semester:</label>
                  <select class="form-inputs" name="semester_number" id="semester_number" required>
                    <option value="">Select Semester</option>
                  </select>
                </div>

                <div>
                  <label For="subject_code">Subject Code</label>

                  <input
                    class="form-inputs"
                    type="text"
                    name="subject_code"
                    id="subject_code"
                    value="<?= esc($subject['subject_code']) ?>"
                    required
                    placeholder="Enter Subject Code" />
                </div>
                <div>
                  <label For="subject_name">Subject Name</label>

                  <input
                    class="form-inputs"
                    type="text"
                    name="subject_name"
                    id="subject_name"
                    value="<?= esc($subject['subject_name']) ?>"
                    required
                    placeholder="Enter Subject Name" />
                </div>
              </div>
              <div class="row">
                <div>
                  <label For="credit">Subject Credit</label>

                  <input
                    class="form-inputs"
                    type="text"
                    name="credit"
                    id="credit"
                    value="<?= esc($subject['credit']) ?>"
                    required
                    placeholder="Enter Subject Credit" />
                </div>
                <div>
                  <label For="type">Subject Type</label>

                  <select class="form-inputs" name="type" required>
                    <option value="Theory" <?= ($subject['type'] == 'Theory') ? 'selected' : '' ?>>Theory</option>
                    <option value="Practical" <?= ($subject['type'] == 'Practical') ? 'selected' : '' ?>>Practical</option>
                  </select>
                </div>
                <div>
                  <label For="internal_marks">Internal Marks</label>
                  <input
                    class="form-inputs"
                    type="number"
                    name="internal_marks"
                    id="internal_marks"
                    value="<?= esc($subject['internal_marks']) ?>"
                    required
                    placeholder="Enter Subject Internal Marks" />
                </div>
                <div>
                  <label For="internal_marks">External Marks</label>
                  <input
                    class="form-inputs"
                    type="number"
                    name="external_marks"
                    id="internal_marks"
                    value="<?= esc($subject['external_marks']) ?>"
                    required
                    placeholder="Enter Subject External Marks" />
                </div>
              </div>

              <?php
              if (isset($validation)) { ?>
                <div class="row" style="color: crimson;">
                  <?= $validation->listErrors(); ?>
                </div><?php
                    }
                      ?>
          </fieldset>

        </form>
      <?php } else {
      ?>

        <div class="row" style="color: crimson;">
          <h1>Please Add Programs</h1>
        </div>

      <?php } ?>
    </div>



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

      // Set previously selected semester
      let currentSemester = "<?= esc($subject['semester_number']) ?>";
      semesterDropdown.value = currentSemester;
    }

    // Run this function when the page loads to set the correct semester
    window.onload = updateSemesters;
  </script>

</body>

</html>