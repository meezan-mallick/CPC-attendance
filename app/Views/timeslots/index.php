<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">

  <div class="p-3">
    <div class="header">
      <div class="heading d-flex justify-content-between align-items-center">
        <h2>All Time Slots</h2>
        <a href="time-slots/add" class="add-p">
          <button class="btn btn-primary">Add new</button>
        </a>
      </div>

    </div>
    <hr>
    <div class="row">
      <div class="table-responsive">
        <table id="dataTable" class="table table-hover table-striped table-bordered text-center">
          <thead class="table-dark text-center">
            <tr class="text-center">
              <th class="text-center">ID</th>
              <th class="text-center">Start Time</th>
              <th class="text-center">End Time</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($timeslot as $ts) : ?>
              <tr>
                <td><?= esc($ts['id']) ?></td>
                <td class="text-center"><?= esc($ts['start_time']) ?></td>
                <td class=" text-left"><?= esc($ts['end_time']) ?></td>
                <td class="text-center">
                  <a class="btn btn-sm btn-warning" href="<?= site_url('time-slots/edit/' . $ts['id']) ?>">Edit</a> |
                  <a class="btn btn-sm btn-danger" href="<?= site_url('time-slots/delete/' . $ts['id']) ?>" onclick="return confirm('Are you sure?')">Delete</a>
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