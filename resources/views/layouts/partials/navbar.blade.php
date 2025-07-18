  <!-- Navbar -->

  <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
      id="layout-navbar">
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
          <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
              <i class="icon-base ti tabler-menu-2 icon-md"></i>
          </a>
      </div>

      <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
          <ul class="navbar-nav flex-row align-items-center ms-md-auto">
              <!-- User -->
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                      data-bs-toggle="dropdown">
                      <div class="avatar avatar-online">
                          <img src="{{ asset('/') }}assets/img/avatars/1.png" alt class="rounded-circle" />
                      </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                          <a class="dropdown-item" href="#">
                              <div class="d-flex">
                                  <div class="flex-shrink-0 me-3">
                                      <div class="avatar avatar-online">
                                          <img src="{{ asset('/') }}assets/img/avatars/1.png" alt
                                              class="w-px-40 h-auto rounded-circle" />
                                      </div>
                                  </div>
                                  <div class="flex-grow-1">
                                      <h6 class="mb-0">John Doe</h6>
                                      <small class="text-body-secondary">Admin</small>
                                  </div>
                              </div>
                          </a>
                      </li>
                      <li>
                          <div class="dropdown-divider my-1 mx-n2"></div>
                      </li>

                      <li>
                          <a class="dropdown-item" href="{{ route('logout') }}">
                              <i class="icon-base ti tabler-power icon-md me-3"></i><span>Log
                                  Out</span>
                          </a>
                      </li>
                  </ul>
              </li>
              <!--/ User -->
          </ul>
      </div>
  </nav>

  <!-- / Navbar -->
