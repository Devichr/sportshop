<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <h2 class="my-4">All Orders</h2>
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($orders)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User ID</th>
                            <th>Total Price</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= $order['id'] ?></td>
                                <td><?= $order['user_id'] ?></td>
                                <td><?= $order['total_price'] ?></td>
                                <td><?= $order['payment'] ?></td>
                                <td><?= $order['status'] ?></td>
                                <td>
                                    <?php if ($order['status'] == 'Pesanan siap dikirim'): ?>
                                        <a href="<?= base_url('admin/orders/ship/'.$order['id']) ?>" class="btn btn-primary">Mark as Shipped</a>
                                    <?php elseif ($order['status'] == 'Sedang dikirim'): ?>
                                        <a href="<?= base_url('admin/orders/receive/'.$order['id']) ?>" class="btn btn-success">Mark as Received</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No orders found.</p>
            <?php endif; ?>
        </div>
    </div>
<?= $this->endSection() ?>
