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
      <form action="<?= base_url('programs/update/' . $program['id']) ?>" method="Post">
        <div class="header">
          <div>
            <h2>Update Program</h2>
          </div>
          <div class="submit-btn">
            <button class="submit" type="submit">
              Update
            </button>
          </div>
        </div>

        <!-- {/* PERSONAL DETAILS */} -->
        <!-- {/* PROGRAM DETAILS */} -->
        <fieldset>
          <legend>Program Details</legend>
          <div class="form-container">
            <div class="row">
              <div>
                <label>College Code:</label>
                <select class="form-inputs" name="college_code" required>
                  <option value="">Select College</option>
                  <?php foreach ($colleges as $college): ?>
                    <option value="<?= esc($college['college_code']) ?>"
                      <?= ($college['college_code'] == $program['college_code']) ? 'selected' : '' ?>>
                      <?= esc($college['college_code']) ?> - <?= esc($college['college_name']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>

              </div>
              <div>

                <label for="productname">Program Name</label>

                <input
                  class="form-inputs"
                  type="text"
                  name="program_name"
                  id="program_name"
                  value="<?= $program['program_name'] ?>"
                  placeholder="Enter Program Name" />
              </div>
              <div>
                <label>Program Duration:</label>
                <select class="form-inputs" value="<?= $program['program_duration'] ?>" name="program_duration" required>
                  <option value="2 Years">2 Years</option>
                  <option value="5 Years">5 Years</option>
                </select>
              </div>
              <div>
                <label>Program Type:</label>
                <select class="form-inputs" value="<?= $program['program_type'] ?>" name="program_type" required onchange="setSemesters()" required>
                  <option value="1">Integrated</option>
                  <option value="0">Masters</option>
                </select>
              </div>


            </div>

            <div class="row">
              <div>
                <label>Total Semesters:</label>
                <input class="form-inputs" type="number" value="<?= $program['total_semesters'] ?>" id="total_semesters_display" readonly>
                <input type="hidden" value="<?= $program['program_type'] ?>" name="total_semesters" id="total_semesters">
              </div>
            </div>

            <?php if (session()->getFlashdata('errors')): ?>
              <div style="color: red;">
                <?= implode('<br>', session()->getFlashdata('errors')); ?>
              </div>
            <?php endif; ?>
        </fieldset>

      </form>

    </div>


  </div>

  </div>

  <script>
    function setSemesters() {
      let type = document.querySelector("select[name='program_type']").value;
      let semesterCount = type == "1" ? 10 : 4;

      // Display in read-only field
      document.getElementById("total_semesters_display").value = semesterCount;

      // Store in hidden input for form submission
      document.getElementById("total_semesters").value = semesterCount;
    }
  </script>

</body>

</html>