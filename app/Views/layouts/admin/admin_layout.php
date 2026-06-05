<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $this->renderSection('title') ?> | StudentHub Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <?= $this->renderSection('styles') ?>
</head>
<body>

    <?= $this->include('partials/admin/header') ?>

    <div class="d-flex" style="min-height: calc(100vh - 56px);">

        <?= $this->include('partials/admin/sidebar') ?>

        <div class="flex-grow-1 d-flex flex-column">

            <main class="flex-grow-1 p-4">
                <?= $this->renderSection('content') ?>
            </main>

            <?= $this->include('partials/admin/footer') ?>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?= $this->renderSection('scripts') ?>

</body>
</html>