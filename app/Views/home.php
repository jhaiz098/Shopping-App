<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StudentHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body{
            background-color:#f8f9fa;
        }

        .navbar-brand{
            font-size:1.5rem;
        }

        .hero-section{
            background: linear-gradient(135deg,#0d6efd,#6610f2);
            color:white;
        }

        .hero-section .btn{
            border-radius:50px;
        }

        .category-card{
            border:none;
            border-radius:15px;
            transition:.3s;
            cursor:pointer;
        }

        .category-card:hover{
            transform:translateY(-5px);
            box-shadow:0 .5rem 1rem rgba(0,0,0,.15);
        }

        .category-icon{
            font-size:3rem;
        }

        .product-card{
            border:none;
            border-radius:15px;
            overflow:hidden;
            transition:.3s;
        }

        .product-card:hover{
            transform:translateY(-5px);
            box-shadow:0 .5rem 1rem rgba(0,0,0,.15);
        }

        .product-card img{
            height:220px;
            object-fit:cover;
        }

        .feature-icon{
            font-size:3rem;
            margin-bottom:15px;
        }

        footer i{
            font-size:1.3rem;
            margin:0 10px;
            cursor:pointer;
        }

        footer i:hover{
            color:#0d6efd;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">

        <a class="navbar-brand fw-bold text-primary" href="#">
            <i class="bi bi-mortarboard-fill me-2"></i>
            StudentHub
        </a>

        <form class="d-flex w-50">
            <input class="form-control" type="search" placeholder="Search school supplies...">
        </form>

        <div class="d-flex align-items-center gap-2">

            <?php if(session()->get('isLoggedIn')): ?>

                <div class="dropdown">

                    <button
                        class="btn btn-outline-primary dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown">

                        <i class="bi bi-person-circle me-1"></i>

                        <?= esc(session()->get('first_name')) ?>
                        <?= esc(session()->get('last_name')) ?>

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person me-2"></i>
                                Profile
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-bag me-2"></i>
                                My Orders
                            </a>
                        </li>

                        <?php if(session()->get('role') === 'admin'): ?>

                            <li>
                                <a class="dropdown-item" href="<?= base_url('admin') ?>">
                                    <i class="bi bi-speedometer2 me-2"></i>
                                    Dashboard
                                </a>
                            </li>

                        <?php endif; ?>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a
                                class="dropdown-item text-danger"
                                href="<?= base_url('logout') ?>">

                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout

                            </a>
                        </li>

                    </ul>

                </div>

            <?php else: ?>

                <a href="<?= base_url('login') ?>" class="btn btn-outline-primary">
                    <i class="bi bi-box-arrow-in-right me-1"></i>
                    Sign In
                </a>

                <a href="<?= base_url('register') ?>" class="btn btn-primary">
                    <i class="bi bi-person-plus-fill me-1"></i>
                    Sign Up
                </a>

            <?php endif; ?>

            <a href="<?= base_url('cart') ?>" class="btn btn-outline-dark position-relative">

                <i class="bi bi-cart3"></i>

                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    0
                </span>

            </a>

        </div>

    </div>
</nav>

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

        <a href="#" class="btn btn-outline-light btn-lg">
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

            <div class="col-md-3 mb-3">
                <div class="card category-card p-4 shadow-sm">

                    <i class="bi bi-journal-richtext category-icon text-primary"></i>

                    <h5 class="mt-3">
                        Notebooks
                    </h5>

                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card category-card p-4 shadow-sm">

                    <i class="bi bi-pencil-square category-icon text-success"></i>

                    <h5 class="mt-3">
                        Writing Tools
                    </h5>

                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card category-card p-4 shadow-sm">

                    <i class="bi bi-folder-fill category-icon text-warning"></i>

                    <h5 class="mt-3">
                        Folders
                    </h5>

                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card category-card p-4 shadow-sm">

                    <i class="bi bi-calculator-fill category-icon text-danger"></i>

                    <h5 class="mt-3">
                        Calculators
                    </h5>

                </div>
            </div>

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

            <?php for($i=1; $i<=4; $i++): ?>

                <div class="col-md-3 mb-4">

                    <div class="card product-card h-100 shadow-sm">

                        <img src="https://via.placeholder.com/300x220"
                             class="card-img-top">

                        <div class="card-body">

                            <span class="badge bg-primary mb-2">
                                School Supply
                            </span>

                            <h5>
                                Premium Notebook
                            </h5>

                            <p class="text-muted">
                                Perfect for class notes and daily activities.
                            </p>

                            <h4 class="text-primary fw-bold">
                                ₱35.00
                            </h4>

                            <button class="btn btn-primary w-100">
                                <i class="bi bi-cart-plus"></i>
                                Add to Cart
                            </button>

                        </div>

                    </div>

                </div>

            <?php endfor; ?>

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

<!-- Footer -->
<footer class="bg-dark text-white text-center py-4">

    <div class="container">

        <h5>
            <i class="bi bi-mortarboard-fill me-2"></i>
            StudentHub
        </h5>

        <p>
            Your trusted online school supply store.
        </p>

        <div class="mb-3">
            <i class="bi bi-facebook"></i>
            <i class="bi bi-instagram"></i>
            <i class="bi bi-twitter-x"></i>
        </div>

        <p class="mb-0">
            © 2026 StudentHub. All Rights Reserved.
        </p>

    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>