<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
    <div class="container-fluid">
        <div class="row mt-4 mb-4">
            <div class="col-12">
                <div class="header d-flex justify-content-between align-items-center">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class=" alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <h2>Assign Program to Coordinator</h2>
                    <a href="/coordinators" class="add-p">
                        <button class="btn btn-primary">Back (All program coordinator)</button>
                    </a>
                </div>
            </div>
        </div>
        <hr>

        <!-- Assigned Coordinators List -->
        <div class="row">
            <form action="<?= site_url('coordinators/assign') ?>" method="post">
                <div class="mb-3">
                    <label>Select Coordinator:</label>
                    <select name="user_id" class="form-control" required>
                        <option value="">-- Select Coordinator --</option>
                        <?php foreach ($coordinators as $coordinator): ?>
                            <option value="<?= $coordinator['id'] ?>"><?= $coordinator['full_name'] ?> (<?= $coordinator['email'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Select Programs:</label>
                    <?php if (empty($programs)): ?>
                        <div class="alert alert-info">All programs have been assigned to coordinators. No programs available for assignment.</div>
                    <?php else: ?>
                        <select name="program_ids[]" class="form-control" multiple required>
                            <?php foreach ($programs as $program): ?>
                                <option value="<?= $program['id'] ?>"><?= $program['program_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>

                <?php if (!empty($programs)): ?>
                    <button type="submit" class="btn btn-primary">Assign Programs</button>
                <?php endif; ?>


            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>