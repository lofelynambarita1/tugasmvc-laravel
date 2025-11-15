<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PHP Auth</title>
    <link href="/assets/vendor/bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top site-navbar">
        <div class="container">
            <a class="navbar-brand brand-logo" href="/"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/auth/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/auth/register">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        <?= $content ?>
    </main>

    <footer class="mt-5 py-4">
        <div class="container text-center small-muted">
            &copy; <?= date('Y') ?> 
        </div>
    </footer>

    <script src="/assets/vendor/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
