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
                            <th width="80"></th>
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

                                    <?= $item['quantity'] ?>

                                </td>

                                <td>

                                    ₱<?= number_format($subtotal, 2) ?>

                                </td>

                                <td>

                                    <a href="<?= base_url('cart/remove/' . $item['id']) ?>"
                                       class="btn btn-danger btn-sm">

                                        <i class="bi bi-trash"></i>

                                    </a>

                                </td>

                            </tr>

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

                    <a href="<?= base_url('checkout') ?>"
                       class="btn btn-success">

                        <i class="bi bi-credit-card me-1"></i>
                        Proceed to Checkout

                    </a>

                </div>

            </div>

        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>