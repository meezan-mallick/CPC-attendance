<?= $this->extend('main') ?>
<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <h2 class="mb-4">Dashboard Overview</h2>
                <h5 class="text-end text-md-start">Welcome, <?= session()->get('full_name') ?>!</h5>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Students</h5>
                                <h3 class="mb-0"><?= esc(number_format($total_students)) ?></h3>
                            </div>
                            <i class="fas fa-users fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Coordinators</h5>
                                <h3 class="mb-0"><?= esc(number_format($total_coordinators)) ?></h3>
                            </div>
                            <i class="bi bi-person-badge-fill display-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div style="background-color: #0097A7  ;" class="card text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Faculties</h5>
                                <h3 class="mb-0"><?= esc(number_format($total_faculties)) ?></h3>
                            </div>
                            <i class="fa-solid fa-user-tie fa-3x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Subjects</h5>
                                <h3 class="mb-0"><?= esc(number_format($total_subjects)) ?></h3>
                            </div>
                            <i class="bi bi-book-fill display-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-6 mb-4">
                <div style="background-color: #6A1B9A ;" class="card text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Programs</h5>
                                <h3 class="mb-0"><?= esc(number_format($total_programs)) ?></h3>
                            </div>
                            <i class="bi bi-mortarboard-fill display-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Colleges</h5>
                                <h3 class="mb-0"><?= esc(number_format($total_colleges)) ?></h3>
                            </div>
                            <i class="bi bi-building display-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div style="background-color: #00897B  ;" class="card text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Lecture Today</h5>
                                <h3 class="mb-0"><?= esc(number_format($total_faculties)) ?></h3>
                            </div>
                            <i class="fa-solid fa-clipboard-list display-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div style="background-color: #2C3E50    ;" class="card text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Guest Faculties</h5>
                                <h3 class="mb-0"><?= esc(number_format($total_subjects)) ?></h3>
                            </div>
                            <i class="fa-solid fa-user-tie fa-3x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>


<?= $this->endSection() ?>