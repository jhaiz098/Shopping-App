<aside class="app-sidebar bg-dark shadow"
       data-bs-theme="dark">

    <div class="sidebar-brand">

        <a href="<?= base_url('admin') ?>"
           class="brand-link">

            <i class="bi bi-mortarboard-fill fs-4 me-2"></i>

            <span class="brand-text fw-light">
                StudentHub
            </span>

        </a>

    </div>

    <div class="sidebar-wrapper">

        <nav class="mt-2">

            <ul class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="menu">

                <li class="nav-item">

                    <a href="<?= base_url('admin') ?>"
                       class="nav-link">

                        <i class="nav-icon bi bi-speedometer2"></i>

                        <p>Dashboard</p>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="<?= base_url('admin/categories') ?>"
                       class="nav-link">

                        <i class="nav-icon bi bi-tags"></i>

                        <p>Categories</p>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="<?= base_url('admin/products') ?>"
                       class="nav-link">

                        <i class="nav-icon bi bi-box-seam"></i>

                        <p>Products</p>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="<?= base_url('admin/orders') ?>"
                       class="nav-link">

                        <i class="nav-icon bi bi-bag"></i>

                        <p>Orders</p>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="<?= base_url('admin/users') ?>"
                       class="nav-link">

                        <i class="nav-icon bi bi-people"></i>

                        <p>Users</p>

                    </a>

                </li>

            </ul>

        </nav>

    </div>

</aside>