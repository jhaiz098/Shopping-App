<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
My Profile
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card shadow-sm">

                <div class="card-header bg-white">

                    <h4 class="mb-0">

                        <i class="bi bi-person-circle me-2"></i>
                        My Profile

                    </h4>

                </div>

                <div class="card-body">

                    <?php if(session()->getFlashdata('success')): ?>

                        <div class="alert alert-success">

                            <?= session()->getFlashdata('success') ?>

                        </div>

                    <?php endif; ?>

                    <form method="post"
                          action="<?= base_url('profile/update') ?>">

                        <div class="mb-3">

                            <label class="form-label">

                                First Name

                            </label>

                            <input
                                type="text"
                                name="first_name"
                                class="form-control"
                                value="<?= esc($user['first_name']) ?>"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Last Name

                            </label>

                            <input
                                type="text"
                                name="last_name"
                                class="form-control"
                                value="<?= esc($user['last_name']) ?>"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Email

                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="<?= esc($user['email']) ?>"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Role

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="<?= ucfirst($user['role']) ?>"
                                disabled>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-save me-1"></i>
                            Save Changes

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>