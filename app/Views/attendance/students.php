<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="m-4">
        <form  action="<?= site_url('attendance/store/' . $program_id.'/'.$semester_number.'/'.$subject_id.'/'.$topic['id'].'/'.$batch) ?>" method="POST">
            <div class="header p-4">
                <div class="heading">
                    <h2><?=$topic['topic']?> Batch <?= $batch?></h2>
                </div>

               <div>
                    <button type="button" class="submit"  style="background-color: #04AA6D;border:1px solid #04AA6D ;">Present All</button>
                    <button class="submit" type="submit" >
                        Submit
                    </button>
                    <button class="submit" type="reset">
                        Clear
                    </button>
               </div>
            </div>
            <div class="container">
            <hr>
            </div>

           

            <div class="row">

            <?php if (session()->getFlashdata('errors')): ?>
                <div style="color: red;">
                <?= implode('<br>', session()->getFlashdata('errors')); ?>
                </div>
            <?php endif; ?>
            </div>
      
            <div class="table-wrapper data-table">
            <table>
                <thead>

                <tr>
                    <th>Enrollment No</th>
                    <th>Student Name</th>
                    <th>Absent/Present</th>
                   
                </tr>
                </thead>

                <tbody>

                    <?php foreach ($student as $s) : ?>
                        <tr>
                               
                            <input type="hidden" name="student_ids[]" value="<?= $s['id'] ?>">
                            <input type="hidden" name="attendance_ids[<?=$s['id']?>]" value="<?= $s['attendance_id'] ?>">
                                  
                            <td><?= esc($s['university_enrollment_no']) ?></td>
                            <td><?= esc($s['full_name']) ?></td>
                            <td class="text-center d-flex flex-row justify-content-center" style="height: fit-content;">
                                <div class="form-check form-switch" style="width: fit-content;height: fit-content;">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" style="transform: scale(1.5);"  name="attendance[<?= $s['id'] ?>]" value="Present" <?php echo $s['attendance']=="Present"?"checked":"";?>>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
        </div>
</div>
</form>


<script>
    const today = new Date().toISOString().split('T')[0];
        // Set the value of the input field with id 'date'
    $('#date').val(today);
</script>
<?= $this->endSection() ?>