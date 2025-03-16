<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <form action="/attendance-report/export" method="POST">
        <div class="m-4">
            <div class="header">
                <div class="heading">
                    <h2>Attendance Report</h2>
                </div>
                <div>

                    <button class="btn btn-success">
                        <i class="bi bi-file-earmark-excel"></i> Export Attendance Report
                    </button>
                </div>
            </div>
            <hr>

            <div class="row">


                <div class="col-md-3 col-12 mb-3">
                    <label>College:</label>
                    <select name="college_code" id="college_code" class="form-inputs c_change">
                        <?php
                        foreach ($college as $row) {

                            echo "<option  value=" . $row['college_code'] . ">" . $row['college_name'] . "</option>";
                        } ?>
                    </select>
                </div>



                <div class="col-md-3 col-12 mb-3">
                    <label>Program</label>
                    <select name="program_id" id="pro_id" class="form-inputs p_change">
                        <?php
                        foreach ($program as $row) {

                            echo "<option  value=" . $row['id'] . ">" . $row['program_name'] . "</option>";
                        } ?>
                    </select>
                </div>

                <div class="col-md-3 col-12 mb-3">
                    <label>Semester</label>
                    <select name="semester_number" id="sem_id" class="form-inputs s_change">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>



                <div class="col-md-3 col-12 mb-3">
                    <label>Subject</label>
                    <select name="subject_id" id="sub_change" class="form-inputs">
                        <option value="all">Select Subject</option>

                        <?php
                        foreach ($subject as $row) {
                            echo "<option value=" . $row['id'] . ">" . $row['subject_name'] . "</option>";
                        } ?>
                    </select>
                </div>

                <div class="col-md-3 col-12 mb-3">
                    <label id="batch-l">Batch</label>
                    <select name="batch" id="batch" class="form-inputs">
                        <option value="all">Select Batch</option>
                    </select>
                </div>

            </div>
    </form>
</div>

<script>
    // PHP data as a JavaScript variable
    const college = <?php echo json_encode($college); ?>;
    const program = <?php echo json_encode($program); ?>;
    const semester = <?php echo json_encode(range(1, 10)); ?>;
    const subject = <?php echo json_encode($subject); ?>;
    const batch = <?php echo json_encode($batch); ?>;
    // Check the data in the browser console


    function change_college() {
        $c_id = $('#college_code').val();
        $p_id = $('#pro_id').val();
        $s_id = $('#sem_id').val();

        $count = 0;
        $flag = false;
        $("#pro_id").children().remove();

        program.forEach(row => {

            if ($c_id == row['college_code']) {
                $("#pro_id").append("<option value=" + row['id'] + ">" + row['program_name'] + "</option>");

            }
        });




    }

    function change_batch() {
        $p_id = $('#pro_id').val();
        $s_id = $('#sem_id').val();

        $count = 0;
        $flag = false;
        $("#batch").children().remove();
        $("#batch").append("<option value='all'>Select Batch</option>");

        batch.forEach(row => {

            if ($p_id == row['program_id'] && $s_id == row['semester']) {
                $("#batch").append("<option value=" + row['batch'] + ">" + row['batch'] + "</option>");
                if (row['batch'] == 0) {
                    $count++;
                    $flag = true;
                }
            }
        });
        if ($flag) {
            $("#batch").hide();
            $("#batch-l").hide();
        } else {
            $("#batch").show();
            $("#batch-l").show();
        }
    }

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
        change_batch();

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

    change_college();
    change_pro();
    change_sem();
    $(".s_change").change(function() {
        change_sem();
    });

    $(".p_change").change(function() {
        change_pro();
        change_sem();
    });

    $(".c_change").change(function() {
        change_college();
        change_pro();
        change_sem();
    });
</script>
<?= $this->endSection() ?>