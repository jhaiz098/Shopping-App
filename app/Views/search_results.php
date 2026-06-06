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

                    <div class="card-body">

                        <h5>

                            <?= esc($product['name']) ?>

                        </h5>

                        <p class="text-muted">

                            ₱<?= number_format($product['price'], 2) ?>

                        </p>

                        <a href="<?= base_url('cart/add/' . $product['id']) ?>"
                        class="btn btn-primary w-100">

                            <i class="bi bi-cart-plus me-1"></i>
                            Add to Cart

                        </a>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<?= $this->endSection() ?>