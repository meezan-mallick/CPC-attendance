<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

  <div class="m-4">
    <div class="header">
      <div class="heading">
        <h2>Manage Users</h2>
      </div>

      <div>

        <a href="users/add" class="add-p">
          <button class="btn btn-primary">Add new</button>
        </a>

        <a href="<?= site_url('users/export') ?>" class="btn btn-success">
          <i class="bi bi-file-earmark-excel"></i> Export to Excel
        </a>

      </div>
    </div>
    <hr>


    <div class="table-wrapper data-table">
      <table>
        <thead>

          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?= esc($user['id']) ?></td>
              <td><?= esc($user['full_name']) ?></td>
              <td><?= esc($user['email']) ?></td>
              <td>
                <?= esc($user['role']) ?>
                <?php if ($user['role'] === 'Faculty'): ?>
                  <a href="<?= site_url('users/assign-coordinator/' . $user['id']) ?>" class="btn btn-sm btn-warning">Make Coordinator</a>
                <?php endif; ?>
              </td>
              <td>
                <a href="<?= site_url('users/edit/' . $user['id']) ?>" class="btn btn-sm btn-primary">
                  Edit
                </a>
                <a href="<?= site_url('users/delete/' . $user['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>

        </tbody>
      </table>
    </div>
  </div>

  <?= $this->endSection() ?>