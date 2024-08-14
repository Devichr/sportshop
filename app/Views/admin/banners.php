<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <h2>Banners</h2>
    <a href="<?= base_url('admin/banners/create') ?>" class="btn btn-primary mb-3">Create Banner</a>
    <?php if(session()->getFlashdata('message')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($banners as $banner): ?>
                <tr>
                    <td><?= $banner->title ?></td>
                    <td><img src="<?= base_url('uploads/' . $banner->image) ?>" width="50" alt="Banner Image"></td>
                    <td>
                        <a href="<?= base_url('admin/banners/edit/' . $banner->id) ?>" class="btn btn-warning">Edit</a>
                        <a href="<?= base_url('admin/banners/delete/' . $banner->id) ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
