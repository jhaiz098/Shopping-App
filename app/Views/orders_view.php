<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
Order Details
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container py-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="mb-0">
                Order #<?= $order['id'] ?>
            </h3>

            <small class="text-muted">

                Placed on
                <?= date('M d, Y', strtotime($order['created_at'] ?? $order['order_date'])) ?>

            </small>

        </div>

        <a href="<?= base_url('orders/my') ?>" class="btn btn-outline-secondary btn-sm">

            <i class="bi bi-arrow-left me-1"></i>
            Back

        </a>

    </div>

    <div class="row">

        <!-- ITEMS -->
        <div class="col-lg-8">

            <div class="card shadow-sm">

                <div class="card-header bg-white">

                    <strong>Items Ordered</strong>

                </div>

                <div class="card-body p-0">

                    <table class="table align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th width="120">Price</th>
                                <th width="80">Qty</th>
                                <th width="120">Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $total = 0; ?>

                            <?php foreach($items as $item): ?>

                                <?php
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $total += $subtotal;
                                ?>

                                <tr>

                                    <td>

                                        <div class="d-flex align-items-center">

                                            <?php if(!empty($item['image'])): ?>

                                                <img src="<?= base_url('uploads/products/' . $item['image']) ?>"
                                                     class="rounded border me-3"
                                                     style="width:60px;height:60px;object-fit:contain;">

                                            <?php else: ?>

                                                <div class="border rounded d-flex align-items-center justify-content-center me-3"
                                                     style="width:60px;height:60px;">

                                                    <i class="bi bi-image"></i>

                                                </div>

                                            <?php endif; ?>

                                            <div>

                                                <div class="fw-semibold">
                                                    <?= esc($item['name']) ?>
                                                </div>

                                            </div>

                                        </div>

                                    </td>

                                    <td>₱<?= number_format($item['price'], 2) ?></td>

                                    <td><?= $item['quantity'] ?></td>

                                    <td>₱<?= number_format($subtotal, 2) ?></td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- SUMMARY -->
        <div class="col-lg-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5 class="mb-3">Summary</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Status</span>

                        <?php
                        $badge = match($order['status']) {
                            'Pending' => 'warning',
                            'Processing' => 'info',
                            'Completed' => 'success',
                            'Cancelled' => 'danger',
                            default => 'secondary'
                        };
                        ?>

                        <span class="badge bg-<?= $badge ?>">
                            <?= $order['status'] ?>
                        </span>

                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Total</span>
                        <strong class="text-primary">
                            ₱<?= number_format($total, 2) ?>
                        </strong>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>