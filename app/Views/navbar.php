<?php
$current_url = service('uri')->getSegment(1); // Get the first segment of the URL
?>

<!-- Sidebar -->
<nav class="text-white p-3">
  <section class="logo-section">
    <img class="logo" src="/assets/Images/Icons/gulogo.png" alt="logo" />
    <section class="text-left">

      <h5 class=" d-none d-md-block">CPC ORBIT</h5>
      <p>Center For Professional Courses</p>
    </section>
  </section>

  <hr>


  <ul class="nav  flex-column d-block">

    <li class="nav-item"><a class="nav-link text-white <?= ($current_url == 'dashboard') ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">Dashboard</a></li>

    <?php if (session()->get('role') == 'Superadmin'): ?>
      <li class="nav-item"><a class="nav-link text-white <?= ($current_url == 'coordinators') ? 'active' : '' ?>" href="<?= site_url('coordinators') ?>">Manage Coordinator</a></li>
    <?php endif; ?>

    <?php if (session()->get('role') == 'Superadmin'): ?>
      <li class="nav-item"><a class="nav-link text-white <?= ($current_url == 'users') ? 'active' : '' ?>" href="<?= site_url('users') ?>">Users</a></li>
    <?php endif; ?>

    <?php if (session()->get('role') == 'Superadmin'): ?>
      <li class="nav-item"><a class="nav-link text-white <?= ($current_url == 'colleges') ? 'active' : '' ?>" href="<?= site_url('colleges') ?>">Colleges</a></li>
    <?php endif; ?>


    <?php if (in_array(session()->get('role'), ['Superadmin'])): ?>
      <li class="nav-item"><a class="nav-link text-white <?= ($current_url == 'programs') ? 'active' : '' ?>" href="<?= site_url('programs') ?>">Programs</a></li>
    <?php endif; ?>

    <?php if (in_array(session()->get('role'), ['Superadmin', 'Coordinator'])): ?>
      <li class="nav-item"><a class="nav-link text-white <?= ($current_url == 'subjects') ? 'active' : '' ?>" href="<?= site_url('subjects') ?>">Subjects</a></li>
    <?php endif; ?>


    <?php if (in_array(session()->get('role'), ['Superadmin', 'Coordinator'])): ?>
      <li class="nav-item"><a class="nav-link text-white <?= ($current_url == 'students') ? 'active' : '' ?>" href="<?= site_url('students') ?>">Students</a></li>
    <?php endif; ?>

    <?php if (in_array(session()->get('role'), ['Superadmin', 'Coordinator', 'Faculty'])): ?>
      <li class="nav-item"><a class="nav-link text-white <?= ($current_url == 'Attendance') ? 'active' : '' ?>" href="<?= site_url('programs') ?>">Attendance</a></li>
    <?php endif; ?>

    <li>
      <form action="/logout">
        <button>Logout</button>
      </form>
    </li>


  </ul>




</nav>