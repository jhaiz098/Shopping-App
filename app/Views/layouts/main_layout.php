<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        <?= $this->renderSection('title') ?> | StudentHub
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <?= $this->renderSection('styles') ?>
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

    <?= $this->include('partials/navbar') ?>

    <?= $this->renderSection('content') ?>

    <?= $this->include('partials/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?= $this->renderSection('scripts') ?>

</body>
</html>