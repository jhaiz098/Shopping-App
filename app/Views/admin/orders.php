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
                    <th>Order ID</th>
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
                            <span class="fw-bold">#<?= $order['id'] ?></span>
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

                                    <p>
                                        <strong>Customer:</strong>
                                        <?= esc($order['first_name']) ?>
                                        <?= esc($order['last_name']) ?>
                                    </p>

                                    <p>
                                        <strong>Date:</strong>
                                        <?= date('M d, Y', strtotime($order['order_date'])) ?>
                                    </p>

                                    <p>
                                        <strong>Total:</strong>
                                        ₱<?= number_format($order['total_amount'], 2) ?>
                                    </p>

                                    <p>
                                        <strong>Status:</strong>
                                        <?= $order['status'] ?>
                                    </p>

                                    <hr>

                                    <p class="text-muted">
                                        Order items will be loaded here (join order_items table).
                                    </p>

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

                                            <option value="Pending" <?= $order['status']=='Pending'?'selected':'' ?>>Pending</option>
                                            <option value="Processing" <?= $order['status']=='Processing'?'selected':'' ?>>Processing</option>
                                            <option value="Completed" <?= $order['status']=='Completed'?'selected':'' ?>>Completed</option>
                                            <option value="Cancelled" <?= $order['status']=='Cancelled'?'selected':'' ?>>Cancelled</option>

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

            </tbody>

        </table>

    </div>

    <!-- PAGINATION -->
    <div class="d-flex justify-content-center p-3">

        <?= $pager->links('default', 'bootstrap_full') ?>

    </div>

</div>

<?= $this->endSection() ?>