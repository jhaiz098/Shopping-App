<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
Homepage
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<section class="hero-section py-5">
    <div class="container text-center py-5">

        <i class="bi bi-backpack2-fill display-1"></i>

        <h1 class="display-4 fw-bold mt-3">
            Everything You Need for School
        </h1>

        <p class="lead">
            Shop notebooks, pens, folders, calculators, and more.
        </p>

        <a href="#" class="btn btn-light btn-lg me-2">
            Shop Now
        </a>

        <a href="<?= base_url('search') ?>" class="btn btn-outline-light btn-lg">
            Browse Products
        </a>

    </div>
</section>

<!-- Categories -->
<section class="py-5">
    <div class="container">

        <h2 class="mb-4 text-center fw-bold">
            Categories
        </h2>

        <div class="row text-center">

            <?php foreach($categories as $category): ?>

            <div class="col-md-3 mb-3">

                <div class="card category-card p-4 shadow-sm">

                    <i class="bi bi-tags category-icon text-primary"></i>

                    <h5 class="mt-3">
                        <?= esc($category['name']) ?>
                    </h5>

                </div>

            </div>

            <?php endforeach; ?>

        </div>

    </div>
</section>

<!-- Featured Products -->
<section class="py-5 bg-light">
    <div class="container">

        <h2 class="mb-4 text-center fw-bold">
            Featured Products
        </h2>

        <div class="row">

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

                            <!-- PRODUCT NAME -->
                            <h5 class="mb-1">
                                <?= esc($product['name']) ?>
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

                            <!-- BUTTON -->
                            <button
                                class="btn btn-primary w-100 mt-auto"
                                data-bs-toggle="modal"
                                data-bs-target="#cartModal<?= $product['id'] ?>"
                                <?= ($product['stock'] <= 0) ? 'disabled' : '' ?>>

                                <i class="bi bi-cart-plus me-1"></i>
                                Add to Cart

                            </button>

                        </div>

                    </div>

                </div>

                <?= view('partials/add_to_cart_modal', [
                    'product' => $product
                ]) ?>

            <?php endforeach; ?>

        </div>

    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5">
    <div class="container text-center">

        <h2 class="fw-bold mb-5">
            Why Choose StudentHub?
        </h2>

        <div class="row mt-4">

            <div class="col-md-4">

                <i class="bi bi-cash-coin feature-icon text-success"></i>

                <h5>
                    Affordable Prices
                </h5>

                <p>
                    School supplies at student-friendly prices.
                </p>

            </div>

            <div class="col-md-4">

                <i class="bi bi-lightning-charge-fill feature-icon text-warning"></i>

                <h5>
                    Easy Ordering
                </h5>

                <p>
                    Simple and convenient shopping experience.
                </p>

            </div>

            <div class="col-md-4">

                <i class="bi bi-shield-check feature-icon text-primary"></i>

                <h5>
                    Quality Products
                </h5>

                <p>
                    Reliable supplies for everyday school needs.
                </p>

            </div>

        </div>

    </div>
</section>



<?= $this->endSection() ?>