<?= $this->extend('main') ?>

<?= $this->section('content') ?>

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
        
        
          <div>
              <a href="users/add" class="add-p">
                <button class="btn btn-primary">Add new</button>
              </a>
              <a href="<?= site_url('users/import') ?>"
                                class="btn btn-success">
                                <i class="bi bi-file-earmark-excel"></i> Import Users
                </a>
                <a href="<?= site_url('users/export') ?>"
                                class="btn btn-success">
                                <i class="bi bi-file-earmark-excel"></i> Export Users
                </a>
          </div>
        </div>
      </div>
    </div>
    <hr>

    <div class="row">
      <div class="table-responsive">
        <table id="dataTable" class="table table-hover table-striped table-bordered">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Bank A/C Name</th>
              <th>PAN No.</th>
              <th>Aadhaar No.</th>
              <th>Bank Name</th>
              <th>Bank A/C No.</th>
              <th>IFSC Code</th>
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
                <td><?= esc($user['name_as_per_bank_account'] ?? 'N/A') ?></td>
                <td><?= esc($user['pan_card_no'] ?? 'N/A') ?></td>
                <td><?= esc($user['aadhaar_no'] ?? 'N/A') ?></td>
                <td><?= esc($user['bank_name'] ?? 'N/A') ?></td>
                <td><?= esc($user['bank_account_no'] ?? 'N/A') ?></td>
                <td><?= esc($user['ifsc_code'] ?? 'N/A') ?></td>
                <td >
                  <?= esc($user['role']) ?>
                </td>
                <td class="text-center">
                  <?php
                  $designationColors = [
                    'ASSISTANT PROFESSOR' => 'success',
                    'TEACHING ASSISTANT' => 'primary',
                    'TECHNICAL ASSISTANT' => 'warning',
                    'VISITING FACULTY' => 'danger',
                  ];
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