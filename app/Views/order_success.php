<?= $this->extend('layouts/navbar') ?>

<?= $this->section('content') ?>
    <h2 class="my-4">Order Success</h2>
    <div class="alert alert-success" role="alert">
        Your order has been placed successfully.
    </div>
    <a href="<?= base_url('/') ?>" class="btn btn-primary">Continue Shopping</a>
<?= $this->endSection() ?>
