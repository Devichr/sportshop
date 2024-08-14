<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="<?= config('Midtrans')->clientKey ?>"></script>
    <style>
        .container {
            margin-top: 30px;
        }
        .order-summary {
            margin-top: 20px;
        }
        .order-summary th, .order-summary td {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="my-4">Order Details</h2>

        <div class="card">
            <div class="card-header">
                Shipping Address
            </div>
            <div class="card-body">
                <p class="card-text"><?= nl2br(htmlspecialchars($address)) ?></p>
            </div>
        </div>

        <div class="card order-summary">
            <div class="card-header">
                Order Summary
            </div>
            <div class="card-body">
                <p><strong>Total Price:</strong> <?= number_format($totalPrice, 2) ?></p>
                <?php if ($cartItems): ?>
                    <h5 class="mt-4">Items:</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['name']) ?></td>
                                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                                    <td><?= number_format($item['price'], 2) ?></td>
                                    <td><?= number_format($item['quantity'] * $item['price'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No items in the cart.</p>
                <?php endif; ?>
                <button id="pay-button" class="btn btn-primary mt-4">Pay!</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
</body>
</html>
