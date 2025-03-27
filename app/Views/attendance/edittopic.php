<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<?php
$z = false;
$flag = true;
foreach ($batches as $key) {
    foreach ($key as $k) {
        if ($k == 0) {
            $z = true;
        }
    }
}
if (count($batches) == 1 && $z == true) {
    $flag = false;
}



$times = explode(" - ", $topic['time']); // Split by " - "
$startTime = $times[0]; // "08:30:00"
$endTime = $times[1];  


?>
<div id="content">

    <form class="p-3" action="<?= site_url('topics-list/update/' . $program_id . '/' . $semester_number . '/' . $subject_id . '/' . $topic['id']) ?>" method="POST">


        <div class="header d-flex justify-content-between align-items-center">
            <h2>EDIT TOPIC</h2>
            <a class="btn btn-sm btn-warning" href="<?= site_url('topics-list/' . $program_id . '/' . $semester_number . '/' . $subject_id) ?>">
                < Back to Topic List</a>



        </div>



        <div class="container">
            <hr>
        </div>

        <div class="row">


            <div class="col-md-4 col-12">
                <label for="topic">Enter your topic:</label>
                <input
                    class="form-inputs"
                    type="text"
                    name="topic"
                    id="topic"
                    value="<?= esc($topic['topic']) ?>"
                    placeholder="Enter Topic Name" required />

            </div>

            <div class="col-md-4 col-12">
                <label for="data">Enter Date:</label>
                <input
                    class="form-inputs"
                    type="date"
                    name="date"
                    id="date"
                    value="<?= esc($topic['date']) ?>"
                    required />
            </div>




            <?php
            if ($flag) {
            ?>
                <div class="col-md-4 col-12">

                    <label for="batch">Select Batch</label>
                   
                    <select class="form-inputs" name="batch" required>
                        <?php foreach ($batches as $key) {
                            foreach ($key as $k) {
                                if ($k == $topic['batch']) {
                        ?>
                                    <option value="<?= $k ?>" selected>Batch - <?= $k ?></option>
                                <?php } else { ?>
                                    <option value="<?= $k ?>">Batch - <?= $k ?></option>

                        <?php }
                            }
                        } ?>

                    </select>
                </div>

            <?php } else { ?>
                <div class="col-md-4 col-12 mt-4 mt-md-0">
                    <label for="batch">Select Batch</label>
                    <input class="form-inputs" disabled type="number" readonly id="batch" name="batch" value="0">

                    <label for="">(Disabled, Because Its a single batch)</label>

                </div>
            <?php } ?>

            <input type="hidden" id="batch" name="old_batch" value="<?= $topic['batch'] ?>">

            </div>

            <div class="row mt-4">

                <input type="hidden" name="custom_time" id="custom_time" value="">
       
              
                <div class="col-md-4 col-12 default-time" >
                        <label for="time" class="d-flex align-items-center">
                            Select Time Slot 
                            <span class="ms-3">
                                <button class="btn btn-dark px-3 py-1 custom-btn" type="button" style="height: 100%; font-size: inherit; line-height: 1.2;">Custom</button>
                            </span>
                        </label>

                    <select class="form-inputs" name="time" required>
                        <?php foreach ($timeslot as $t) {
                            $time_t = $t['start_time'] . ' - ' . $t['end_time'];
                            if ($time_t == $topic['time']) {
                        ?>

                                <option selected value="<?= $t['start_time'] . ' - ' . $t['end_time'] ?>"><?= $t['start_time'] . ' - ' . $t['end_time'] ?></option>

                            <?php
                            } else {
                            ?>
                                <option value="<?= $t['start_time'] . ' - ' . $t['end_time'] ?>"><?= $t['start_time'] . ' - ' . $t['end_time'] ?></option>



                        <?php }
                        } ?>
                    </select>
                </div>

             

                <div class="col-12 mt-4 mt-md-0 custom-time" >
                    <label for="time" class="d-flex align-items-center mb-2">
                        Custom Time Slot 
                        <span class="ms-3">
                            <button class="btn btn-dark px-3 py-1 default-btn" type="button" style="height: 100%; font-size: inherit; line-height: 1.2;">Default</button>
                        </span>
                           </label>

                    <div class="row">
                        <div class="col-md-6 col-12 mb-3">
                            <label For="start_time">Starting Time</label>

                            <input
                                class="form-control"
                                type="time"
                                name="start_time"
                                id="start_time"
                                placeholder="Enter Starting Time"  value="<?= esc($startTime) ?>" required />
                        </div>

                        <div class="col-md-6 col-12">
                            <label For="end_time">Ending Time</label>

                            <input
                                class="form-control"
                                type="time"
                                name="end_time"
                                id="end_time"
                                placeholder="Enter Ending Time"  value="<?= esc($endTime) ?>" required />
                        </div>

                    </div>
                </div>
               




         </div>

        <div class="row">

            <?php if (session()->getFlashdata('errors')): ?>
                <div style="color: red;">
                    <?= implode('<br>', session()->getFlashdata('errors')); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="row mt-4">
            <button class="submit btn btn-primary w-100" type="submit">
                UPDATE TOPIC
            </button>
        </div>



    </form>

</div>
<script>
    const today = new Date().toISOString().split('T')[0];
    // Set the value of the input field with id 'date'
    $('#date').val(today);
    
    $("#start_time").prop("required", $(".custome-time").is(":visible")); // Add required only when visible
    $("#end_time").prop("required", $(".custome-time").is(":visible")); // Add required only when visible
   
    const topictime = <?php echo json_encode($topic['time']); ?>;
    console.log(topictime);
   

    const timeslots = <?php echo json_encode($timeslot); ?>;

    var times = topictime.split(" - ");
    // Extract start and end times
    var startTime = times[0]; // "08:30:00"
    var endTime = times[1]; 


    var custom_time_flag=false;
    timeslots.forEach(t => {
        let time_t = t.start_time + " - " + t.end_time; 
        if (time_t === topictime) {
            custom_time_flag = true;
           
        }
    });

    if(custom_time_flag==true)
    {
        $('#start_time').val('');
            $('#end_time').val('');
            $('#custom_time').val(false);
            $(".default-time").css("display", "inline-block");
            $(".custom-time").css("display", "none");

    }
    else{
        $(".custom-time").css("display", "inline-block");
             $(".default-time").css("display", "none");

             $('#start_time').val(startTime);
             $('#end_time').val(endTime);
            $('#custom_time').val(true);

    }

   

    
        $(".custom-btn").click(function () {
            $(".custom-time").css("display", "inline-block");
             $(".default-time").css("display", "none");

             $('#start_time').val(startTime);
             $('#end_time').val(endTime);
            $('#custom_time').val(true);

            // Show or hide on button click
        });

        $(".default-btn").click(function () {
            $('#start_time').val('');
            $('#end_time').val('');
            $('#custom_time').val(false);
            $(".default-time").css("display", "inline-block");
            $(".custom-time").css("display", "none");
                // Show or hide on button click
        });
</script>
<?= $this->endSection() ?>