<?= $this->extend('layouts/navbar') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
        <h2 class="my-4">Payment Successful</h2>

        <div class="alert alert-success" role="alert">
            <p>Thank you for your purchase!</p>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                Order Details
            </div>
            <div class="card-body">
                <p><strong>Order ID:</strong> <?= htmlspecialchars($result['order_id']) ?></p>
                <p><strong>Transaction Status:</strong> <?= htmlspecialchars($result['transaction_status']) ?></p>
                <p><strong>Payment Type:</strong> <?= htmlspecialchars($result['payment_type']) ?></p>
                <p><strong>Total Price:</strong> <?= number_format($result['gross_amount'], 2) ?></p>
                <p><strong>Transaction Time:</strong> <?= htmlspecialchars($result['transaction_time']) ?></p>
                <p><strong>Shipping Address:</strong> <?= nl2br(htmlspecialchars($address)) ?></p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Purchased Items
            </div>
            <ul class="list-group list-group-flush">
                <?php foreach ($cartItems as $item): ?>
                    <li class="list-group-item">
                        <?= htmlspecialchars($item['name']) ?> - <?= htmlspecialchars($item['quantity']) ?> x <?= number_format($item['price'], 2) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <a href="<?= base_url('/') ?>" class="btn btn-primary mt-4">Continue Shopping</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?= $this->endSection() ?>
