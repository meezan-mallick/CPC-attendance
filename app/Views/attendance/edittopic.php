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


            <div class="col-md-3 col-12">
                <label for="topic">Enter your topic:</label>
                <input
                    class="form-inputs"
                    type="text"
                    name="topic"
                    id="topic"
                    value="<?= esc($topic['topic']) ?>"
                    placeholder="Enter Topic Name" required />

            </div>

            <div class="col-md-3 col-12">
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
                <div class="col-md-3 col-12">

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
                <div class="col-md-3 col-12 mt-4 mt-md-0">
                    <label for="batch">Select Batch</label>
                    <input class="form-inputs" disabled type="number" readonly id="batch" name="batch" value="0">

                    <label for="">(Disabled, Because Its a single batch)</label>

                </div>
            <?php } ?>

            <input type="hidden" id="batch" name="old_batch" value="<?= $topic['batch'] ?>">

            <div class="col-md-3 col-12">
                <label for="time">Select Time slot</label>

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
</script>
<?= $this->endSection() ?>