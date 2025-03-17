<?= $this->extend('main') ?>

<?= $this->section('content') ?>



<?php
$start_date = $start_date == "" ? 0 : $start_date;
$end_date = $end_date == "" ? 0 : $end_date;
?>
<!-- Page Content -->
<div id="content">

  <!-- Filter Form -->
  <div class="p-3">
    <form method="get" action="<?= site_url('payment-voucher') ?>">
      <div class="mb-4">
        <h2 class="text-left">Export Payment Voucher </h2>
      </div>

      <div class="row">
        <div class="col-md-5">
          <label>Start Date:</label>
          <input type="date" class="form-inputs" name="start_date" id="start_date" value="<?= $start_date ?>" onchange="this.form.submit()">

        </div>
        <div class="col-md-5">
          <label>End Date:</label>
          <input type="date" class="form-inputs" name="end_date" id="end_date" value="<?= $end_date ?>" max="<?= date('Y-m-d'); ?>" onchange="this.form.submit()">

        </div>
        <div class="col-md-2 ">
          <button class="btn btn-primary w-100 mb-1" type="submit">Filter</button>

          <a class="btn btn-warning w-100" href="<?= site_url('payment-voucher') ?>">Reset</a>
        </div>
      </div>

    </form>

    <hr>

    <div class="row">
      <div class="table-responsive">
        <table id="dataTable" class="table table-hover table-striped table-bordered text-center">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Program</th>
              <th>Subject</th>
              <th>Semester</th>
              <th>Batch</th>
              <th>Total Lectures</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($lectures as $fac) : ?>
              <tr>
                <td><?= esc($fac['id']) ?></td>
                <td><?= esc($fac['program_name']) ?></td>
                <td><?= esc($fac['subject_name']) ?></td>
                <td><?= esc($fac['semester_number']) ?></td>
                <td><?= esc($fac['batch']) ?></td>
                <td><?= esc($fac['total_lectures']) ?></td>

                <td>
                  <a class="btn btn-sm btn-success" href="<?= site_url('payment-voucher/export/' . $fac['program_id'] . '/' .  $fac['semester_number'] . '/' .  $fac['subject_id'] . '/' .  $fac['batch'] . '/' .  $start_date . '/' .  $end_date) ?>">Export</a>
                </td>
              </tr>
            <?php endforeach; ?>

          </tbody>
        </table>
      </div>
    </div>


  </div>

</div>

<?= $this->endSection() ?>