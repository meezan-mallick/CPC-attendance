<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="m-4">

        <div class=" add-form">
            <form action="<?= base_url('/colleges/update' . $college['id']) ?>" method="Post">
                <div class="header">
                    <a class="btn btn-warning" href="/colleges">Back to Colleges</a>
                    <div>
                        <h2>Update College</h2>

                    </div>
                    <div class="submit-btn">
                        <button class="submit" type="submit">
                            Update
                        </button>
                    </div>
                </div>
                <hr>

                <div class="form-container">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label For="name">College Code</label>

                            <input
                                class="form-inputs"
                                type="text"
                                name="name"
                                id="name"
                                placeholder="Enter College Code"
                                value="<?= $college['college_code'] ?>" />
                        </div>

                        <div class="col-12 col-md-6">
                            <label For="username">College Name</label>

                            <input
                                class="form-inputs"
                                type="text"
                                name="username"
                                id="username"
                                placeholder="Enter College Name"
                                value="<?= $college['college_name'] ?>" />
                        </div>


                    </div>

                    <?php
                    if (isset($validation)) { ?>
                        <div class="row" style="color: crimson;">
                            <?= $validation->listErrors(); ?>
                        </div><?php
                            }
                            if (isset($validationdup)) { ?>
                        <div class="row" style="color: crimson;">
                            <?= $validationdup; ?>
                        </div><?php
                            }
                                ?>

            </form>

        </div>

    </div>
</div>
<?= $this->endSection() ?>