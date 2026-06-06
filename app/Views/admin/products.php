<?= $this->extend('layouts/admin/admin_layout') ?>

<?= $this->section('title') ?>
Products
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">

    <div>

        <h3 class="mb-0">

            Products

        </h3>

        <small class="text-muted">

            Manage store products

        </small>

    </div>

    <button class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createProductModal">

        <i class="bi bi-plus-circle me-1"></i>
        Add Product

    </button>

</div>

<?php if(session()->getFlashdata('errors')): ?>

    <div class="alert alert-danger alert-dismissible fade show">

        <strong>

            Please fix the following errors:

        </strong>

        <ul class="mb-0 mt-2">

            <?php
                $errors = session()->getFlashdata('errors');

                if(!is_array($errors))
                {
                    $errors = [$errors];
                }
            ?>

            <?php foreach($errors as $error): ?>

                <li><?= esc($error) ?></li>

            <?php endforeach; ?>

        </ul>

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

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            <i class="bi bi-box-seam me-2"></i>
            Product List

        </h3>

    </div>

    <div class="card-body p-0">

        <table class="table table-hover align-middle mb-0">

            <thead>

                <tr>
                    <th width="70">#</th>
                    <th width="100">Image</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th width="150">Actions</th>
                </tr>

            </thead>

            <tbody>

                <?php if(empty($products)): ?>

                    <tr>

                        <td colspan="7"
                            class="text-center text-muted py-4">

                            No products found.

                        </td>

                    </tr>

                <?php endif; ?>

                <?php
                    $perPage = 10;
                    $currentPage = $pager->getCurrentPage();
                    $number = (($currentPage - 1) * $perPage) + 1;
                ?>

                <?php foreach($products as $product): ?>

                    <tr>

                        <td>
                            <?= $number++ ?>
                        </td>

                        <td>

                            <?php if(!empty($product['image'])): ?>

                                <img
                                    src="<?= base_url('uploads/products/' . $product['image']) ?>"
                                    class="rounded shadow-sm border"
                                    style="
                                        width:70px;
                                        height:70px;
                                        object-fit:cover;
                                    ">

                            <?php else: ?>

                                <div
                                    class="d-flex align-items-center justify-content-center bg-light border rounded shadow-sm"
                                    style="
                                        width:70px;
                                        height:70px;
                                    ">

                                    <i class="bi bi-image text-secondary fs-3"></i>

                                </div>

                            <?php endif; ?>

                        </td>

                        <td>

                            <div class="fw-semibold">

                                <?= esc($product['name']) ?>

                            </div>

                            <small class="text-muted">

                                <?= strlen($product['description']) > 50
                                    ? esc(substr($product['description'],0,50)) . '...'
                                    : esc($product['description']) ?>

                            </small>

                        </td>

                        <td>

                            <span class="badge bg-info">

                                <?= esc($product['category_name']) ?>

                            </span>

                        </td>

                        <td>

                            ₱<?= number_format($product['price'], 2) ?>

                        </td>

                        <td>

                            <?php if($product['stock'] > 10): ?>

                                <span class="badge bg-success">

                                    <?= $product['stock'] ?>

                                </span>

                            <?php elseif($product['stock'] > 0): ?>

                                <span class="badge bg-warning">

                                    <?= $product['stock'] ?>

                                </span>

                            <?php else: ?>

                                <span class="badge bg-danger">

                                    Out of Stock

                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <button class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editProductModal<?= $product['id'] ?>">

                                <i class="bi bi-pencil"></i>

                            </button>

                            <button class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteProductModal<?= $product['id'] ?>">

                                <i class="bi bi-trash"></i>

                            </button>

                        </td>

                    </tr>
                
                <!-- EDIT PRODUCT MODAL -->
                <div class="modal fade"
                    id="editProductModal<?= $product['id'] ?>"
                    tabindex="-1">

                    <div class="modal-dialog modal-lg">

                        <form method="post"
                            enctype="multipart/form-data"
                            action="<?= base_url('admin/products/update/' . $product['id']) ?>">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title">

                                        <i class="bi bi-pencil-square me-2"></i>
                                        Edit Product

                                    </h5>

                                    <button type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal">
                                    </button>

                                </div>

                                <div class="modal-body">

                                    <div class="row">

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Product Name
                                            </label>

                                            <input type="text"
                                                name="name"
                                                class="form-control"
                                                value="<?= esc($product['name']) ?>"
                                                required>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Category
                                            </label>

                                            <select name="category_id"
                                                    class="form-select"
                                                    required>

                                                <?php foreach($categories as $category): ?>

                                                    <option
                                                        value="<?= $category['id'] ?>"
                                                        <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>

                                                        <?= esc($category['name']) ?>

                                                    </option>

                                                <?php endforeach; ?>

                                            </select>

                                        </div>

                                    </div>

                                    <div class="mb-3">

                                        <label class="form-label">
                                            Description
                                        </label>

                                        <textarea name="description"
                                                rows="4"
                                                class="form-control"><?= esc($product['description']) ?></textarea>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Price
                                            </label>

                                            <div class="input-group">

                                                <span class="input-group-text">
                                                    ₱
                                                </span>

                                                <input type="number"
                                                    step="0.01"
                                                    min="0"
                                                    name="price"
                                                    value="<?= $product['price'] ?>"
                                                    class="form-control"
                                                    required>

                                            </div>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Stock
                                            </label>

                                            <input type="number"
                                                min="0"
                                                name="stock"
                                                value="<?= $product['stock'] ?>"
                                                class="form-control"
                                                required>

                                        </div>

                                    </div>

                                    <?php if(!empty($product['image'])): ?>

                                        <div class="mb-3">

                                            <label class="form-label">
                                                Current Image
                                            </label>

                                            <div>

                                                <img
                                                    src="<?= base_url('uploads/products/' . $product['image']) ?>"
                                                    width="120"
                                                    class="img-thumbnail">

                                            </div>

                                        </div>

                                    <?php endif; ?>

                                    <div class="mb-3">

                                        <label class="form-label">
                                            Replace Image
                                        </label>

                                        <input type="file"
                                            name="image"
                                            class="form-control"
                                            accept="image/*">

                                        <small class="text-muted">
                                            Leave blank to keep existing image.
                                        </small>

                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <button type="button"
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal">

                                        Cancel

                                    </button>

                                    <button type="submit"
                                            class="btn btn-warning">

                                        <i class="bi bi-check-circle me-1"></i>
                                        Update Product

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

                <!-- DELETE PRODUCT MODAL -->
                <div class="modal fade"
                    id="deleteProductModal<?= $product['id'] ?>"
                    tabindex="-1">

                    <div class="modal-dialog modal-dialog-centered">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h5 class="modal-title text-danger">

                                    <i class="bi bi-trash me-2"></i>
                                    Delete Product

                                </h5>

                                <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal">
                                </button>

                            </div>

                            <div class="modal-body">

                                <p class="mb-2">

                                    Are you sure you want to delete:

                                </p>

                                <strong>

                                    <?= esc($product['name']) ?>

                                </strong>

                                <hr>

                                <small class="text-muted">

                                    This action cannot be undone.

                                </small>

                            </div>

                            <div class="modal-footer">

                                <button class="btn btn-secondary"
                                        data-bs-dismiss="modal">

                                    Cancel

                                </button>

                                <a href="<?= base_url('admin/products/delete/' . $product['id']) ?>"
                                class="btn btn-danger">

                                    <i class="bi bi-trash me-1"></i>
                                    Delete

                                </a>

                            </div>

                        </div>

                    </div>

                </div>
                
                <?php endforeach; ?>

            </tbody>

        </table>

        <div class="d-flex justify-content-center mt-3">

            <?= $pager->links('default', 'bootstrap_full') ?>

        </div>

    </div>

