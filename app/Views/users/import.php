<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
    <div class="container">

        <div class="row mt-2 mb-4">
                            <div class="col-12">
                                <div class="header d-flex justify-content-between align-items-center">
                                    <h2>IMPORT USERS</h2>
                                   
                                </div>
                            </div>
        </div>

         
            <div class="mb-3">
                <a href="<?= site_url('users') ?>" class="btn btn-warning">🔙 Back to Users List</a>
                <a href="<?= site_url('users/download-sample') ?>" class="btn btn-success">⬇ Download Sample Excel</a>
                <a href="<?= site_url('users/add') ?>"
                    class="btn btn-info">
                    <i class="bi bi-plus-lg"></i> Add Single User
                </a>


            </div>

        </div>
        <!-- Display Success/Error Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if ($errors = session()->getFlashdata('error_import')) { ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error_import') ?></div>
        <?php } ?>

       
        <div class="container m-10">
            <hr>
        </div>

      







        <div class="mt-3">
            <form action="<?= site_url('users/import-store') ?>" method="post" enctype="multipart/form-data">
                <label>Import Users from Excel:</label>
                <input type="file" name="user_file" class="form-control" required>
                <button type="submit" class="btn btn-primary mt-2">📤 Upload & Import</button>
            </form>
        </div>
    </div>
</div>


<?= $this->endSection() ?>