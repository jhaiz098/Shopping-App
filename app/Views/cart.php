<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
My Cart
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container py-5">

    <h2 class="mb-4">

        <i class="bi bi-cart3 me-2"></i>
        My Cart

    </h2>

    <?php if(session()->getFlashdata('success')): ?>

        <div class="container mt-3">

            <div class="alert alert-success alert-dismissible fade show shadow-sm">

                <i class="bi bi-check-circle-fill me-2"></i>

                <?= session()->getFlashdata('success') ?>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        </div>

    <?php endif; ?>


    <?php if(session()->getFlashdata('error')): ?>

        <div class="container mt-3">

            <div class="alert alert-danger alert-dismissible fade show shadow-sm">

                <i class="bi bi-exclamation-triangle-fill me-2"></i>

                <?= session()->getFlashdata('error') ?>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        </div>

    <?php endif; ?>

    <?php if(empty($cartItems)): ?>

        <div class="alert alert-info">

            Your cart is empty.

        </div>

    <?php else: ?>

        <?php $grandTotal = 0; ?>

        <div class="card shadow-sm">

            <div class="card-body p-0">

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>
                            <th>Product</th>
                            <th width="120">Price</th>
                            <th width="120">Qty</th>
                            <th width="150">Subtotal</th>
                            <th width="140">Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach($cartItems as $item): ?>

                            <?php
                                $subtotal =
                                    $item['price'] *
                                    $item['quantity'];

                                $grandTotal += $subtotal;
                            ?>

                            <tr>

                                <td>

                                    <div class="d-flex align-items-center">

                                        <?php if(!empty($item['image'])): ?>

                                            <img
                                                src="<?= base_url('uploads/products/' . $item['image']) ?>"
                                                class="border rounded me-3"
                                                style="width:80px;height:80px;object-fit:contain;">

                                        <?php else: ?>

                                            <div
                                                class="border rounded d-flex align-items-center justify-content-center me-3"
                                                style="width:80px;height:80px;">

                                                <i class="bi bi-image"></i>

                                            </div>

                                        <?php endif; ?>

                                        <div>

                                            <strong>

                                                <?= esc($item['name']) ?>

                                            </strong>

                                        </div>

                                    </div>

                                </td>

                                <td>

                                    ₱<?= number_format($item['price'], 2) ?>

                                </td>

                                <td>

                                    <div class="fw-semibold">

                                        <?= $item['quantity'] ?>

                                        <?php if ($item['quantity'] > $item['stock']): ?>

                                            <span class="badge bg-danger ms-2">
                                                Exceeds Stock
                                            </span>

                                        <?php endif; ?>

                                    </div>

                                    <small class="text-muted d-block">

                                        Stock:
                                        <?= $item['stock'] ?>

                                    </small>

                                    <?php if ($item['stock'] <= 0): ?>

                                        <small class="text-danger">
                                            Out of stock
                                        </small>

                                    <?php elseif ($item['quantity'] > $item['stock']): ?>

                                        <small class="text-danger">
                                            Reduce quantity to proceed
                                        </small>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    ₱<?= number_format($subtotal, 2) ?>

                                </td>

                                <td>

                                    <button class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editCartModal<?= $item['id'] ?>">

                                        <i class="bi bi-pencil"></i>

                                    </button>

                                    <button class="btn btn-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteCartModal<?= $item['id'] ?>">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </td>

                            </tr>

                        <div class="modal fade"
                            id="editCartModal<?= $item['id'] ?>"
                            tabindex="-1">

                            <div class="modal-dialog">

                                <form method="post"
                                    action="<?= base_url('cart/update/' . $item['id']) ?>">

                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <h5 class="modal-title">

                                                Update Quantity

                                            </h5>

                                            <button type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal">
                                            </button>

                                        </div>

                                        <div class="modal-body">

                                            <h6>

                                                <?= esc($item['name']) ?>

                                            </h6>

                                            <p class="text-muted mb-3">

                                                Available Stock:
                                                <strong><?= $item['stock'] ?></strong>

                                            </p>

                                            <label class="form-label">

                                                Quantity

                                            </label>

                                            <input type="number"
                                                name="quantity"
                                                class="form-control"
                                                min="1"
                                                max="<?= $item['stock'] ?>"
                                                value="<?= $item['quantity'] ?>"
                                                required>

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

                        <div class="modal fade"
                            id="deleteCartModal<?= $item['id'] ?>"
                            tabindex="-1">

                            <div class="modal-dialog modal-dialog-centered">

                                <div class="modal-content">

                                    <div class="modal-header">

                                        <h5 class="modal-title text-danger">

                                            Remove Item

                                        </h5>

                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal">
                                        </button>

                                    </div>

                                    <div class="modal-body">

                                        Are you sure you want to remove:

                                        <strong>
                                            <?= esc($item['name']) ?>
                                        </strong>
                                        from your cart?

                                    </div>

                                    <div class="modal-footer">

                                        <button class="btn btn-secondary"
                                                data-bs-dismiss="modal">

                                            Cancel

                                        </button>

                                        <a href="<?= base_url('cart/delete/' . $item['id']) ?>"
                                        class="btn btn-danger">

                                            Yes, Remove

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

        <div class="card mt-4 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <h4>Total</h4>

                    <h4 class="text-primary">

                        ₱<?= number_format($grandTotal, 2) ?>

                    </h4>

                </div>

                <div class="text-end mt-3">

                    <button class="btn btn-success"
                            data-bs-toggle="modal"
                            data-bs-target="#checkoutModal">

                        <i class="bi bi-credit-card me-1"></i>
                        Proceed to Checkout

                    </button>

                </div>

            </div>

        </div>

    <?php endif; ?>

</div>

<div class="modal fade"
     id="checkoutModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header">

                <h5 class="modal-title">

                    <i class="bi bi-credit-card me-2"></i>
                    Confirm Checkout

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <p class="mb-2">

                    You are about to place your order.

                </p>

                <div class="alert alert-warning mb-0">

                    <i class="bi bi-exclamation-triangle me-1"></i>

                    Please make sure your cart items and quantities are correct.

                </div>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">

                    Cancel

                </button>

                <a href="<?= base_url('cart/checkout') ?>"
                   class="btn btn-success">

                    <i class="bi bi-check-circle me-1"></i>
                    Yes, Place Order

                </a>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>