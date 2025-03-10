<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

  <div class="m-4">
    <div class="header">
      <div class="heading">
        <h2>All Time Slots</h2>
      </div>
      <div>

        <a href="time-slots/add" class="add-p">
          <button class="btn btn-primary">Add new</button>
        </a>
      </div>
    </div>
    <hr>
    <div class="table-wrapper data-table">
      <table class="table">
        <thead>
          <tr class="text-center">
            <th>ID</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Actions</th>
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

  <?= $this->endSection() ?>