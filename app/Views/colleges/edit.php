<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
    <div id="user-add" class="container-fluid">
        <!-- Add new user -->
        <div class="row">
            <form action="<?= base_url('/colleges/update/' . $college['id']) ?>" method="POST">
                <div class="row mt-2 mb-4">
                    <div class="col-12">
                        <div class="header d-flex justify-content-between align-items-center">
                            <h2>Update College</h2>
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
                            placeholder="Enter College Code"
                            value="<?= $college['college_code'] ?>" />
                    </div>

                    <div class="col-md-6 col-12">
                        <label For="username">College Name</label>

                        <input
                            class="form-inputs"
                            type="text"
                            name="college_name"
                            id="username"
                            placeholder="Enter College Name"
                            value="<?= $college['college_name'] ?>" />
                    </div>
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



                <input type="submit" class="btn w-100 btn-primary px-3 py-2" value="UPDATE COLLEGE" />

            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>