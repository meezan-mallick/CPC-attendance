<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
    <div id="user-add" class="container-fluid">
        <!-- Add new user -->
        <div class="row">
            <div class="table-responsive">

                <form action="<?= site_url('/colleges/store') ?>" method="POST">
                    <div class="row mt-2 mb-4">
                        <div class="col-12">
                            <div class="header d-flex justify-content-between align-items-center">
                                <h2>ADD NEW COLLEGE</h2>
                                <a class="btn btn-sm btn-warning" href="<?= site_url('colleges') ?>">
                                    < Back to College List</a>

                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <hr>
                    </div>

                    <div class="row pb-md-3">
                        <div class="col-md-6 col-12">
                            <label For="name">College Code</label>

                            <input
                                class="form-inputs"
                                type="text"
                                name="college_code"
                                id="name"
                                placeholder="Enter College Code" />
                        </div>

                        <div class="col-md-6 col-12">
                            <label For="username">College Name</label>

                            <input
                                class="form-inputs"
                                type="text"
                                name="college_name"
                                id="username"
                                placeholder="Enter College Name" />
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <?php
                                if (isset($validation)) { ?>
                                    <div class="row" style="color: crimson;">
                                        <?= $validation->listErrors(); ?>
                                    </div><?php
                                        }
                                            ?>
                            </div>

                        </div>
                    </div>


                    <a href="<?= site_url('coordinators/assign') ?>" class="add-p">
                        <button class="btn w-100 btn-primary px-3 py-2">ADD </button>
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>