<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid mt-4">
    <form action="<?= site_url('users/update/' . $user['id']) ?>" method="post">
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
                        <h2>UPDATE USER</h2>
                    </div>


                    <button class="submit" type="submit">
                        Update
                    </button>
        </div>
        <div class="container">
            <hr>
        </div>

        <div class="row">

            <div class="col-md-3 col-12">
                <label>Full Name:</label>
                <input type="text"
                    name="full_name"
                    class="form-inputs"
                    placeholder="Enter Name"
                    required
                    value="<?= esc($user['full_name']) ?>">
            </div>

            <div class="col-md-3 col-12">
                <label>Email:</label>
                <input type="email" name="email" class="form-inputs" placeholder="Enter Email" required
                    value="<?= esc($user['email']) ?>">
            </div>

            <div class="col-md-3 col-12">
                <label>Mobile Number:</label>
                <input type="text" name="mobile_number" class="form-inputs" placeholder="Enter Mobile No" required value="<?= esc($user['mobile_number']) ?>">
            </div>

            <div class="col-md-3 col-12">
                <label>Password:</label>
                <input type="password" name="password" class="form-inputs" placeholder="Enter Password">
            </div>

        </div>

        <div class="row">
            <div class="col-md-3 col-12">
                <label>Designation:</label>
                <select class="form-control" name="designation" required>
                    <option value="ASSISTANT PROFESSOR" <?= ($user['designation'] == 'ASSISTANT PROFESSOR') ? 'selected' : '' ?>>ASSISTANT PROFESSOR</option>
                    <option value="TEACHING ASSISTANT" <?= ($user['designation'] == 'TEACHING ASSISTANT') ? 'selected' : '' ?>>TEACHING ASSISTANT</option>
                    <option value="TECHNICAL ASSISTANT" <?= ($user['designation'] == 'TECHNICAL ASSISTANT') ? 'selected' : '' ?>>TECHNICAL ASSISTANT</option>
                    <option value="VISITING FACULTY" <?= ($user['designation'] == 'VISITING FACULTY') ? 'selected' : '' ?>>VISITING FACULTY</option>
                </select>
            </div>

            <div class="col-md-3 col-12">
                <label>Role:</label>
                <select name="role" class="form-select">
                    <option value="Superadmin" <?= ($user['role'] == 'Superadmin') ? 'selected' : '' ?>>Superadmin</option>
                    <option value="Coordinator" <?= ($user['role'] == 'Coordinator') ? 'selected' : '' ?>>Coordinator</option>
                    <option value="Faculty" <?= ($user['role'] == 'Faculty') ? 'selected' : '' ?>>Faculty</option>
                </select>
            </div>

            <div class="col-md-3 col-12">
                <label>DOB:</label>
                <input type="date" name="dob" class="form-control" value="<?= isset($user['dob']) ? date('Y-m-d', strtotime($user['dob'])) : '' ?>">
            </div>

            <div class="col-md-3 col-12">
                <label>Gender:</label>
                <select name="gender" class="form-inputs">
                    <option value="Male" <?= (isset($user['gender']) && $user['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= (isset($user['gender']) && $user['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                    <option value="Other" <?= (isset($user['gender']) && $user['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
                </select>

            </div>


        </div>
        <div class="row">
            <div class="col-md-3 col-12">
                <label>Father Name:</label>
                <input type="text" name="father_name" class="form-inputs" value="<?= esc($user['father_name']) ?>">
            </div>

            <div class="col-md-3 col-12">
                <label>Mother Name:</label>
                <input type="text" name="mother_name" class="form-inputs" value="<?= esc($user['mother_name']) ?>">
            </div>

            <div class="col-md-3 col-12">
                <label>Qualification:</label>
                <textarea name="qualification" class="form-inputs" value="<?= esc($user['qualification']) ?>"></textarea>
            </div>

            <div class="col-md-3 col-12">
                <label>Industry Experience (Years):</label>
                <input type="number" name="industry_experience" class="form-inputs" value="<?= esc($user['industry_experience']) ?>">
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 col-12">
                <label>Working Experience (Years):</label>
                <input type="number" name="working_experience" class="form-inputs" value="<?= esc($user['working_experience']) ?>">
            </div>

            <div class="col-md-3 col-12">
                <label>Achievements:</label>
                <textarea name="achievements" class="form-inputs" value="<?= esc($user['achievements']) ?>"></textarea>
            </div>

            <div class="col-md-3 col-12">
                <label>SkillSet:</label>
                <textarea name="skillset" class="form-inputs" value="<?= esc($user['skillset']) ?>"></textarea>
            </div>

            <div class="col-md-3 col-12">
                <label>Address:</label>
                <textarea name="address_line_1" class="form-inputs" value="<?= esc($user['address']) ?>"></textarea>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 col-12">
                <label>State:</label>
                <input type="text" name="state" class="form-inputs" value="<?= esc($user['state']) ?>">
            </div>

            <div class=" col-md-3 col-12">
                <label>City:</label>
                <input type="text" name="city" class="form-inputs" value="<?= esc($user['city']) ?>">
            </div>

            <div class=" col-md-3 col-12">
                <label>Country:</label>
                <input type="text" name="country" class="form-inputs" value="<?= esc($user['country']) ?>">
            </div>

            <div class=" col-md-3 col-12">
                <label>Status:</label>
                <select name="status" class="form-inputs">
                    <option value="Active" <?= (isset($user['status']) && $user['status'] == 'Active') ? 'selected' : '' ?>>Active</option>
                    <option value="Inactive" <?= (isset($user['status']) && $user['status'] == 'Inactive') ? 'selected' : '' ?>>Inactive</option>
                </select>

            </div>

        </div>



    </form>
</div>


<?= $this->endSection() ?>