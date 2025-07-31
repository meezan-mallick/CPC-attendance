<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div id="content">
    <div id="user-add" class="container-fluid">
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
                            <input type="text" name="full_name" class="form-inputs" placeholder="Enter Name" required value="<?= old('full_name') ?>">
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Email:<span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-inputs" placeholder="Enter Email" required value="<?= old('email') ?>">
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Mobile Number: <span class="text-danger">*</span></label>
                            <input type="text" name="mobile_number" class="form-inputs" placeholder="Enter Mobile No" required value="<?= old('mobile_number') ?>">
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Password: <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-inputs" placeholder="Enter Password" required>
                        </div>

                    </div>

                    <div class="row pb-md-3">
                        <div class="col-md-3 col-12">
                            <label>Name as per Bank Account:</label>
                            <input type="text" name="name_as_per_bank_account" class="form-inputs" placeholder="Enter Name" value="<?= old('name_as_per_bank_account') ?>">
                        </div>
                        <div class="col-md-3 col-12">
                            <label>PAN Card No:</label>
                            <input type="text" name="pan_card_no" class="form-inputs" placeholder="Enter PAN Card No" maxlength="10" value="<?= old('pan_card_no') ?>">
                        </div>
                        <div class="col-md-3 col-12">
                            <label>Aadhaar No:</label>
                            <input type="text" name="aadhaar_no" class="form-inputs" placeholder="Enter Aadhaar No" maxlength="12" value="<?= old('aadhaar_no') ?>">
                        </div>
                        <div class="col-md-3 col-12">
                            <label>Bank Name:</label>
                            <input type="text" name="bank_name" class="form-inputs" placeholder="Enter Bank Name" value="<?= old('bank_name') ?>">
                        </div>
                    </div>

                    <div class="row pb-md-3">
                        <div class="col-md-3 col-12">
                            <label>Bank Account No:</label>
                            <input type="text" name="bank_account_no" class="form-inputs" placeholder="Enter Bank Account No" maxlength="50" value="<?= old('bank_account_no') ?>">
                        </div>
                        <div class="col-md-3 col-12">
                            <label>IFSC Code:</label>
                            <input type="text" name="ifsc_code" class="form-inputs" placeholder="Enter IFSC Code" maxlength="11" value="<?= old('ifsc_code') ?>">
                        </div>
                    </div>
                    <div class="row  pb-md-3">
                        <div class="col-md-3 col-12">
                            <label>Designation:<span class="text-danger">*</span></label>
                            <select class="form-control" name="designation" required>
                                <option value="">Select Designation</option>
                                <option value="ASSISTANT PROFESSOR" <?= old('designation') == 'ASSISTANT PROFESSOR' ? 'selected' : '' ?>>ASSISTANT PROFESSOR</option>
                                <option value="TEACHING ASSISTANT" <?= old('designation') == 'TEACHING ASSISTANT' ? 'selected' : '' ?>>TEACHING ASSISTANT</option>
                                <option value="TECHNICAL ASSISTANT" <?= old('designation') == 'TECHNICAL ASSISTANT' ? 'selected' : '' ?>>TECHNICAL ASSISTANT</option>
                                <option value="VISITING FACULTY" <?= old('designation') == 'VISITING FACULTY' ? 'selected' : '' ?>>VISITING FACULTY</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Role:<span class="text-danger">*</span></label>
                            <select name="role" class="form-inputs">
                                <option value="">Select Role</option>
                                <option value="Superadmin" <?= old('role') == 'Superadmin' ? 'selected' : '' ?>>Super Admin</option>
                                <option value="Faculty" <?= old('role') == 'Faculty' ? 'selected' : '' ?>>Faculty</option>
                                <option value="Coordinator" <?= old('role') == 'Coordinator' ? 'selected' : '' ?>>Coordinator</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-12">
                            <label>DOB:</label>
                            <input type="date" name="dob" class="form-inputs" value="<?= old('dob') ?>">
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Gender:</label>
                            <select name="gender" class="form-inputs">
                                <option value="">Select Gender</option>
                                <option value="Male" <?= old('gender') == 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= old('gender') == 'Female' ? 'selected' : '' ?>>Female</option>
                                <option value="Other" <?= old('gender') == 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="row  pb-md-3">
                        <div class="col-md-3 col-12">
                            <label>Father Name:</label>
                            <input type="text" name="father_name" class="form-inputs" value="<?= old('father_name') ?>">
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Mother Name:</label>
                            <input type="text" name="mother_name" class="form-inputs" value="<?= old('mother_name') ?>">
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Qualification:</label>
                            <textarea name="qualification" class="form-inputs"><?= old('qualification') ?></textarea>
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Industry Experience (Years):</label>
                            <input type="number" name="industry_experience" class="form-inputs" value="<?= old('industry_experience') ?>">
                        </div>
                    </div>

                    <div class="row  pb-md-3">
                        <div class="col-md-3 col-12">
                            <label>Working Experience (Years):</label>
                            <input type="number" name="working_experience" class="form-inputs" value="<?= old('working_experience') ?>">
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Achievements:</label>
                            <textarea name="achievements" class="form-inputs"><?= old('achievements') ?></textarea>
                        </div>

                        <div class="col-md-3 col-12">
                            <label>SkillSet:</label>
                            <textarea name="skillset" class="form-inputs"><?= old('skillset') ?></textarea>
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Address:</label>
                            <textarea name="address" class="form-inputs"><?= old('address') ?></textarea> </div>
                    </div>

                    <div class="row pb-md-3">
                        <div class="col-md-3 col-12">
                            <label>State:</label>
                            <input type="text" name="state" class="form-inputs" value="<?= old('state') ?>">
                        </div>

                        <div class="col-md-3 col-12">
                            <label>City:</label>
                            <input type="text" name="city" class="form-inputs" value="<?= old('city') ?>">
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Country:</label>
                            <input type="text" name="country" class="form-inputs" value="<?= old('country') ?>">
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Status:<span class="text-danger">*</span></label>
                            <select name="status" class="form-inputs">
                                <option value="">Select Status</option>
                                <option value="Active" <?= old('status') == 'Active' ? 'selected' : '' ?>>Active</option>
                                <option value="Inactive" <?= old('status') == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <button class="btn w-100 btn-primary px-3 py-2" type="submit">ADD </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>