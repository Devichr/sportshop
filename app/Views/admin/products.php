<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h2>Manage Products</h2>
<a href="<?= site_url('admin/products/add') ?>" class="btn btn-primary mb-3">Add Product</a>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Sport Type</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product) : ?>
            <tr>
            <td><img src="<?= base_url('uploads/'.$product->image) ?>" width="50" alt="<?= $product->name ?>"></td>
            <td><?= $product->name ?></td>
                <td><?= $product->description ?></td>
                <td><?= $product->price ?></td>
                <td><?= $product->sport_type ?></td>
                <td><?= $product->category_id ?></td>
                <td>
                    <a href="<?= site_url('admin/products/edit/' . $product->id) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= site_url('admin/products/delete/' . $product->id) ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>