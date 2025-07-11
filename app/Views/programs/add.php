<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
  <div id="user-add" class="container-fluid">


    <!-- Add new Program -->
    <div class="row">
      <form action="<?= site_url('programs/store') ?>" method="Post">
        <div class="header d-flex justify-content-between align-items-center">
          <h2>ADD NEW PROGRAM</h2>

          <a class="btn btn-sm btn-warning" href="<?= site_url('programs') ?>">
            < Back to Program List</a>

        </div>
        <hr>

        <div class="form-container">
          <div class="row pb-md-4">
            <div class="col-12 col-md-6">
              <label>College Code:</label>
              <select class="form-inputs" name="college_code" required>
                <option value="">Select College</option>
                <?php foreach ($colleges as $college): ?>
                  <option value="<?= esc($college['college_code']) ?>"><?= esc($college['college_code']) ?> - <?= esc($college['college_name']) ?></option>
                <?php endforeach; ?>
              </select>

            </div>
            <div class="col-12 col-md-6">

              <label for="productname">Program Name</label>
              <input
                class="form-inputs"
                type="text"
                name="program_name"
                id="program_name"
                placeholder="Enter Program Name" />
            </div>


          </div>

          <div class="row">
            <div class="col-12 col-md-4">
              <label>Program Duration:</label>
              <select class="form-inputs" name="program_duration" required>
                <option value="2 Years">2 Years</option>
                <option value="3 Years">3 Years</option>
                <option value="4 Years">4 Years</option>
                <option value="5 Years">5 Years</option>
              </select>
            </div>
            <div class="col-12 col-md-4">
              <label>Program Type:</label>
              <select class="form-inputs" name="program_type" required onchange="setSemesters()">
                <option value="">Select Program Type</option>
                <option value="integrated">Integrated</option>
                <option value="masters">Masters</option>
                <option value="bachelor">Bachelor</option>
                <option value="honours">Honours</option>
              </select>
            </div>


            <div class="col-12 col-md-4">

              <label>Total Semesters:</label>
              <input class="form-inputs" type="number" id="total_semesters_display" readonly>
              <input type="hidden" name="total_semesters" value="1" id="total_semesters">

            </div>

            <?php if (session()->getFlashdata('errors')): ?>
              <div style="color: red;">
                <?= implode('<br>', session()->getFlashdata('errors')); ?>
              </div>
            <?php endif; ?>
          </div>
          <button class="submit btn btn-primary w-100 mt-4" type="submit">
            ADD NEW PROGRAM
          </button>
      </form>
    </div>
  </div>
</div>


<script>
  function setSemesters() {
    let type = document.querySelector("select[name='program_type']").value;
    let semesterMap = {
      'integrated': { semesters: 10, duration: '5 Years' },
      'masters': { semesters: 4, duration: '2 Years' },
      'bachelor': { semesters: 6, duration: '3 Years' },
      'honours': { semesters: 8, duration: '4 Years' }
    };

    if (semesterMap[type]) {
      document.getElementById("total_semesters_display").value = semesterMap[type].semesters;
      document.getElementById("total_semesters").value = semesterMap[type].semesters;

      // Optional: auto-update duration if editable
      let durationField = document.querySelector("select[name='program_duration'], input[name='program_duration']");
      if (durationField) {
        durationField.value = semesterMap[type].duration;
      }
    } else {
      document.getElementById("total_semesters_display").value = "";
      document.getElementById("total_semesters").value = "";
    }
  }
</script>


<?= $this->endSection() ?>