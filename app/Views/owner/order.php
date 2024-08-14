<?= $this->extend('layouts/owner') ?>

<?= $this->section('content') ?>
<h2 class="my-4">All Orders</h2>
<div class="row">
    <div class="col-md-12">
        <form action="<?= base_url('/owner/report') ?>" method="get">
            <label for="range">Pilih Jangka Waktu:</label>
            <select name="range" id="range" class="form-control">
                <option value="1day">1 Hari</option>
                <option value="1week">1 Minggu</option>
                <option value="1month" selected>1 Bulan</option>
                <option value="1year">1 Tahun</option>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Unduh Laporan Penjualan</button>
        </form> <?php if (!empty($orders)) : ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Total Price</th>
                        <th>Payment</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) : ?>
                        <tr>
                            <td><?= $order['id'] ?></td>
                            <td><?= $order['user_id'] ?></td>
                            <td><?= $order['total_price'] ?></td>
                            <td><?= $order['payment'] ?></td>
                            <td><?= $order['status'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>