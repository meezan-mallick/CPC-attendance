<?= $this->extend('main') ?>
<?= $this->section('content') ?>

<div id="content">
    <div>
        <form action="<?= site_url('attendance/store/' . $program_id . '/' . $semester_number . '/' . $subject_id . '/' . $topic['id'] . '/' . $batch) ?>" method="POST">

            <a href="<?= site_url('faculty-subjects') ?>" class="btn btn-danger mb-3">Back to Topics List</a>

            <div class="row">
                <div class="col-12 col-md-9 mb-md-0 mb-4">
                    <div class="header ps-md-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="text-center text-md-start mt-4 mt-md-0">Attendance</h1>
                            <hr>
                            <h5>📋 Topic: <?= esc($topic['topic']) ?> - Batch <?= esc($batch) ?></h5>
                            <h5>🏫 Program: <strong><?= esc($program['program_name']) ?></strong></h5>
                            <h5>📖 Subject: <strong><?= esc($subject['subject_name']) ?></strong></h5>
                            <h5>🎓 Semester: <strong><?= esc($semester_number) ?></strong></h5>
                            <h5>📅 Date: <strong><?= date("d-m-Y", strtotime($topic['date'])) ?></strong></h5>
                            <h5>⏰ Time Slot: <strong><?= esc($topic['time']) ?></strong></h5>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3 pe-md-5">

                    <button type="button" id="markAllPresent" class="btn p-3 btn-success w-100 mt-4 mb-3">Mark All Present</button>
                    <button type="button" id="markAllAbsent" class="btn p-3 btn-warning w-100 mb-3">Mark All Absent</button>
                    <button class="btn p-3 btn-primary w-100 mb-3" type="submit">Submit</button>
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

            <!-- ✅ New Student Cards Section -->
            <div class="row">
                <?php if (!empty($students)) : ?>
                    <?php foreach ($students as $s) : ?>
                        <div class="col-md-3 col-12">
                            <div class="student-card m-2" data-student="<?= esc($s['id']) ?>" data-status="<?= esc($s['attendance'] ?? 'Absent') ?>">
                                <input type="hidden" name="student_ids[]" value="<?= esc($s['id']) ?>">
                                <input type="hidden" name="attendance_ids[<?= esc($s['id']) ?>]" value="<?= esc($s['attendance_id'] ?? '') ?>">
                                <input type="hidden" name="attendance[<?= esc($s['id']) ?>]" class="attendance-input" value="<?= esc($s['attendance'] ?? 'Absent') ?>">
                                <h5><?= esc($s['full_name'] ?? 'Unknown Student') ?></h5>
                                <h4 class="mt-3"><?= esc($s['university_enrollment_no'] ?? '-') ?></h4>
                                <span class="status-label"><?= esc($s['attendance'] ?? '❌ Absent') ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="text-center text-danger">⚠ No students found for this batch.</p>
                <?php endif; ?>
            </div>

        </form>
    </div>
</div>

<!-- ✅ JavaScript for Marking Attendance -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const studentCards = document.querySelectorAll(".student-card");

        studentCards.forEach(card => {
            updateCardStatus(card); // ✅ Ensure correct status is set on load

            card.addEventListener("click", function() {
                let currentStatus = this.getAttribute("data-status");

                if (currentStatus === "Absent") {
                    this.setAttribute("data-status", "Present");
                    this.querySelector(".attendance-input").value = "Present";
                    this.querySelector(".status-label").innerHTML = "✅ Present";
                } else {
                    this.setAttribute("data-status", "Absent");
                    this.querySelector(".attendance-input").value = "Absent";
                    this.querySelector(".status-label").innerHTML = "❌ Absent";
                }

                updateCardStatus(this);
            });
        });

        function updateCardStatus(card) {
            let status = card.getAttribute("data-status");

            if (status === "Present") {
                card.classList.add("present");
                card.classList.remove("absent");
            } else {
                card.classList.add("absent");
                card.classList.remove("present");
            }
        }

        // ✅ Mark All Present
        document.getElementById("markAllPresent").addEventListener("click", function() {
            studentCards.forEach(card => {
                card.setAttribute("data-status", "Present");
                card.querySelector(".attendance-input").value = "Present";
                card.querySelector(".status-label").innerHTML = "✅ Present";
                updateCardStatus(card);
            });
        });

        // ✅ Mark All Absent
        document.getElementById("markAllAbsent").addEventListener("click", function() {
            studentCards.forEach(card => {
                card.setAttribute("data-status", "Absent");
                card.querySelector(".attendance-input").value = "Absent";
                card.querySelector(".status-label").innerHTML = "❌ Absent";
                updateCardStatus(card);
            });
        });
    });
</script>

<?= $this->endSection() ?>