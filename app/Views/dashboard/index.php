<?= $this->extend('main') ?>
<?= $this->section('content') ?>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="container mt-4">
    <div class="m-4">

        <h2 class="mb-4">📊 Dashboard Overview</h2>
        <h4>Welcome, <?= session()->get('full_name') ?>!</h4>
    </div>

    <div class="row g-3">
        <!-- Total Students -->
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-lg border-0 p-3 text-center text-white bg-primary">
                <i class="bi bi-people-fill display-4"></i>
                <h5 class="mt-2">Total Students</h5>
                <h2 class="fw-bold"><?= esc($total_students) ?></h2>
            </div>
        </div>

        <!-- Total Coordinators -->
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-lg border-0 p-3 text-center text-white bg-warning">
                <i class="bi bi-person-badge-fill display-4"></i>
                <h5 class="mt-2">Total Coordinators</h5>
                <h2 class="fw-bold"><?= esc($total_coordinators) ?></h2>
            </div>
        </div>

        <!-- Total Faculties -->
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-lg border-0 p-3 text-center text-white bg-success">
                <i class="bi bi-person-fill display-4"></i>
                <h5 class="mt-2">Total Faculties</h5>
                <h2 class="fw-bold"><?= esc($total_faculties) ?></h2>
            </div>
        </div>

        <!-- Total Subjects -->
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-lg border-0 p-3 text-center text-white bg-danger">
                <i class="bi bi-book-fill display-4"></i>
                <h5 class="mt-2">Total Subjects</h5>
                <h2 class="fw-bold"><?= esc($total_subjects) ?></h2>
            </div>
        </div>

        <!-- Total Programs -->
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-lg border-0 p-3 text-center text-white bg-info">
                <i class="bi bi-mortarboard-fill display-4"></i>
                <h5 class="mt-2">Total Programs</h5>
                <h2 class="fw-bold"><?= esc($total_programs) ?></h2>
            </div>
        </div>

        <!-- Total Colleges -->
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-lg border-0 p-3 text-center text-white bg-secondary">
                <i class="bi bi-building display-4"></i>
                <h5 class="mt-2">Total Colleges</h5>
                <h2 class="fw-bold"><?= esc($total_colleges) ?></h2>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>