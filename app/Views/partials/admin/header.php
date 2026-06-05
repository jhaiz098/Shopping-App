<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">

    <div class="container-fluid">

        <span class="navbar-brand fw-bold">
            <i class="bi bi-mortarboard-fill me-2"></i>
            StudentHub Admin
        </span>

        <div class="ms-auto d-flex align-items-center gap-3">

            <span class="text-white">

                <i class="bi bi-person-circle me-1"></i>

                <?= session()->get('first_name') ?>
                <?= session()->get('last_name') ?>

            </span>

            <a href="<?= base_url('logout') ?>"
               class="btn btn-light btn-sm">

                <i class="bi bi-box-arrow-right"></i>
                Logout

            </a>

        </div>

    </div>

</nav>