<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
  <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
  <?php elseif (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="header d-flex justify-content-between align-items-center">
          <h2> Manage Users</h2>
          <a href="users/add" class="add-p">
            <button class="btn btn-primary">Add new</button>
          </a>
        </div>
      </div>
    </div>
    <hr>

    <!-- Manage Users List -->
    <div class="row">
      <div class="table-responsive">
        <table id="dataTable" class="table table-hover table-striped table-bordered">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Designation</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user): ?>
              <tr>
                <td><?= esc($user['id']) ?></td>
                <td class="fw-bold"><?= esc($user['full_name']) ?></td>
                <td><?= esc($user['email']) ?></td>
                <td >
                  <?= esc($user['role']) ?>
                  <!-- <?php if ($user['role'] === 'Faculty'): ?>
                    <a href="<?= site_url('users/assign-coordinator/' . $user['id']) ?>" class="btn btn-sm btn-warning">Make Coordinator</a>
                  <?php endif; ?> -->
                </td>
                <td class="text-center">
                  <?php
                  // Define colors for different designations
                  $designationColors = [
                    'ASSISTANT PROFESSOR' => 'success',
                    'TEACHING ASSISTANT' => 'primary',
                    'TECHNICAL ASSISTANT' => 'warning',
                    'VISITING FACULTY' => 'danger',

                  ];

                  // Get the appropriate badge class
                  $badgeClass = isset($designationColors[$user['designation']]) ? $designationColors[$user['designation']] : 'secondary';
                  ?>
                  <span class="badge p-2 bg-<?= $badgeClass ?>">
                    <?= esc($user['designation']) ?>
                  </span>

                </td>
                <td class="text-center">
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
  </div>
</div>

<?= $this->endSection() ?>