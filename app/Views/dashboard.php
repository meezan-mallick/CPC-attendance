<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container">
    <h2>Welcome, <?= session()->get('full_name') ?>!</h2>

    <p>Your role: <strong><?= session()->get('role') ?></strong></p>

    <div class="mt-4">
        <?php if (session()->get('role') == 'Superadmin'): ?>
            <div class="alert alert-primary">Manage all users, programs, and subjects.</div>
        <?php elseif (session()->get('role') == 'Coordinator'): ?>
            <div class="alert alert-warning">Manage assigned programs and subjects.</div>
        <?php else: ?>
            <div class="alert alert-success">View assigned subjects.</div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>