<?= $this->extend('main') ?>
<?= $this->section('content') ?>

<div id="login-container" class="d-flex bg-primary justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 400px; border-radius: 10px;">

        <!-- Logo and Company Name -->
        <div class="mb-3 text-center">
            <img src="/assets/Images/Icons/gulogo.png" alt="Company Logo" width="80">
            <h4 class="mt-2">CPC ORBIT</h4>
            <h5 class="medium text-muted">Center For Professional Courses <br> Gujarat University</h5>
        </div>

        <h2 class="text-center">LOGIN</h2>
        <hr>

        <form action="<?= site_url('login') ?>" method="post">
            <div class="mb-3">
                <label for="email" class="form-label text-left">Email</label>
                <input class="form-control" type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input class="form-control" type="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn btn-dark w-100">Login</button>
            <hr>
            <div class="text-center">
                <label>Contact admin for password reset</label>
            </div>

            <?php if (session()->getFlashdata('message')): ?>
                <p class="text-danger text-center mt-3"><?= session()->getFlashdata('message') ?></p>
            <?php endif; ?>
        </form>
    </div>
</div>

<?= $this->endSection() ?>