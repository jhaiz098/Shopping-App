<?= $this->extend('layouts/admin/admin_layout') ?>

<?= $this->section('title') ?>
Users
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <h3 class="mb-0">Users</h3>
        <small class="text-muted">Manage system users</small>
    </div>

    <button class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createUserModal">

        <i class="bi bi-person-plus me-1"></i>
        Add User

    </button>

</div>

<?php if(session()->getFlashdata('success')): ?>

    <div class="alert alert-success alert-dismissible fade show">

        <?= session()->getFlashdata('success') ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

    </div>

<?php endif; ?>

<?php if(session()->getFlashdata('errors')): ?>

    <div class="alert alert-danger alert-dismissible fade show">

        <strong>Please fix the following errors:</strong>

        <ul class="mb-0 mt-2">
            <?php foreach(session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

    </div>

<?php endif; ?>

<div class="card shadow-sm border-0">

    <div class="card-header bg-white">

        <h5 class="mb-0">
            <i class="bi bi-people me-2"></i>
            User List
        </h5>

    </div>

    <div class="card-body p-0 table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>
                    <th width="70">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created</th>
                    <th width="150">Actions</th>
                </tr>

            </thead>

            <tbody>

                <?php if(empty($users)): ?>

                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            No users found.
                        </td>
                    </tr>

                <?php endif; ?>

                <?php
                    $perPage = 10;
                    $currentPage = $pager->getCurrentPage();
                    $number = 1 + (($currentPage - 1) * $perPage);
                ?>

                <?php foreach($users as $user): ?>

                    <tr>

                        <td><?= $number++ ?></td>

                        <td class="fw-semibold">
                            <?= esc($user['first_name']) ?>
                            <?= esc($user['last_name']) ?>
                        </td>

                        <td><?= esc($user['email']) ?></td>

                        <td>

                            <?php if($user['role'] === 'admin'): ?>
                                <span class="badge bg-danger">Admin</span>
                            <?php else: ?>
                                <span class="badge bg-primary">Customer</span>
                            <?php endif; ?>

                        </td>

                        <td>
                            <?= date('M d, Y', strtotime($user['created_at'])) ?>
                        </td>

                        <td>

                            <button class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editUserModal<?= $user['id'] ?>">

                                <i class="bi bi-pencil"></i>

                            </button>

                            <button class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteUserModal<?= $user['id'] ?>">

                                <i class="bi bi-trash"></i>

                            </button>

                        </td>

                    </tr>

                    <!-- EDIT USER MODAL -->
                    <div class="modal fade"
                         id="editUserModal<?= $user['id'] ?>"
                         tabindex="-1">

                        <div class="modal-dialog">

                            <form method="post"
                                  action="<?= base_url('admin/users/update/' . $user['id']) ?>">

                                <div class="modal-content">

                                    <div class="modal-header">

                                        <h5 class="modal-title">Edit User</h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                                    </div>

                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label class="form-label">First Name</label>
                                            <input type="text"
                                                   name="first_name"
                                                   class="form-control"
                                                   value="<?= esc($user['first_name']) ?>"
                                                   required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Last Name</label>
                                            <input type="text"
                                                   name="last_name"
                                                   class="form-control"
                                                   value="<?= esc($user['last_name']) ?>"
                                                   required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email"
                                                   name="email"
                                                   class="form-control"
                                                   value="<?= esc($user['email']) ?>"
                                                   required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Role</label>
                                            <select name="role" class="form-select">
                                                <option value="customer" <?= $user['role']=='customer'?'selected':'' ?>>
                                                    Customer
                                                </option>
                                                <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>
                                                    Admin
                                                </option>
                                            </select>
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

                    <!-- DELETE USER MODAL -->
                    <div class="modal fade"
                         id="deleteUserModal<?= $user['id'] ?>"
                         tabindex="-1">

                        <div class="modal-dialog modal-dialog-centered">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title text-danger">
                                        Delete User
                                    </h5>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                                </div>

                                <div class="modal-body">

                                    Are you sure you want to delete:

                                    <strong>
                                        <?= esc($user['first_name']) ?>
                                        <?= esc($user['last_name']) ?>
                                    </strong>?

                                </div>

                                <div class="modal-footer">

                                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancel
                                    </button>

                                    <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>"
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

    </div>

    <!-- PAGINATION -->
    <div class="d-flex justify-content-center p-3">

        <?= $pager->links('default', 'bootstrap_full') ?>

    </div>

</div>

<!-- CREATE USER MODAL -->
<div class="modal fade"
     id="createUserModal"
     tabindex="-1">

    <div class="modal-dialog">

        <form method="post"
              action="<?= base_url('admin/users/add') ?>">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">Add User</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="customer">Customer</option>
                            <option value="admin">Admin</option>
                        </select>
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
                        Save User
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<?= $this->endSection() ?>