</div>

<!-- CREATE PRODUCT MODAL -->

<div class="modal fade"
     id="createProductModal"
     tabindex="-1">

    <div class="modal-dialog modal-lg">

        <form method="post"
              enctype="multipart/form-data"
              action="<?= base_url('admin/products/add') ?>">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Add Product

                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Product Name

                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Category

                            </label>

                            <select name="category_id"
                                    class="form-select"
                                    required>

                                <option value="">
                                    Select Category
                                </option>

                                <?php foreach($categories as $category): ?>

                                    <option value="<?= $category['id'] ?>">

                                        <?= esc($category['name']) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Description

                        </label>

                        <textarea name="description"
                                  class="form-control"></textarea>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Price

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    ₱
                                </span>

                                <input type="number"
                                    step="0.01"
                                    min="0"
                                    name="price"
                                    class="form-control"
                                    required>

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Stock

                            </label>

                            <input type="number"
                                   name="stock"
                                   class="form-control"
                                   required>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Product Image

                        </label>

                        <input type="file"
                               name="image"
                               class="form-control">

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit"
                            class="btn btn-primary">

                        Save Product

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- CREATE PRODUCT MODAL -->
<div class="modal fade"
     id="createProductModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <form method="post"
              enctype="multipart/form-data"
              action="<?= base_url('admin/products/add') ?>">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="bi bi-box-seam me-2"></i>
                        Add Product

                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <!-- Product Name -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Product Name

                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   required>

                        </div>

                        <!-- Category -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Category

                            </label>

                            <select name="category_id"
                                    class="form-select"
                                    required>

                                <option value="">
                                    Select Category
                                </option>

                                <?php foreach($categories as $category): ?>

                                    <option value="<?= $category['id'] ?>">

                                        <?= esc($category['name']) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                    </div>

                    <!-- Description -->
                    <div class="mb-3">

                        <label class="form-label">

                            Description

                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="4"></textarea>

                    </div>

                    <div class="row">

                        <!-- Price -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Price

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">

                                    ₱

                                </span>

                                <input type="number"
                                       step="0.01"
                                       min="0"
                                       name="price"
                                       class="form-control"
                                       required>

                            </div>

                        </div>

                        <!-- Stock -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Stock Quantity

                            </label>

                            <input type="number"
                                   min="0"
                                   name="stock"
                                   class="form-control"
                                   required>

                        </div>

                    </div>

                    <!-- Product Image -->
                    <div class="mb-3">

                        <label class="form-label">

                            Product Image

                        </label>

                        <input type="file"
                               name="image"
                               class="form-control"
                               accept="image/*">

                        <small class="text-muted">

                            JPG, JPEG, PNG, WEBP

                        </small>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-check-circle me-1"></i>
                        Save Product

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<?= $this->endSection() ?>