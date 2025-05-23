<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <!-- Sidebar Toggle Button -->
    <button id="sidebarToggle" class="btn btn-dark">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Branding -->
    <a class="navbar-brand ms-3" href="#">Center for Professional Courses</a>

    <!-- Mobile Navbar Toggler -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
      aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Items -->
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <!-- Notifications -->
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fas fa-bell me-2"></i>
            <span class="d-inline d-lg-none ms-2">Notifications</span>
          </a>
        </li>
        <!-- Messages -->
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fas fa-envelope me-2"></i>
            <span class="d-inline d-lg-none ms-2">Messages</span>
          </a>
        </li>
        <!-- Dark Mode Toggle -->
        <li class="nav-item">
          <a class="nav-link">
            <button id="darkModeToggle" class="btn btn-sm btn-outline-light">
              🌙 Dark Mode
            </button>
          </a>
        </li>
        <!-- User Profile Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="fas fa-user-circle me-2"></i> <?= session()->get('full_name') ?>
            <span class="badge bg-primary"> <?= session()->get('role') ?> </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item" href="<?= site_url('users/edit/' . session()->get('user_id')) ?>">
                <i class="fas fa-user me-2"></i> Profile
              </a>
            </li>
            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item text-danger" href="/logout"><i class="fas fa-sign-out-alt me-2"></i> Log Out</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>