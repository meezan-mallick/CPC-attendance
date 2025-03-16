<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="header d-flex justify-content-between align-items-center">
                    <h2>Coordinators and their Assigned Programs</h2>
                    <a href="<?= site_url('coordinators/assign') ?>" class="add-p">
                        <button class="btn btn-primary px-3 py-2">Assign Program to Coordinator</button>
                    </a>
                </div>
            </div>
        </div>
        <hr>

        <!-- Assigned Coordinators List -->
        <div class="row">
            <div class="table-responsive">
                <table id="dataTable" class="table table-hover table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Coordinator Name</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>Assigned Programs</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($coordinatorAssignments)): ?>
                            <tr>
                                <td colspan="5" class="text-center">No coordinators assigned yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($coordinatorAssignments as $index => $assignment): ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td><?= esc($assignment['coordinator']['full_name']) ?></td>
                                    <td><?= esc($assignment['coordinator']['email']) ?></td>
                                    <td><?= esc($assignment['coordinator']['mobile_number']) ?></td>
                                    <td>
                                        <?php if (empty($assignment['programs'])): ?>
                                            <span class="text-danger">No assigned programs</span>
                                        <?php else: ?>
                                            <ul class="list-unstyled">
                                                <?php foreach ($assignment['programs'] as $program): ?>
                                                    <li class="d-flex justify-content-between align-items-center py-1">
                                                        <span>
                                                            <?= esc($program['program_name']) ?>
                                                            (<?= esc($program['program_duration']) ?>)
                                                        </span>
                                                        <a href="<?= site_url('coordinators/remove/' . $assignment['coordinator']['id'] . '/' . $program['id']) ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to remove this program from the coordinator?');">
                                                            Remove
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>