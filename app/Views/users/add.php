<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid mt-4">
    <form action="<?= site_url('users/store') ?>" method="POST">
        <div class="header p-2">
            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('message') ?></div>
            <?php endif; ?>

            <?php if (isset($validation)): ?>
                <div class="alert alert-danger">
                    <?= $validation->listErrors(); ?>
                </div>
            <?php endif; ?>
            <a class="btn btn-sm btn-warning ms-4" href="<?= site_url('users') ?>">
                < Back to Users List</a>
                    <div>
                        <h2>ADD NEW USER</h2>
                    </div>


                    <button class="submit" type="submit">
                        Add
                    </button>
        </div>
        <div class="container">
            <hr>
        </div>

        <div class="row">

            <div class="col-md-3 col-12">
                <label>Full Name:</label>
                <input type="text" name="full_name" class="form-inputs" placeholder="Enter Name" required>
            </div>

            <div class="col-md-3 col-12">
                <label>Email:</label>
                <input type="email" name="email" class="form-inputs" placeholder="Enter Email" required>
            </div>

            <div class="col-md-3 col-12">
                <label>Mobile Number:</label>
                <input type="text" name="mobile_number" class="form-inputs" placeholder="Enter Mobile No" required>
            </div>

            <div class="col-md-3 col-12">
                <label>Password:</label>
                <input type="password" name="password" class="form-inputs" placeholder="Enter Password" required>
            </div>

        </div>

        <div class="row">
            <div class="col-md-3 col-12">
                <label>Designation:</label>
                <select class="form-control" name="designation" required>
                    <option value="ASSISTANT PROFESSOR">ASSISTANT PROFESSOR</option>
                    <option value="TEACHING ASSISTANT">TEACHING ASSISTANT</option>
                    <option value="TECHNICAL ASSISTANT">TECHNICAL ASSISTANT</option>
                    <option value="VISITING FACULTY">VISITING FACULTY</option>
                </select>
            </div>

            <div class="col-md-3 col-12">
                <label>Role:</label>
                <select name="role" class="form-inputs">
                    <option value="Superadmin">Super Admin</option>
                    <option value="Faculty">Faculty</option>
                    <option value="Coordinator">Coordinator</option>
                </select>
            </div>

            <div class="col-md-3 col-12">
                <label>DOB:</label>
                <input type="date" name="dob" class="form-inputs">
            </div>

            <div class="col-md-3 col-12">
                <label>Gender:</label>
                <select name="gender" class="form-inputs">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>


        </div>
        <div class="row">
            <div class="col-md-3 col-12">
                <label>Father Name:</label>
                <input type="text" name="father_name" class="form-inputs">
            </div>

            <div class="col-md-3 col-12">
                <label>Mother Name:</label>
                <input type="text" name="mother_name" class="form-inputs">
            </div>

            <div class="col-md-3 col-12">
                <label>Qualification:</label>
                <textarea name="qualification" class="form-inputs"></textarea>
            </div>

            <div class="col-md-3 col-12">
                <label>Industry Experience (Years):</label>
                <input type="number" name="industry_experience" class="form-inputs">
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 col-12">
                <label>Working Experience (Years):</label>
                <input type="number" name="working_experience" class="form-inputs">
            </div>

            <div class="col-md-3 col-12">
                <label>Achievements:</label>
                <textarea name="achievements" class="form-inputs"></textarea>
            </div>

            <div class="col-md-3 col-12">
                <label>SkillSet:</label>
                <textarea name="skillset" class="form-inputs"></textarea>
            </div>

            <div class="col-md-3 col-12">
                <label>Address:</label>
                <textarea name="address_line_1" class="form-inputs"></textarea>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 col-12">
                <label>State:</label>
                <input type="text" name="state" class="form-inputs">
            </div>

            <div class="col-md-3 col-12">
                <label>City:</label>
                <input type="text" name="city" class="form-inputs">
            </div>

            <div class="col-md-3 col-12">
                <label>Country:</label>
                <input type="text" name="country" class="form-inputs">
            </div>

            <div class="col-md-3 col-12">
                <label>Status:</label>
                <select name="status" class="form-inputs">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>

        </div>



    </form>
</div>


<?= $this->endSection() ?>