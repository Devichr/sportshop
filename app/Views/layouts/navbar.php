<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sport Shop</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="<?= config('Midtrans')->clientKey ?>"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?= base_url('/') ?>">Sport Shop</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>">Home</a></li>            
        </ul>
        <form class="form-inline my-2 my-lg-0" action="<?= base_url('shop/search') ?>" method="get">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="q">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        <ul class="navbar-nav ml-auto">
            <?php if (session()->get('isLoggedIn')): ?>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/orders') ?>">Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/cart') ?>">Cart</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/logout') ?>">Logout</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/login') ?>">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <?= $this->renderSection('content') ?>
</div>
</body>
</html>
