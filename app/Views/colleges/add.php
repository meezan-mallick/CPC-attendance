<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <form action="<?= site_url('/colleges/store') ?>" method="POST">
        <div class="header p-4">
            <a class="btn btn-sm btn-warning" href="<?= site_url('colleges') ?>">
                < Back to College List</a>
                    <div>
                        <h2>ADD NEW COLLEGE</h2>
                    </div>

                    <button class="submit" type="submit">
                        Add
                    </button>
        </div>
        <div class="container">
            <hr>
        </div>

        <div class="row">
            <div class="col-md-6 col-12">
                <label For="name">College Code</label>

                <input
                    class="form-inputs"
                    type="text"
                    name="college_code"
                    id="name"
                    placeholder="Enter College Code" />
            </div>

            <div class="col-md-6 col-12">
                <label For="username">College Name</label>

                <input
                    class="form-inputs"
                    type="text"
                    name="college_name"
                    id="username"
                    placeholder="Enter College Name" />
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
    function setSemesters() {
        let type = document.querySelector("select[name='program_type']").value;
        let semesterCount = type == "1" ? 10 : 4;

        // Display in read-only field
        document.getElementById("total_semesters_display").value = semesterCount;

        // Store in hidden input for form submission
        document.getElementById("total_semesters").value = semesterCount;
    }
</script>
<?= $this->endSection() ?>