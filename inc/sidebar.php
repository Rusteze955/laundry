<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link collapsed" href="home.php">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="?page=customer" class="text-light">
            <i class="bi bi-circle"></i><span>Customer</span>
          </a>
        </li>
        <li>
          <a href="?page=jenis-service" class="text-light">
            <i class="bi bi-circle"></i><span>Jenis Service</span>
          </a>
        </li>
        <li>
          <a href="?page=user" class="text-light">
            <i class="bi bi-circle"></i><span>User</span>
          </a>
        </li>
      </ul>
    </li><!-- End Components Nav -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="?page=report">
        <i class="bi bi-bar-chart"></i>
        <span>Report</span>
      </a>
    </li>

    <li class="nav-heading text-white">Pages</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="?page=order">
        <i class="bi bi-person"></i>
        <span>Order</span>
      </a>
    </li><!-- End Profile Page Nav -->
  </ul>

</aside>