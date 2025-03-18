<?php
$current_url = service('uri')->getSegment(1); // Get the first segment of the URL
?>

<!-- Sidebar -->
<nav class="sidebar bg-dark text-white p-3 vh-100">
  <section class="logo-section d-flex align-items-center">
    <img class="logo me-2" src="/assets/Images/Icons/gulogo.png" alt="logo" width="40" />
    <div>
      <h5 class="d-none d-md-block m-0">CPC ORBIT</h5>
      <p class="small">Center For Professional Courses</p>
    </div>
  </section>

  <hr class="bg-secondary">

  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center <?= ($current_url == 'dashboard') ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
      </a>
    </li>

    <?php if (session()->get('role') == 'Superadmin'): ?>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center <?= ($current_url == 'coordinators') ? 'active' : '' ?>" href="<?= site_url('coordinators') ?>">
          <i class="bi bi-person-badge-fill me-2"></i> Manage Coordinators
        </a>
      </li>
    <?php endif; ?>

    <?php if (session()->get('role') == 'Superadmin'): ?>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center <?= ($current_url == 'users') ? 'active' : '' ?>" href="<?= site_url('users') ?>">
          <i class="bi bi-people-fill me-2"></i> Users
        </a>
      </li>
    <?php endif; ?>

    <?php if (session()->get('role') == 'Superadmin'): ?>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center <?= ($current_url == 'colleges') ? 'active' : '' ?>" href="<?= site_url('colleges') ?>">
          <i class="bi bi-building me-2"></i> Colleges
        </a>
      </li>
    <?php endif; ?>

    <?php if (in_array(session()->get('role'), ['Superadmin'])): ?>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center <?= ($current_url == 'programs') ? 'active' : '' ?>" href="<?= site_url('programs') ?>">
          <i class="bi bi-mortarboard-fill me-2"></i> Programs
        </a>
      </li>
    <?php endif; ?>

    <?php if (in_array(session()->get('role'), ['Superadmin', 'Coordinator'])): ?>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center <?= ($current_url == 'subjects') ? 'active' : '' ?>" href="<?= site_url('subjects') ?>">
          <i class="bi bi-book-fill me-2"></i> Subjects
        </a>
      </li>
    <?php endif; ?>

    <?php if (in_array(session()->get('role'), ['Superadmin', 'Coordinator'])): ?>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center <?= ($current_url == 'students') ? 'active' : '' ?>" href="<?= site_url('students') ?>">
          <i class="bi bi-person-lines-fill me-2"></i> Students
        </a>
      </li>
    <?php endif; ?>

    <?php if (in_array(session()->get('role'), ['Superadmin', 'Coordinator', 'Faculty'])): ?>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center <?= ($current_url == 'attendance') ? 'active' : '' ?>" href="<?= site_url('attendance') ?>">
          <i class="bi bi-check2-square me-2"></i> Attendance
        </a>
      </li>
    <?php endif; ?>

    <li class="mt-3">
      <form action="/logout">
        <button class="btn btn-danger w-100"><i class="bi bi-box-arrow-right"></i> Logout</button>
      </form>
    </li>
  </ul>
</nav>