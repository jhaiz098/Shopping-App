<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
My Orders
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container py-5">

    <h2 class="mb-4">
        <i class="bi bi-bag me-2"></i>
        My Orders
    </h2>

    <?php if(empty($orders)): ?>

        <div class="alert alert-info">
            You have no orders yet.
        </div>

    <?php else: ?>

        <div class="card shadow-sm">

            <div class="card-body p-0">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Order Code</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $perPage = 10;
                        $currentPage = $pager->getCurrentPage();
                        $number = 1 + (($currentPage - 1) * $perPage);
                        ?>

                        <?php foreach($orders as $order): ?>

                            <tr>

                                <td><?= $number ?></td>

                                <td class="fw-bold">
                                    <?= $order['order_code'] ?>
                                </td>

                                <td>
                                    <?= date('M d, Y', strtotime($order['created_at'] ?? $order['order_date'])) ?>
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

                                <td>
                                    <a href="<?= base_url('orders/view/' . $order['id']) ?>"
                                    class="btn btn-primary btn-sm"
                                    data-bs-toggle="tooltip"
                                    title="View Items">

                                        <i class="bi bi-eye"></i>

                                    </a>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

                <div class="d-flex justify-content-center mt-3">

                    <?= $pager->links('default', 'bootstrap_full') ?>

                </div>

            </div>

        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>