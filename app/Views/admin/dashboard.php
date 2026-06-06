<?= $this->extend('layouts/admin/admin_layout') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">

    <div class="col-lg-3 col-6">

        <div class="small-box text-bg-primary">

            <div class="inner">

                <h3><?= $categoriesCount ?></h3>

                <p>Categories</p>

            </div>

            <div class="small-box-icon">

                <i class="bi bi-tags"></i>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-6">

        <div class="small-box text-bg-success">

            <div class="inner">

                <h3><?= $productsCount ?></h3>

                <p>Products</p>

            </div>

            <div class="small-box-icon">

                <i class="bi bi-box-seam"></i>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-6">

        <div class="small-box text-bg-warning">

            <div class="inner">

                <h3><?= $ordersCount ?></h3>

                <p>Orders</p>

            </div>

            <div class="small-box-icon">

                <i class="bi bi-bag"></i>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-6">

        <div class="small-box text-bg-danger">

            <div class="inner">

                <h3><?= $usersCount ?></h3>

                <p>Users</p>

            </div>

            <div class="small-box-icon">

                <i class="bi bi-people"></i>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>