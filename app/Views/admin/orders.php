<?= $this->extend('layouts/admin/admin_layout') ?>

<?= $this->section('title') ?>
Orders
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <h3 class="mb-0">Orders</h3>
        <small class="text-muted">Manage customer orders</small>
    </div>

</div>

<?php if(session()->getFlashdata('error')): ?>

    <div class="alert alert-danger alert-dismissible fade show">

        <?= session()->getFlashdata('error') ?>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

<?php endif; ?>

<?php if(session()->getFlashdata('success')): ?>

    <div class="alert alert-success alert-dismissible fade show">

        <?= session()->getFlashdata('success') ?>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

<?php endif; ?>

<div class="card shadow-sm border-0">

    <div class="card-header bg-white">

        <h5 class="mb-0">
            <i class="bi bi-bag-check me-2"></i>
            Order List
        </h5>

    </div>

    <div class="card-body p-0 table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>
                    <th width="70">#</th>
                    <th>Order Code</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th width="150">Actions</th>
                </tr>

            </thead>

            <tbody>

                <?php if(empty($orders)): ?>

                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No orders found.
                        </td>
                    </tr>

                <?php endif; ?>

                <?php
                    $perPage = 10;
                    $currentPage = $pager->getCurrentPage();
                    $number = 1 + (($currentPage - 1) * $perPage);
                ?>

                <?php foreach($orders as $order): ?>

                    <tr>

                        <td><?= $number++ ?></td>

                        <td>
                            <span class="fw-bold"><?= $order['order_code'] ?></span>
                        </td>

                        <td>
                            <?= esc($order['first_name']) ?>
                            <?= esc($order['last_name']) ?>
                        </td>

                        <td>
                            <?= date('M d, Y', strtotime($order['order_date'])) ?>
                        </td>

                        <td>
                            <span class="fw-semibold text-primary">
                                ₱<?= number_format($order['total_amount'], 2) ?>
                            </span>
                        </td>

                        <td>

                            <?php
                            switch (strtolower($order['status']))
                            {
                                case 'pending':
                                    echo '<span class="badge bg-warning text-dark">
                                            <i class="bi bi-hourglass-split me-1"></i>Pending
                                        </span>';
                                    break;

                                case 'processing':
                                    echo '<span class="badge bg-info text-dark">
                                            <i class="bi bi-gear-fill me-1"></i>Processing
                                        </span>';
                                    break;

                                case 'shipped':
                                    echo '<span class="badge bg-primary">
                                            <i class="bi bi-truck me-1"></i>Shipped
                                        </span>';
                                    break;

                                case 'delivered':
                                    echo '<span class="badge bg-success">
                                            <i class="bi bi-check-circle-fill me-1"></i>Delivered
                                        </span>';
                                    break;

                                case 'cancelled':
                                    echo '<span class="badge bg-danger">
                                            <i class="bi bi-x-circle-fill me-1"></i>Cancelled
                                        </span>';
                                    break;

                                default:
                                    echo '<span class="badge bg-secondary">'
                                        . esc($order['status']) .
                                        '</span>';
                            }
                            ?>

                        </td>

                        <td>

                            <button class="btn btn-sm btn-info"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewOrderModal<?= $order['id'] ?>">

                                <i class="bi bi-eye"></i>

                            </button>

                            <button class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#statusOrderModal<?= $order['id'] ?>">

                                <i class="bi bi-pencil"></i>

                            </button>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

        <?php foreach($orders as $order): ?>
        <!-- VIEW ORDER MODAL -->
        <div class="modal fade"
                id="viewOrderModal<?= $order['id'] ?>"
                tabindex="-1">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Order #<?= $order['id'] ?>
                        </h5>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <!-- ORDER INFO -->
                        <div class="mb-3">

                            <p class="mb-1">
                                <strong>Customer:</strong>
                                <?= esc($order['first_name']) ?>
                                <?= esc($order['last_name']) ?>
                            </p>

                            <p class="mb-1">
                                <strong>Date:</strong>
                                <?= date('M d, Y', strtotime($order['order_date'])) ?>
                            </p>

                            <p class="mb-1">
                                <strong>Total:</strong>
                                ₱<?= number_format($order['total_amount'], 2) ?>
                            </p>

                            <p class="mb-0">

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
                                    <strong>Status:</strong>

                                    <span class="badge <?= $statusConfig['class'] ?>">
                                        <i class="bi <?= $statusConfig['icon'] ?> me-1"></i>
                                        <?= ucfirst($order['status']) ?>
                                    </span>
                                </p>

                            </p>

                        </div>

                        <hr>

                        <!-- ORDER ITEMS -->
                        <h6 class="mb-3">
                            <i class="bi bi-box-seam me-1"></i>
                            Order Items
                        </h6>

                        <?php if(empty($order['items'])): ?>

                            <div class="alert alert-warning py-2 mb-0">
                                No items found for this order.
                            </div>

                        <?php else: ?>

                            <div class="table-responsive">

                                <table class="table table-sm align-middle">

                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Product Code</th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php $grand = 0; $i = 1;?>

                                        <?php foreach($order['items'] as $item): ?>

                                            <?php $subtotal = $item['price'] * $item['quantity']; ?>
                                            <?php $grand += $subtotal; ?>

                                            <tr>
                                                <td>
                                                    <?= $i++ ?>
                                                </td>

                                                <td class="fw-bold">
                                                    <?= $item['product_code'] ?>
                                                </td>


                                                <td>
                                                    <div class="d-flex align-items-center">

                                                        <?php if(!empty($item['image'])): ?>

                                                            <img src="<?= base_url('uploads/products/' . $item['image']) ?>"
                                                                class="rounded border me-2"
                                                                style="width:45px;height:45px;object-fit:cover;">

                                                        <?php else: ?>

                                                            <div class="border rounded d-flex align-items-center justify-content-center me-2"
                                                                style="width:45px;height:45px;">
                                                                <i class="bi bi-image"></i>
                                                            </div>

                                                        <?php endif; ?>

                                                        <span class="small fw-semibold">
                                                            <?= esc($item['name']) ?>
                                                        </span>

                                                    </div>
                                                </td>

                                                <td>₱<?= number_format($item['price'], 2) ?></td>
                                                <td><?= $item['quantity'] ?></td>
                                                <td>₱<?= number_format($subtotal, 2) ?></td>

                                            </tr>

                                        <?php endforeach; ?>

                                    </tbody>

                                    <tfoot>
                                        <tr class="table-light">
                                            <th colspan="5" class="text-end">Total</th>
                                            <th>₱<?= number_format($grand, 2) ?></th>
                                        </tr>
                                    </tfoot>

                                </table>

                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

        <!-- STATUS MODAL -->
        <div class="modal fade"
                id="statusOrderModal<?= $order['id'] ?>"
                tabindex="-1">

            <div class="modal-dialog">

                <form method="post"
                        action="<?= base_url('admin/orders/update/' . $order['id']) ?>">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h5 class="modal-title">
                                Update Status
                            </h5>

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                            </button>

                        </div>

                        <div class="modal-body">

                            <label class="form-label">Status</label>

                            <select name="status" class="form-select">

                                <option value="pending" <?= $order['status']=='pending'?'selected':'' ?>>Pending</option>
                                <option value="processing" <?= $order['status']=='processing'?'selected':'' ?>>Processing</option>
                                <option value="shipped" <?= $order['status']=='shipped'?'selected':'' ?>>Shipped</option>
                                <option value="delivered" <?= $order['status']=='delivered'?'selected':'' ?>>Delivered</option>
                                <option value="cancelled" <?= $order['status']=='cancelled'?'selected':'' ?>>Cancelled</option>

                            </select>

                        </div>

                        <div class="modal-footer">

                            <button type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button type="submit"
                                    class="btn btn-primary">
                                Update
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>
        <?php endforeach; ?>

    </div>

    <!-- PAGINATION -->
    <div class="d-flex justify-content-center p-3">

        <?= $pager->links('default', 'bootstrap_full') ?>

    </div>

</div>

<?= $this->endSection() ?>