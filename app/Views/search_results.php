<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
Search
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container py-5">

    <h2 class="mb-4">

        Search Results for:

        <span class="text-primary">
            "<?= esc($keyword) ?>"
        </span>

    </h2>

    <?php if(session()->getFlashdata('error')): ?>

        <div class="alert alert-danger alert-dismissible fade show">

            <?= session()->getFlashdata('error') ?>

            <button class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    <?php endif; ?>

    <?php if(session()->getFlashdata('success')): ?>

        <div class="alert alert-success alert-dismissible fade show">

            <?= session()->getFlashdata('success') ?>

            <button class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    <?php endif; ?>

    <div class="row">

        <?php if(empty($products)): ?>

            <div class="col-12">

                <div class="alert alert-warning">

                    No products found.

                </div>

            </div>

        <?php endif; ?>

        <?php foreach($products as $product): ?>

            <div class="col-md-3 mb-4">

                <div class="card h-100 shadow-sm">

                    <!-- IMAGE -->
                    <?php if(!empty($product['image'])): ?>

                        <img
                            src="<?= base_url('uploads/products/' . $product['image']) ?>"
                            class="card-img-top p-2"
                            style="height:220px; object-fit:contain;">

                    <?php else: ?>

                        <div class="d-flex align-items-center justify-content-center bg-light"
                            style="height:220px;">

                            <i class="bi bi-image text-secondary"
                            style="font-size:4rem;"></i>

                        </div>

                    <?php endif; ?>

                    <div class="card-body d-flex flex-column">

                        <!-- CATEGORY -->
                        <span class="badge bg-secondary mb-2">
                            <?= esc($product['category_name'] ?? 'Uncategorized') ?>
                        </span>

                        <!-- PRODUCT CODE -->
                        <p class="text-muted small mb-1">
                            <span class="fw-bold">Product Code:</span> <?= esc($product['product_code']) ?>
                        </p>

                        <!-- PRODUCT NAME -->
                        <h5 class="mb-1">
                            <span class="fw-bold">Name:</span><?= esc($product['name']) ?>
                        </h5>

                        <!-- STOCK -->
                        <small class="mb-2">

                            <?php if($product['stock'] > 10): ?>
                                <span class="text-success fw-semibold">
                                    In Stock: <?= $product['stock'] ?>
                                </span>

                            <?php elseif($product['stock'] > 0): ?>
                                <span class="text-warning fw-semibold">
                                    Low Stock: <?= $product['stock'] ?>
                                </span>

                            <?php else: ?>
                                <span class="text-danger fw-semibold">
                                    Out of Stock
                                </span>
                            <?php endif; ?>

                        </small>

                        <!-- PRICE -->
                        <p class="text-muted mb-3">
                            ₱<?= number_format($product['price'], 2) ?>
                        </p>

                        <?php if(session()->get('role') !== 'admin'): ?>
                        <!-- BUTTON -->
                        <button
                            class="btn btn-primary w-100 mt-auto"
                            data-bs-toggle="modal"
                            data-bs-target="#cartModal<?= $product['id'] ?>"
                            <?= ($product['stock'] <= 0) ? 'disabled' : '' ?>>

                            <i class="bi bi-cart-plus me-1"></i>
                            Add to Cart

                        </button>
                        <?php endif; ?>

                    </div>

                </div>

            </div>
            
            <?= view('partials/add_to_cart_modal', [
                'product' => $product
            ]) ?>
        <?php endforeach; ?>

        <div class="d-flex justify-content-center mt-3">

            <?= $pager->links('default', 'bootstrap_full') ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>