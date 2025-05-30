<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
    <form class="p-3" action="<?= site_url('/time-slots/store') ?>" method="POST">
        <div class="header d-flex justify-content-between align-items-center">

            <div>
                <h2>ADD NEW TIME SLOT</h2>
            </div>
            <a class="btn btn-sm btn-warning" href="<?= site_url('time-slots') ?>">
                < Back to Time Slots List</a>


        </div>
        <div class="container">
            <hr>
        </div>

        <div class="row pb-4">
            <div class="col-md-6 col-12">
                <label For="start_time">Starting Time</label>

                <input
                    class="form-control"
                    type="time"
                    name="start_time"
                    id="start_time"
                    placeholder="Enter Starting Time" required />
            </div>

            <div class="col-md-6 col-12">
                <label For="end_time">Ending Time</label>

                <input
                    class="form-control"
                    type="time"
                    name="end_time"
                    id="end_time"
                    placeholder="Enter Ending Time" required />
            </div>

        </div>
        <button class="submit btn btn-primary w-100" type="submit">
            Add
        </button>
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

    </form>
</div>
<script>

</script>
<?= $this->endSection() ?>