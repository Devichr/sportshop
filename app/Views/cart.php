<?= $this->extend('layouts/navbar') ?>

<?= $this->section('content') ?>
<h2 class="my-4">Shopping Cart</h2>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $item): ?>
                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td><img src="<?= base_url('uploads/'.$item['image']) ?>" width="100" height="100"></td>
                        <td><?= $item['price'] ?></td>
                        <td>
                            <a href="<?= base_url('cart/increase/'.$item['product_id']) ?>" class="btn btn-success">+</a>
                            <?= $item['quantity'] ?>
                            <a href="<?= base_url('cart/decrease/'.$item['product_id']) ?>" class="btn btn-danger">-</a>
                        </td>
                        <td><?= $item['price'] * $item['quantity'] ?></td>
                        <td><a href="<?= base_url('remove/'.$item['id']) ?>" class="btn btn-danger">Hapus</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <form id="checkout-form" method="post" action="<?= base_url('/checkout/process') ?>">
            <label for="address">Alamat Pengiriman:</label><br>
            <textarea id="address" name="address" required></textarea><br><br>
            <input type="hidden" name="total_price" value="<?= $totalPrice ?>">
            <button type="submit" class="btn btn-primary">Proceed to Payment</button>
        </form>
        </div>
</div>

<script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            fetch('<?= base_url('/payment/token') ?>')
                .then(response => response.json())
                .then(data => {
                    snap.pay(data.token, {
                        onSuccess: function(result){
                            sendResponseToForm(result);
                        },
                        onPending: function(result){
                            sendResponseToForm(result);
                        },
                        onError: function(result){
                            sendResponseToForm(result);
                        },
                        onClose: function(){
                            alert('You closed the popup without finishing the payment');
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        };

        function sendResponseToForm(result){
            document.getElementById('result-data').value = JSON.stringify(result);
            document.getElementById('payment-form').submit();
        }
    </script>

    <form id="payment-form" method="post" action="<?= base_url('/payment/finish') ?>">
        <input type="hidden" name="result_data" id="result-data" value="">
    </form>
<?= $this->endSection() ?>
