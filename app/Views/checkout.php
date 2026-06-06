<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
Checkout
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container py-5">

    <h2 class="mb-4">
        <i class="bi bi-credit-card me-2"></i>
        Checkout
    </h2>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="row">

        <!-- LEFT: ORDER ITEMS -->
        <div class="col-lg-8">

            <div class="card shadow-sm mb-4">

                <div class="card-header bg-white">
                    <strong>Order Summary</strong>
                </div>

                <div class="card-body p-0">

                    <table class="table align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th width="120">Price</th>
                                <th width="100">Qty</th>
                                <th width="120">Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $total = 0; ?>

                            <?php foreach($cartItems as $item): ?>

                                <?php
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $total += $subtotal;
                                ?>

                                <tr>

                                    <td>
                                        <div class="d-flex align-items-center">

                                            <?php if(!empty($item['image'])): ?>
                                                <img src="<?= base_url('uploads/products/' . $item['image']) ?>"
                                                     class="rounded border me-2"
                                                     style="width:60px;height:60px;object-fit:contain;">
                                            <?php else: ?>
                                                <div class="border rounded d-flex align-items-center justify-content-center me-2"
                                                     style="width:60px;height:60px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            <?php endif; ?>

                                            <div>
                                                <strong><?= esc($item['name']) ?></strong><br>

                                                <!-- STOCK DISPLAY -->
                                                <small class="text-muted">
                                                    Stock:
                                                    <?php if($item['stock'] > 10): ?>
                                                        <span class="text-success"><?= $item['stock'] ?></span>
                                                    <?php elseif($item['stock'] > 0): ?>
                                                        <span class="text-warning"><?= $item['stock'] ?> (Low)</span>
                                                    <?php else: ?>
                                                        <span class="text-danger">Out of stock</span>
                                                    <?php endif; ?>
                                                </small>

                                            </div>

                                        </div>
                                    </td>

                                    <td>₱<?= number_format($item['price'], 2) ?></td>

                                    <td><?= $item['quantity'] ?></td>

                                    <td>
                                        ₱<?= number_format($subtotal, 2) ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- RIGHT: SUMMARY -->
        <div class="col-lg-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5 class="mb-3">Payment Summary</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>₱<?= number_format($total, 2) ?></span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span class="text-muted">Free</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span class="text-primary">
                            ₱<?= number_format($total, 2) ?>
                        </span>
                    </div>

                    <form method="post"
                          action="<?= base_url('cart/checkout/confirm') ?>">

                        <button type="submit"
                                class="btn btn-success w-100 mt-4">

                            <i class="bi bi-check-circle me-1"></i>
                            Place Order

                        </button>

                    </form>

                    <a href="<?= base_url('cart') ?>"
                       class="btn btn-outline-secondary w-100 mt-2">

                        Back to Cart

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>