
#### app/Views/admin/add_product.php

```php
<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <h2>Add Product</h2>
    <?= form_open_multipart('admin/products/insert') ?>
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="sport_type">Sport Type</label>
            <input type="text" class="form-control" id="sport_type" name="sport_type" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image" required>
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category->id ?>"><?= $category->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Product</button>
    <?= form_close() ?>
<?= $this->endSection() ?>
