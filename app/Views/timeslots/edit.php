<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <form action="<?= base_url('time-slots/update/'.$timeslot['id'])?>" method="Post">
        <div class="header p-4">
            <a class="btn btn-sm btn-warning" href="<?= site_url('time-slots') ?>">
                < Back to TimeSlots List</a>
                    <div>
                        <h2>Update Time Slot</h2>
                    </div>

                    <button class="submit" type="submit">
                        Update
                    </button>
        </div>
        <div class="container">
            <hr>
        </div>

        <div class="row">
            <div class="col-md-6 col-12">
                <label For="start_time">Starting Time</label>

                <input
                    class="form-inputs"
                    type="time"
                    name="start_time"
                    id="start_time"
                    placeholder="Enter Starting Time" 
                      value="<?=$timeslot['start_time']?>" required
                />
            </div>

            <div class="col-md-6 col-12">
                <label For="end_time">Ending Time</label>

                <input
                    class="form-inputs"
                    type="time"
                    name="end_time"
                    id="end_time"
                    placeholder="Enter Ending Time" 
                    value="<?=$timeslot['end_time']?>" required   
                />
            </div>

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