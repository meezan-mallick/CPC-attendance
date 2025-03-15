<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
    <div id="user-add" class="container-fluid">
        <!-- Add new user -->
        <div class="row">
            <div class="table-responsive">

                <form action="<?= site_url('users/store') ?>" method="POST">
                    <div class="row mt-2 mb-4">
                        <div class="col-12">
                            <div class="header d-flex justify-content-between align-items-center">
                                <h2>ADD NEW USER</h2>
                                <a class="btn btn-warning" href="/users">
                                    Back to users list</a>

                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <hr>
                    </div>

                    <div class="row pb-md-3">

                        <div class="col-md-3 col-12">
                            <label>Full Name: <span class="text-danger">*</span> </label>
                            <input type="text" name="full_name" class="form-inputs" placeholder="Enter Name" required>
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Email:<span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-inputs" placeholder="Enter Email" required>
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Mobile Number: <span class="text-danger">*</span></label>
                            <input type="text" name="mobile_number" class="form-inputs" placeholder="Enter Mobile No" required>
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Password: <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-inputs" placeholder="Enter Password" required>
                        </div>

                    </div>

                    <div class="row  pb-md-3">
                        <div class="col-md-3 col-12">
                            <label>Designation:<span class="text-danger">*</span></label>
                            <select class="form-control" name="designation" required>
                                <option value="ASSISTANT PROFESSOR">ASSISTANT PROFESSOR</option>
                                <option value="TEACHING ASSISTANT">TEACHING ASSISTANT</option>
                                <option value="TECHNICAL ASSISTANT">TECHNICAL ASSISTANT</option>
                                <option value="VISITING FACULTY">VISITING FACULTY</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Role:<span class="text-danger">*</span></label>
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
                    <div class="row  pb-md-3">
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
                    <div class="row  pb-md-3">
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
                    <div class="row pb-md-3">
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
                            <label>Status:<span class="text-danger">*</span></label>
                            <select name="status" class="form-inputs">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                    </div>


                    <a href="<?= site_url('coordinators/assign') ?>" class="add-p">
                        <button class="btn w-100 btn-primary px-3 py-2">ADD </button>
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>