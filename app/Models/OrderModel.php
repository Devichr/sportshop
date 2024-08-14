<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'total_price', 'payment', 'status', 'created_at', 'shipping_address'];

    public function insertOrder($data)
    {
        return $this->insert($data);
    }

    public function getCompletedOrdersByDateRange($startDate, $endDate)
    {
        return $this->where('status', 'Pesanan diterima')->findAll();
    }

    public function getCompletedOrders()
    {
        return $this->where('status', 'Pesanan diterima')->findAll();
    }

    public function saveOrder($userId, $cartItems, $totalPrice, $payment)
    {
        $orderData = [
            'user_id' => $userId,
            'total_price' => $totalPrice,
            'payment' => $payment,
            'status' => 'Pesanan siap dikirim', // Initial status
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->insert($orderData);
        $orderId = $this->getInsertID();

        $orderItems = [];
        foreach ($cartItems as $item) {
            $orderItems[] = [
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ];
        }

        // Insert order items
        $db = \Config\Database::connect();
        $builder = $db->table('order_items');
        $builder->insertBatch($orderItems);
    }
    public function updateOrderStatus($orderId, $status)
{
    $this->update($orderId, ['status' => $status]);
}
}
