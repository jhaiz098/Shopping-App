<?= $this->extend('layouts/admin/admin_layout') ?>

<?= $this->section('title') ?>
Categories
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <h3 class="mb-0">Categories</h3>
        <small class="text-muted">
            Manage product categories
        </small>
    </div>

    <button class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createCategoryModal">

        <i class="bi bi-plus-circle me-1"></i>
        Add Category

    </button>

</div>

<?php if(session()->getFlashdata('errors')): ?>

    <div class="alert alert-danger alert-dismissible fade show">

        <strong>Please fix the following errors:</strong>

        <ul class="mb-0 mt-2">

            <?php foreach(session()->getFlashdata('errors') as $error): ?>

                <li><?= esc($error) ?></li>

            <?php endforeach; ?>

        </ul>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

<?php endif; ?>

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

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            <i class="bi bi-tags me-2"></i>
            Category List

        </h3>

    </div>

    <div class="card-body p-0">

        <table class="table table-hover mb-0">

            <thead>

                <tr>
                    <th width="80">#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th width="150">Actions</th>
                </tr>

            </thead>

            <tbody>

                <?php if(empty($categories)): ?>

                    <tr>

                        <td colspan="4"
                            class="text-center text-muted py-4">

                            No categories found.

                        </td>

                    </tr>

                <?php endif; ?>

                <?php
                $perPage = 10;
                $currentPage = $pager->getCurrentPage();
                $number = 1 + (($currentPage - 1) * $perPage);
                ?>

                <?php foreach($categories as $category): ?>

                    <tr>

                        <td>
                            <?= $number++ ?>
                        </td>

                        <td>

                            <span class="fw-semibold">

                                <?= esc($category['name']) ?>

                            </span>

                        </td>

                        <td>

                            <?= strlen($category['description']) > 60
                                ? esc(substr($category['description'], 0, 60)) . '...'
                                : esc($category['description']) ?>

                        </td>

                        <td>

                            <button class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editCategoryModal<?= $category['id'] ?>">

                                <i class="bi bi-pencil"></i>

                            </button>

                            <button class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteCategoryModal<?= $category['id'] ?>">

                                <i class="bi bi-trash"></i>

                            </button>

                        </td>

                    </tr>

                    <!-- EDIT MODAL -->
                    <div class="modal fade"
                         id="editCategoryModal<?= $category['id'] ?>"
                         tabindex="-1">

                        <div class="modal-dialog">

                            <form method="post"
                                  action="<?= base_url('admin/categories/update/' . $category['id']) ?>">

                                <div class="modal-content">

                                    <div class="modal-header">

                                        <h5 class="modal-title">

                                            Edit Category

                                        </h5>

                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal">
                                        </button>

                                    </div>

                                    <div class="modal-body">

                                        <div class="mb-3">

                                            <label class="form-label">

                                                Category Name

                                            </label>

                                            <input type="text"
                                                   name="name"
                                                   class="form-control"
                                                   value="<?= esc($category['name']) ?>"
                                                   required>

                                        </div>

                                        <div class="mb-3">

                                            <label class="form-label">

                                                Description

                                            </label>

                                            <textarea name="description"
                                                      class="form-control"><?= esc($category['description']) ?></textarea>

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

                                            Update

                                        </button>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                    <!-- DELETE MODAL -->
                    <div class="modal fade"
                         id="deleteCategoryModal<?= $category['id'] ?>"
                         tabindex="-1">

                        <div class="modal-dialog modal-dialog-centered">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title text-danger">

                                        Delete Category

                                    </h5>

                                    <button type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal">
                                    </button>

                                </div>

                                <div class="modal-body">

                                    Are you sure you want to delete

                                    <strong>
                                        <?= esc($category['name']) ?>
                                    </strong>?

                                </div>

                                <div class="modal-footer">

                                    <button class="btn btn-secondary"
                                            data-bs-dismiss="modal">

                                        Cancel

                                    </button>

                                    <a href="<?= base_url('admin/categories/delete/' . $category['id']) ?>"
                                       class="btn btn-danger">

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

<!-- CREATE MODAL -->
<div class="modal fade"
     id="createCategoryModal"
     tabindex="-1">

    <div class="modal-dialog">

        <form method="post"
              action="<?= base_url('admin/categories/add') ?>">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Add Category

                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">

                            Category Name

                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Description

                        </label>

                        <textarea name="description"
                                  class="form-control"></textarea>

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

                        Save Category

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<?= $this->endSection() ?>