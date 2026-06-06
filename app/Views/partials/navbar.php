<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">

        <a class="navbar-brand fw-bold text-primary" href="<?= base_url('/') ?>">
            <i class="bi bi-mortarboard-fill me-2"></i>
            StudentHub
        </a>

        <form action="<?= base_url('search') ?>" method="get" class="d-flex w-50">

            <input
                class="form-control"
                type="search"
                name="keyword"
                placeholder="Search school supplies..."
                value="<?= esc($_GET['keyword'] ?? '') ?>">

        </form>

        <div class="d-flex align-items-center gap-2">

            <?php if(session()->get('isLoggedIn')): ?>

                <div class="dropdown">

                    <button
                        class="btn btn-outline-primary dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown">

                        <i class="bi bi-person-circle me-1"></i>

                        <?= esc(session()->get('first_name')) ?>
                        <?= esc(session()->get('last_name')) ?>

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a class="dropdown-item" href="<?= base_url('profile') ?>">
                                <i class="bi bi-person me-2"></i>
                                Profile
                            </a>
                        </li>

                        <?php if(session()->get('role') !== 'admin'): ?>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('orders/my') ?>">
                                <i class="bi bi-bag me-2"></i>
                                My Orders
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if(session()->get('role') === 'admin'): ?>

                            <li>
                                <a class="dropdown-item" href="<?= base_url('admin') ?>">
                                    <i class="bi bi-speedometer2 me-2"></i>
                                    Dashboard
                                </a>
                            </li>

                        <?php endif; ?>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a
                                class="dropdown-item text-danger"
                                href="<?= base_url('logout') ?>">

                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout

                            </a>
                        </li>

                    </ul>

                </div>

            <?php else: ?>

                <a href="<?= base_url('login') ?>" class="btn btn-outline-primary">
                    <i class="bi bi-box-arrow-in-right me-1"></i>
                    Sign In
                </a>

                <a href="<?= base_url('register') ?>" class="btn btn-primary">
                    <i class="bi bi-person-plus-fill me-1"></i>
                    Sign Up
                </a>

            <?php endif; ?>
            
            <?php if(session()->get('role') !== 'admin'): ?>
            <a href="<?= base_url('cart') ?>" class="btn btn-outline-dark position-relative">

                <i class="bi bi-cart3"></i>

                <?php if($cartCount > 0): ?>

                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                        <?= $cartCount ?>

                    </span>

                <?php endif; ?>

            </a>
            <?php endif; ?>

        </div>

    </div>
</nav>