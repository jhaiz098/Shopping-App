<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - StudentHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body{
            background: linear-gradient(135deg,#0d6efd,#6610f2);
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .login-card{
            width:100%;
            max-width:450px;
            border:none;
            border-radius:20px;
        }

        .back-home{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            padding:10px 15px;
            border-radius:12px;
            background:#f8f9fa;
            color:#0d6efd;
            text-decoration:none;
            font-weight:500;
            transition:0.2s;
        }

        .back-home:hover{
            background:#e9ecef;
            transform:translateY(-2px);
        }

        .logo-icon{
            font-size:3rem;
            color:#0d6efd;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card login-card shadow-lg mx-auto">

        <div class="card-body p-5">

            <!-- BACK TO HOME (modern button style) -->
            <a href="/" class="back-home mb-4">
                <i class="bi bi-house-door-fill"></i>
                Back to Home
            </a>

            <div class="text-center mb-4">

                <i class="bi bi-mortarboard-fill logo-icon"></i>

                <h2 class="fw-bold mt-2">Welcome Back</h2>

                <p class="text-muted">
                    Sign in to your StudentHub account.
                </p>

            </div>

            <form action="/login" method="POST">

                <div class="mb-3">

                    <label class="form-label">Email</label>

                    <input type="email" class="form-control" name="email" required>

                </div>

                <div class="mb-3">

                    <label class="form-label">Password</label>

                    <input type="password" class="form-control" name="password" required>

                </div>

                <button class="btn btn-primary w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Sign In
                </button>

            </form>

            <hr>

            <div class="text-center">

                Don't have an account?
                <a href="/register" class="fw-bold text-decoration-none">
                    Create Account
                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>