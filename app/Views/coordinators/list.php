<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="container mt-4">
        <div class="header">
            <div class="heading">
                <h2>Coordinators and their Assigned Programs</h2>
            </div>
            <div>
                <a href="<?= site_url('coordinators/assign') ?>" class="add-p">
                    <button class="btn btn-primary">Assign Program to coordinator</button>
                </a>
            </div>
        </div>
        <hr>
        <table class="table table-bordered">
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
                            <td><?= $index + 1 ?></td>
                            <td><?= esc($assignment['coordinator']['full_name']) ?></td>
                            <td><?= esc($assignment['coordinator']['email']) ?></td>
                            <td><?= esc($assignment['coordinator']['mobile_number']) ?></td>
                            <td>
                                <?php if (empty($assignment['programs'])): ?>
                                    <span class="text-danger">No assigned programs</span>
                                <?php else: ?>
                                    <ul>
                                        <?php foreach ($assignment['programs'] as $program): ?>
                                            <li>
                                                <?= esc($program['program_name']) ?> (<?= esc($program['program_duration']) ?>)
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

<?= $this->endSection() ?>