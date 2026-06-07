<?= $this->extend('layouts/admin/admin_layout') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- FIRST ROW -->
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

<!-- SECOND ROW -->
<div class="row">

    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-info">
            <div class="inner">
                <h3>₱<?= number_format($totalRevenue ?? 0, 2) ?></h3>
                <p>Total Revenue</p>
            </div>
            <div class="small-box-icon">
                <i class="bi bi-cash-stack"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-secondary">
            <div class="inner">
                <h3><?= $pendingOrders ?? 0 ?></h3>
                <p>Pending Orders</p>
            </div>
            <div class="small-box-icon">
                <i class="bi bi-hourglass-split"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-warning">
            <div class="inner">
                <h3><?= $lowStockProducts ?? 0 ?></h3>
                <p>Low Stock</p>
            </div>
            <div class="small-box-icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-dark">
            <div class="inner">
                <h3><?= $outOfStockProducts ?? 0 ?></h3>
                <p>Out of Stock</p>
            </div>
            <div class="small-box-icon">
                <i class="bi bi-x-circle"></i>
            </div>
        </div>
    </div>

</div>

<!-- RECENT ORDERS -->
<div class="card mt-3">

    <div class="card-header">
        <strong>Recent Orders</strong>
    </div>

    <div class="card-body p-0">

        <table class="table table-hover mb-0">

            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                <?php if(!empty($recentOrders)): ?>

                    <?php foreach($recentOrders as $order): ?>

                        <tr>

                            <td>
                                ORD-<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?>
                            </td>

                            <td>
                                <?= esc($order['first_name']) ?>
                                <?= esc($order['last_name']) ?>
                            </td>

                            <td>
                                ₱<?= number_format($order['total_amount'], 2) ?>
                            </td>

                            <td>

                                <?php
                                $status = strtolower($order['status']);

                                $statusConfig = match($status) {
                                    'pending' => [
                                        'class' => 'bg-warning text-dark',
                                        'icon'  => 'bi-hourglass-split'
                                    ],
                                    'processing' => [
                                        'class' => 'bg-info text-dark',
                                        'icon'  => 'bi-gear'
                                    ],
                                    'shipped' => [
                                        'class' => 'bg-primary',
                                        'icon'  => 'bi-truck'
                                    ],
                                    'delivered' => [
                                        'class' => 'bg-success',
                                        'icon'  => 'bi-check-circle'
                                    ],
                                    'cancelled' => [
                                        'class' => 'bg-danger',
                                        'icon'  => 'bi-x-circle'
                                    ],
                                    default => [
                                        'class' => 'bg-secondary',
                                        'icon'  => 'bi-question-circle'
                                    ]
                                };
                                ?>

                                <p class="mb-0">
                                    <span class="badge <?= $statusConfig['class'] ?>">
                                        <i class="bi <?= $statusConfig['icon'] ?> me-1"></i>
                                        <?= ucfirst($order['status']) ?>
                                    </span>
                                </p>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="4" class="text-center">
                            No orders found.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?= $this->endSection() ?>