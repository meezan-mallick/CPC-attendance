<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
  <form class="p-md-3" action="<?= site_url('subjectsallocation/assignstore') ?>" method="POST">
    <div class="header d-flex justify-content-between align-items-center">
      <div>
        <h2>ALLOCATE SUBJECT</h2>
      </div>
      
      <div>
        <a class="btn btn-sm btn-warning" href="<?= site_url('subjectsallocation') ?>">
          < Back to Allocated Subject List</a>
      </div>

    </div>
    <div class="container">
      <hr>
    </div>
    <div id="sub_error" style="color: crimson;">
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
    

    <div class="row pb-4">

      <div class="col-md-3 col-12">
        <label For="faculty_id">Faculty</label>

        <select class="form-inputs" name="faculty_id" id="faculty_id" required>
          <option value="">Select Faculty</option>
          <?php foreach ($faculties as $faculty): ?>
            <option value="<?= esc($faculty['id']) ?>" ">
              <?= esc($faculty['full_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class=" col-md-3 col-12">
              <label For="program_id">Program</label>

              <select class="form-inputs p_change" name="program_id" id="pro_id" required>
               
                <?php foreach ($programs as $program): ?>
                  <option value="<?= esc($program['id']) ?>" data-semesters="<?= esc($program['total_semesters']) ?>">
                    <?= esc($program['program_name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
      </div>

      <div class="col-md-3 col-12">
        <label>Semester</label>
        <select class="form-inputs s_change" name="semester_number" id="sem_id" required>
          <?php foreach ($semesters as $semester): ?>
            <option value="<?= esc($semester['semester_number']) ?>">
              Semester - <?= esc($semester['semester_number']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>



      <div class="col-md-3 col-12">
        <label For="subject_id">Subject</label>

        <select class="form-inputs" name="subject_id" id="sub_change" required>
          <option value="">Select Subject</option>
          <?php foreach ($subjects as $subject): ?>
            <option value="<?= esc($subject['id']) ?>">
              <?= esc($subject['subject_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

    </div>

    <div class="row">
      <button class="submit btn btn-primary w-100" type="submit">
        Allocate
      </button>
    </div>


  </form>
</div>
<script>
  // PHP data as a JavaScript variable
 
    const program = <?php echo json_encode($programs); ?>;
    const semester = <?php echo json_encode(range(1, 10)); ?>;
    const subject = <?php echo json_encode($subjects); ?>;
 

   


    function change_pro() {


        $p_id = $('#pro_id').val();
        $s_id = $('#sem_id').val();

        $("#sem_id").children().remove();

        $arr = [];
        // console.log($p_id);
        $("#sub_change").children().remove();
        subject.forEach(row => {

            if ($p_id == row['program_id']) {
                $arr.push(row['semester_number']);
            }
        });

        $arr = $arr.filter((item, index) => $arr.indexOf(item) === index);

        semester.forEach(row => {
            $k1 = row;
            $arr.forEach(e => {
                $k = e;
                if ($k == $k1) {
                    $("#sem_id").append("<option value=" + $k1 + ">" + $k1 + "</option>");

                }

            });



        });
        console.log($arr);
       
    }


    function change_sem() {
        $p_id = $('#pro_id').val();
        $s_id = $('#sem_id').val();

        // console.log($p_id);
        $("#sub_change").children().remove();
        $("#sub_change").append("<option value='all'> Select Subject </option>");

        subject.forEach(row => {
            if ($p_id == row['program_id'] && $s_id == row['semester_number']) {
                $("#sub_change").append("<option value=" + row['id'] + ">" + row['subject_name'] + "</option>");
            }
        });

        if ($("#sub_change").children().length < 1) {
            $("#sub_error").append("<p>Subjects not Available</p>");
        } else {
            $("#sub_error").html("");
        }
    }

    
    change_pro();
    change_sem();
    $(".s_change").change(function() {
        change_sem();
    });

    $(".p_change").change(function() {
        change_pro();
        change_sem();
    });

   
</script>

<?= $this->endSection() ?>