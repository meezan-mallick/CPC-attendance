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

    <form class="p-3" action="<?= site_url('topics-list/store/' . $program_id . '/' . $semester_number . '/' . $subject_id) ?>" method="POST">



        <!-- Mobile VIEW -->
        <div class="header d-block d-lg-none ">
            <a class="btn btn-sm btn-warning" href="<?= site_url('faculty-subjects') ?>">
                < Back to Program List</a>
                    <div class="mt-5 mb-4 text-center">
                        <h1>ADD NEW TOPIC</h1>
                    </div>
                    <div>
                        <button class="btn btn-md btn-dark w-100 mb-2 p-2" type="submit">
                            Add new topic
                        </button>
                        <a href="<?= site_url('attendance/export-topics/' . $program_id . '/' . $semester_number . '/' . $subject_id) ?>"
                            class="btn btn-success w-100 p-2">
                            <i class="bi bi-file-earmark-excel"></i> Export Topics to Excel
                        </a>
                    </div>
        </div>

        <!-- Desktop VIEW -->
        <div class="header d-lg-flex d-none justify-content-between align-items-center">
            <a class="btn btn-sm btn-warning" href="<?= site_url('faculty-subjects') ?>">
                < Back to Program List</a>
                    <div>
                        <h2>ADD NEW TOPIC</h2>
                    </div>
                    <div>
                        <button class="btn btn-md btn-dark" type="submit">
                            Add new topic
                        </button>
                        <a href="<?= site_url('attendance/export-topics/' . $program_id . '/' . $semester_number . '/' . $subject_id) ?>"
                            class="btn btn-success">
                            <i class="bi bi-file-earmark-excel"></i> Export Topics to Excel
                        </a>
                    </div>




        </div>






        <div class="container">
            <hr>
        </div>

        <div class="row">
            <!-- TOPIC NAME -->
            <div class="col-md-3 col-12 mt-4 mt-md-0">
                <label for="topic">Enter Topic</label>
                <input
                    class="form-inputs"
                    type="text"
                    name="topic"
                    id="topic"
                    placeholder="Enter Topic Name" required />
            </div>

            <!-- DATE -->
            <div class="col-md-3 col-12 mt-4 mt-md-0">
                <label for="date">Enter Date</label>
                <input
                    class="form-inputs"
                    type="date"
                    name="date"
                    id="date"
                    required />
            </div>

            <!-- BATCH -->
            <?php
            if ($flag) {
            ?>
                <div class="col-md-3 col-12 mt-4 mt-md-0">
                    <label for="batch">Select Batch</label>
                    <select class="form-inputs" name="batch" required>
                        <?php foreach ($batches as $key) {
                            foreach ($key as $k) {
                        ?>
                                <option value="<?= $k ?>">Batch - <?= $k ?></option>
                        <?php
                            }
                        } ?>

                    </select>
                </div>

            <?php } else { ?>
                <div class="col-md-3 col-12 mt-4 mt-md-0">
                    <label for="batch">Select Batch</label>
                    <input class="form-inputs" type="number" readonly id="batch" name="batch" value="0">

                    <label for="">(Disabled, Because Its a single batch)</label>

                </div>
            <?php } ?>

            <!-- TIME SLOT -->
            <div class="col-md-3 col-12 mt-4 mt-md-0">
                <label for="time">Select Time Slot</label>
                <select class="form-inputs" name="time" required>
                    <?php foreach ($timeslot as $t) {
                    ?>
                        <option value="<?= $t['start_time'] . ' - ' . $t['end_time'] ?>"><?= $t['start_time'] . ' - ' . $t['end_time'] ?></option>

                    <?php
                    }
                    ?>

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
        <hr>

        <!-- TOPICS TABLE -->
        <div class="row">
            <div class="table-responsive">
                <table id="dataTable" class="table table-hover table-striped table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>TOPIC</th>
                            <th>DATE</th>
                            <th>TIME</th>
                            <?php if ($flag == true) {
                                echo "<th>BATCH</th>";
                            } ?>
                            <th>ATTENDANCE</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($topics as $t) : ?>
                            <tr class="attendance-hover">
                                <td><?= esc($t['id']) ?></td>
                                <td class="text-center"><?= esc($t['topic']) ?></td>
                                <td class="text-center"><?= esc($t['date']) ?></td>
                                <td class="text-center"><?= esc($t['time']) ?></td>
                                <?php if ($flag == true) { ?><td class="text-center"><?= esc($t['batch']) ?></td><?php } ?>
                                <?php if ($t['total_present'] == '-') { ?>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-success" href="<?= site_url('attendance/' . $program_id . '/' . $semester_number . '/' . $subject_id . '/' . $t['id'] . '/' . $t['batch']) ?>">Take Attendance</a>
                                    </td>
                                <?php } else { ?>
                                    <td class="text-center ">
                                        <span class="attendance-data"><?= esc($t['total_present']) ?>/<?= esc($t['total_stud']) ?></span>
                                        <a class="btn btn-sm btn-warning attendance-edit" href="<?= site_url('attendance/' . $program_id . '/' . $semester_number . '/' . $subject_id . '/' . $t['id'] . '/' . $t['batch']) ?>">Edit Attendance</a>

                                    </td>
                                <?php } ?>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-warning" href="<?= site_url('topics-list/edit/' . $program_id . '/' . $semester_number . '/' . $subject_id . '/' . $t['id'])  ?>">Edit</a> |
                                    <a class="btn btn-sm btn-danger" href="<?= site_url('topics-list/delete/' . $program_id . '/' . $semester_number . '/' . $subject_id . '/' . $t['id']) ?>" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </form>

</div>
<script>
    const today = new Date().toISOString().split('T')[0];
    // Set the value of the input field with id 'date'
    $('#date').val(today);
</script>
<?= $this->endSection() ?>