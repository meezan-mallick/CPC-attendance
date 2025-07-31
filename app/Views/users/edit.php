<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div id="content">
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors(); ?></div>
    <?php endif; ?>

    <form class="p-4" action="<?= site_url('users/update/' . $user['id']) ?>" method="post">
        <?= csrf_field() ?> <div class="header d-flex justify-content-between align-items-center">

            <div>
                <h2>UPDATE USER</h2>
            </div>
            <a class="btn btn-sm btn-warning ms-4" href="<?= $_SERVER['HTTP_REFERER'] ?? site_url('users') ?>">
                &lt; Back
            </a>
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
                    value="<?= old('full_name', esc($user['full_name'])) ?>">
            </div>

            <div class="col-md-3 col-12">
                <label>Email:</label>
                <input type="email" name="email" class="form-inputs" placeholder="Enter Email" required
                    value="<?= old('email', esc($user['email'])) ?>">
            </div>

            <div class="col-md-3 col-12">
                <label>Mobile Number:</label>
                <input type="text" name="mobile_number" class="form-inputs" placeholder="Enter Mobile No" required value="<?= old('mobile_number', esc($user['mobile_number'])) ?>">
            </div>

            <div class="col-md-3 col-12">
                <label>Password</label>
                <label class="text-danger">(Leave blank to keep the same):</label>
                <input type="password" name="password" class="form-inputs" placeholder="Enter Password">
            </div>
        </div>

        <div class="row pb-md-3">
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="name_as_per_bank_account">Name as per Bank Account</label>
                    <input type="text" name="name_as_per_bank_account" id="name_as_per_bank_account" class="form-control"
                        value="<?= old('name_as_per_bank_account', esc($user['name_as_per_bank_account'] ?? '')) ?>">
                    <?php if (session()->has('validation') && session('validation')->hasError('name_as_per_bank_account')) : ?>
                        <p class="text-danger mt-1"><?= session('validation')->getError('name_as_per_bank_account') ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="pan_card_no">PAN Card No.</label>
                            <input type="text" name="pan_card_no" id="pan_card_no" maxlength="10" class="form-control"
                                value="<?= old('pan_card_no', esc($user['pan_card_no'] ?? '')) ?>">
                            <?php if (session()->has('validation') && session('validation')->hasError('pan_card_no')) : ?>
                                <p class="text-danger mt-1"><?= session('validation')->getError('pan_card_no') ?></p>
                            <?php endif; ?>
                        </div>
            </div>
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="aadhaar_no">Aadhaar No.</label>
                    <input type="text" name="aadhaar_no" id="aadhaar_no" maxlength="12" class="form-control"
                        value="<?= old('aadhaar_no', esc($user['aadhaar_no'] ?? '')) ?>">
                    <?php if (session()->has('validation') && session('validation')->hasError('aadhaar_no')) : ?>
                        <p class="text-danger mt-1"><?= session('validation')->getError('aadhaar_no') ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-3 col-12">
                <label>Bank Name:</label>
                <input type="text" name="bank_name" class="form-inputs" placeholder="Enter Bank Name" value="<?= old('bank_name', esc($user['bank_name'])) ?>">
            </div>
        </div>

        <div class="row pb-md-3">
            <div class="col-md-3 col-12">
                    <div class="form-group">
                    <label for="bank_account_no">Bank Account No.</label>
                    <input type="text" maxlength="50" name="bank_account_no" id="bank_account_no" class="form-control"
                        value="<?= old('bank_account_no', esc($user['bank_account_no'] ?? '')) ?>">
                    <?php if (session()->has('validation') && session('validation')->hasError('bank_account_no')) : ?>
                        <p class="text-danger mt-1"><?= session('validation')->getError('bank_account_no') ?></p>
                    <?php endif; ?>
                </div>
        </div>
            <div class="col-md-3 col-12">
                <div class="form-group">
                <label for="ifsc_code">IFSC Code</label>
                <input type="text" maxlength="11" name="ifsc_code" id="ifsc_code" class="form-control"
                    value="<?= old('ifsc_code', esc($user['ifsc_code'] ?? '')) ?>">
                <?php if (session()->has('validation') && session('validation')->hasError('ifsc_code')) : ?>
                    <p class="text-danger mt-1"><?= session('validation')->getError('ifsc_code') ?></p>
                <?php endif; ?>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="designation">Designation</label>
                        <?php
                        // Determine if the field should be disabled based on the logged-in user's role
                        $isDesignationRoleDisabled = ($loggedInUserRole == 'Faculty' || $loggedInUserRole == 'Coordinator');
                        ?>
                        <select name="designation" id="designation" class="form-control"
                            <?= $isDesignationRoleDisabled ? 'disabled' : '' // Add disabled attribute conditionally
                            ?>>
                            <option value="">Select Designation</option>
                            <option value="ASSISTANT PROFESSOR" <?= old('designation', esc($user['designation'] ?? '')) == 'ASSISTANT PROFESSOR' ? 'selected' : '' ?>>ASSISTANT PROFESSOR</option>
                            <option value="TEACHING ASSISTANT" <?= old('designation', esc($user['designation'] ?? '')) == 'TEACHING ASSISTANT' ? 'selected' : '' ?>>TEACHING ASSISTANT</option>
                            <option value="TECHNICAL ASSISTANT" <?= old('designation', esc($user['designation'] ?? '')) == 'TECHNICAL ASSISTANT' ? 'selected' : '' ?>>TECHNICAL ASSISTANT</option>
                            <option value="VISITING FACULTY" <?= old('designation', esc($user['designation'] ?? '')) == 'VISITING FACULTY' ? 'selected' : '' ?>>VISITING FACULTY</option>
                        </select>
                        <?php if (session()->has('validation') && session('validation')->hasError('designation')) : ?>
                            <p class="text-danger mt-1"><?= session('validation')->getError('designation') ?></p>
                        <?php endif; ?>

                        <?php if ($isDesignationRoleDisabled) : ?>
                            <input type="hidden" name="designation" value="<?= esc($user['designation'] ?? '') ?>">
                        <?php endif; ?>
                    </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="role">Role</label>
                    <?php
                    // Determine if the field should be disabled based on the logged-in user's role
                    $isRoleDisabled = ($loggedInUserRole == 'Faculty' || $loggedInUserRole == 'Coordinator');
                    ?>
                    <select name="role" id="role" class="form-control"
                        <?= $isRoleDisabled ? 'disabled' : '' // Add disabled attribute conditionally
                        ?>>
                        <option value="">Select Role</option>
                        <option value="Superadmin" <?= old('role', esc($user['role'] ?? '')) == 'Superadmin' ? 'selected' : '' ?>>Superadmin</option>
                        <option value="Coordinator" <?= old('role', esc($user['role'] ?? '')) == 'Coordinator' ? 'selected' : '' ?>>Coordinator</option>
                        <option value="Faculty" <?= old('role', esc($user['role'] ?? '')) == 'Faculty' ? 'selected' : '' ?>>Faculty</option>
                    </select>
                    <?php if (session()->has('validation') && session('validation')->hasError('role')) : ?>
                        <p class="text-danger mt-1"><?= session('validation')->getError('role') ?></p>
                    <?php endif; ?>

                    <?php if ($isRoleDisabled) : ?>
                        <input type="hidden" name="role" value="<?= esc($user['role'] ?? '') ?>">
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-3 col-12">
                <label>DOB:</label>
                <input type="date" name="dob" class="form-control" value="<?= old('dob', isset($user['dob']) ? date('Y-m-d', strtotime($user['dob'])) : '') ?>">
            </div>

            <div class="col-md-3 col-12">
                <label>Gender:</label>
                <select name="gender" class="form-inputs">
                    <option value="Male" <?= old('gender', (isset($user['gender']) && $user['gender'] == 'Male') ? 'selected' : '') ?>>Male</option>
                    <option value="Female" <?= old('gender', (isset($user['gender']) && $user['gender'] == 'Female') ? 'selected' : '') ?>>Female</option>
                    <option value="Other" <?= old('gender', (isset($user['gender']) && $user['gender'] == 'Other') ? 'selected' : '') ?>>Other</option>
                </select>

            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-12">
                <label>Father Name:</label>
                <input type="text" name="father_name" class="form-inputs" value="<?= old('father_name', esc($user['father_name'])) ?>">
            </div>

            <div class="col-md-3 col-12">
                <label>Mother Name:</label>
                <input type="text" name="mother_name" class="form-inputs" value="<?= old('mother_name', esc($user['mother_name'])) ?>">
            </div>

            <div class="col-md-3 col-12">
                <label>Qualification:</label>
                <textarea name="qualification" class="form-inputs"><?= old('qualification', esc($user['qualification'])) ?></textarea>
            </div>

            <div class="col-md-3 col-12">
                <label>Industry Experience (Years):</label>
                <input type="number" name="industry_experience" class="form-inputs" value="<?= old('industry_experience', esc($user['industry_experience'])) ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-12">
                <label>Working Experience (Years):</label>
                <input type="number" name="working_experience" class="form-inputs" value="<?= old('working_experience', esc($user['working_experience'])) ?>">
            </div>

            <div class="col-md-3 col-12">
                <label>Achievements:</label>
                <textarea name="achievements" class="form-inputs"><?= old('achievements', esc($user['achievements'])) ?></textarea>
            </div>

            <div class="col-md-3 col-12">
                <label>SkillSet:</label>
                <textarea name="skillset" class="form-inputs"><?= old('skillset', esc($user['skillset'])) ?></textarea>
            </div>

            <div class="col-md-3 col-12">
                <label>Address:</label>
                <textarea name="address" class="form-inputs"><?= old('address', esc($user['address'])) ?></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-12">
                <label>State:</label>
                <input type="text" name="state" class="form-inputs" value="<?= old('state', esc($user['state'])) ?>">
            </div>

            <div class=" col-md-3 col-12">
                <label>City:</label>
                <input type="text" name="city" class="form-inputs" value="<?= old('city', esc($user['city'])) ?>">
            </div>

            <div class=" col-md-3 col-12">
                <label>Country:</label>
                <input type="text" name="country" class="form-inputs" value="<?= old('country', esc($user['country'])) ?>">
            </div>

            <div class=" col-md-3 col-12">
                <label>Status:</label>
                <select name="status" class="form-inputs">
                    <option value="Active" <?= old('status', (isset($user['status']) && $user['status'] == 'Active') ? 'selected' : '') ?>>Active</option>
                    <option value="Inactive" <?= old('status', (isset($user['status']) && $user['status'] == 'Inactive') ? 'selected' : '') ?>>Inactive</option>
                </select>
            </div>
        </div>

        <div class="row">
            <button class="submit btn btn-primary w-100 mt-5" type="submit">
                Update
            </button>
        </div>

    </form>
</div>

<?= $this->endSection() ?>