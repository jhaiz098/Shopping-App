<?= $this->extend('layouts/admin/admin_layout') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <h2 class="fw-bold mb-4">

        <i class="bi bi-speedometer2 me-2"></i>
        Dashboard

    </h2>

    <div class="row">

        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6 class="text-muted">
                                Products
                            </h6>

                            <h3 class="fw-bold">
                                0
                            </h3>

                        </div>

                        <i class="bi bi-box-seam fs-1 text-primary"></i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6 class="text-muted">
                                Categories
                            </h6>

                            <h3 class="fw-bold">
                                0
                            </h3>

                        </div>

                        <i class="bi bi-folder fs-1 text-success"></i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6 class="text-muted">
                                Orders
                            </h6>

                            <h3 class="fw-bold">
                                0
                            </h3>

                        </div>

                        <i class="bi bi-cart-check fs-1 text-warning"></i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6 class="text-muted">
                                Customers
                            </h6>

                            <h3 class="fw-bold">
                                0
                            </h3>

                        </div>

                        <i class="bi bi-people fs-1 text-danger"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <h5 class="mb-3">
                Welcome to StudentHub Admin Panel
            </h5>

            <p class="text-muted mb-0">

                Manage products, categories, orders, and customers from this dashboard.

            </p>

        </div>

    </div>

</div>

<?= $this->endSection() ?>