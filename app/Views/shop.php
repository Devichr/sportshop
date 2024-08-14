<?= $this->extend('layouts/navbar') ?>

<?= $this->section('content') ?>

<!-- Carousel Banner -->
<div id="carouselBanner" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php foreach ($banners as $index => $banner): ?>
            <li data-target="#carouselBanner" data-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>"></li>
        <?php endforeach; ?>
    </ol>
    <div class="carousel-inner">
        <?php foreach ($banners as $index => $banner): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <img class="d-block w-100" height="300" src="<?= base_url('uploads/'.$banner['image']) ?>" alt="<?= $banner['title'] ?>">
                <div class="carousel-caption d-none d-md-block font-weight-bold shadow-lg p-3 mb-5 rounded "  style="background-color: rgba(108, 117, 125, 0.75);">
                    <h5><?= $banner['title'] ?></h5>
                    <p><?= $banner['description'] ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <a class="carousel-control-prev" href="#carouselBanner" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselBanner" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<h2 class="my-4">Just For You</h2>
<div class="row">
<?php if (isset($recommendedProducts) && count($recommendedProducts) > 0): ?>
    <?php foreach ($recommendedProducts as $product): ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="<?= base_url('uploads/'.$product['image']) ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $product['name'] ?></h5>
                    <p class="card-text"><?= $product['description'] ?></p>
                    <p class="card-text"><strong>Price:</strong> <?= $product['price'] ?></p>
                    <p class="card-text"><strong>Sport:</strong> <?= $product['sport_type'] ?></p>
                    <?php
                        if ($product['tfidf'] > 5) {
                            echo("<p class='card-text'> Barang yang kamu minati nihh </p>");
                        }elseif ($product['tfidf'] > 3) {
                            echo("<p class='card-text'> Belakangan kamu kayanya lagi nyari barang ini </p>");
                        }else{
                            echo("<p class='card-text'> Kamu mungkin suka ini </p>");
                        }
                    ?>
                    <a href="<?= base_url('cart/add/'.$product['id']) ?>" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php else: ?>
        <p>No recommended products at this time.</p>
    <?php endif; ?>
</div>

<h2 class="my-4">Products</h2>
<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="<?= base_url('uploads/'.$product['image']) ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $product['name'] ?></h5>
                    <p class="card-text"><?= $product['description'] ?></p>
                    <p class="card-text"><strong>Price:</strong> <?= $product['price'] ?></p>
                    <p class="card-text"><strong>Sport:</strong> <?= $product['sport_type'] ?></p>
                    <a href="<?= base_url('cart/add/'.$product['id']) ?>" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?= $this->endSection() ?>
