<?= $this->extend('main') ?>

<?= $this->section('content') ?>


<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 400px;">
        <h2 class="text-center">Login</h2>
        <hr>

        <form action="<?= site_url('login') ?>" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input class="form-control" type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input class="form-control" type="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn btn-dark w-100">Sign In</button>

            <?php if (session()->getFlashdata('message')): ?>
                <p class="text-danger text-center mt-3"><?= session()->getFlashdata('message') ?></p>
            <?php endif; ?>
        </form>
    </div>
</div>

<?= $this->endSection() ?>