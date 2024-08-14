<?= $this->extend('layouts/navbar') ?>

<?= $this->section('content') ?>
    <h2 class="my-4">Search Results for "<?= esc($searchTerm) ?>"</h2>
    <div class="row">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <img src="<?= base_url('uploads/'.$product['image']) ?>" width="300" height="200" alt="<?= $product['name'] ?>">
                            <h5 class="card-title"><?= esc($product['name']) ?></h5>
                            <p class="card-text"><?= esc($product['description']) ?></p>
                            <p class="card-text"><strong>Price:</strong> <?= esc($product['price']) ?></p>
                            <p class="card-text"><strong>Sport:</strong> <?= esc($product['sport_type']) ?></p>
                            <a href="<?= base_url('cart/add/'.$product['id']) ?>" class="btn btn-primary">Add to Cart</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-md-12">
                <p>No products found matching your search term.</p>
            </div>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>
