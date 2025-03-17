<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
  <form class="p-3" action="<?= base_url('subjectsallocation/update/' . $allocatesubject['id']) ?>" method="POST">
    <div class="header d-flex justify-content-between align-items-center">

      <div>
        <h2>EDIT ALLOCATION</h2>
      </div>
      <div class="row" id="sub_error" style="color: crimson;">
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
      </div>
      <div>
        <a class="btn btn-sm btn-warning" href="<?= site_url('subjectsallocation') ?>">
          < Back to Allocated Subject List</a>
      </div>
    </div>
    <div class="container">
      <hr>
    </div>

    <div class="row pb-4">

      <div class="col-md-3 col-12">
        <label for="faculty">Select Faculty/Coordinator:</label>
        <select class="form-control" name="faculty_id" id="faculty">
          <option value="">-- Select Faculty --</option>
          <?php foreach ($faculties as $faculty) : ?>
            <option value="<?= esc($faculty['id']) ?>"
              <?= ($faculty['id'] == $selected_faculty) ? 'selected' : '' ?>>
              <?= esc($faculty['full_name']) ?> (<?= esc($faculty['role']) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class=" col-md-3 col-12">
        <label For="program_id" for="program_id">Program </label>
        <label For="program_id">Program</label>

        <select class="form-inputs p_change" name="program_id" id="program_id" required>
          <option value="">Select Program</option>
          <?php foreach ($programs as $program):
            if ($program['id'] == $allocatesubject['program_id']) { ?>
              <option selected value="<?= esc($program['id']) ?>" data-semesters="<?= esc($program['total_semesters']) ?>"><?= esc($program['program_name']) ?></option>

            <?php } else { ?>
              <option value="<?= esc($program['id']) ?>" data-semesters="<?= esc($program['total_semesters']) ?>"><?= esc($program['program_name']) ?></option>

          <?php }
          endforeach; ?>
        </select>
      </div>

      <div class="col-md-3 col-12">
        <label>Semester </label>
        <select class="form-inputs s_change" name="semester_number" id="semester_number" required>
          <!-- <option value="">Select Semester</option> -->
          <?php foreach ($semesters as $semester): ?>
            <option value="<?= esc($semester['semester_number']) ?>">
              Semester - <?= esc($semester['semester_number']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3 col-12">
        <label for="subject_id">Subject</label>
        <select class="form-inputs" name="subject_id" id="subject_id" required>
          <!-- <option value="">Select Subject</option> -->
          <?php foreach ($subjects as $subject): ?>
            <option value="<?= esc($subject['id']) ?>"
              <?= (isset($selected_subject) && $selected_subject == $subject['id']) ? 'selected' : '' ?>>
              <?= esc($subject['subject_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>

      </div>

    </div>

    <div class="row">
      <button class="submit btn btn-primary w-100" type="submit">
        Update
      </button>
    </div>


  </form>
</div>
<script>
  // PHP data as a JavaScript variable
  const program = <?php echo json_encode($programs); ?>;
  const semester = <?php echo json_encode($semesters); ?>;
  const subject = <?php echo json_encode($subjects); ?>;
  const allocatesubject = <?php echo json_encode($allocatesubject); ?>;

  // Check the data in the browser console

  $("#semester_number").children().not(':first-child').remove();

  $("#subject_id").children().not(':first-child').remove();

  console.log(subject);

  function change_pro() {


    $p_id = $('#program_id').val();
    $s_id = $('#semester_number').val();
    if ($p_id != "") {
      $("#semester_number").children().not(':first-child').remove();

      $arr = [];
      // console.log($p_id);
      $("#subject_id").children().not(':first-child').remove();
      subject.forEach(row => {

        if ($p_id == row['program_id']) {
          $arr.push(row['semester_number']);
        }
      });

      $arr = $arr.filter((item, index) => $arr.indexOf(item) === index);

      semester.forEach(row => {
        $k1 = row['semester_number'];
        $arr.forEach(e => {
          $k = e;
          if ($k == $k1) {
            $("#semester_number").append("<option value=" + row['semester_number'] + ">Semester - " + row['semester_number'] + "</option>");

          }

        });



      });
      console.log($arr);
    }

  }


  function change_sem() {
    $p_id = $('#program_id').val();
    $s_id = $('#semester_number').val();

    if ($p_id != "" && $s_id != "") {
      // console.log($p_id);
      $("#subject_id").children().not(':first-child').remove();
      subject.forEach(row => {

        if ($p_id == row['program_id'] && $s_id == row['semester_number']) {
          $("#subject_id").append("<option value=" + row['id'] + ">" + row['subject_name'] + "</option>");
          console.log(row);
        }

      });

      if ($("#subject_id").children().length < 1) {
        $("#sub_error").append("<p>Subjects not Available</p>");
      } else {
        $("#sub_error").html("");
      }
    }
  }


  change_pro();
  $("#semester_number").val(allocatesubject['semester_number']);
  change_sem();
  $("#subject_id").val(allocatesubject['subject_id']);
  $(".s_change").change(function() {
    change_sem();
  });

  $(".p_change").change(function() {
    change_pro();
    change_sem();
  });
</script>

<?= $this->endSection() ?>