<nav class="app-header navbar navbar-expand bg-body">

    <div class="container-fluid">

        <ul class="navbar-nav">

            <li class="nav-item">

                <a class="nav-link"
                   data-lte-toggle="sidebar"
                   href="#">

                    <i class="bi bi-list"></i>

                </a>

            </li>

        </ul>

        <ul class="navbar-nav ms-auto">

            <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle"
                   data-bs-toggle="dropdown"
                   href="#">

                    <i class="bi bi-person-circle me-1"></i>

                    <?= session()->get('first_name') ?>

                </a>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <a class="dropdown-item"
                           href="<?= base_url('/') ?>">

                            <i class="bi bi-house me-2"></i>
                            Homepage

                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                           href="<?= base_url('profile') ?>">

                            <i class="bi bi-person me-2"></i>
                            Profile

                        </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>

                        <a class="dropdown-item text-danger"
                           href="<?= base_url('logout') ?>">

                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout

                        </a>

                    </li>

                </ul>

            </li>

        </ul>

    </div>

</nav>