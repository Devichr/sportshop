<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'product_id', 'quantity','price'];

    public function getCartByUserId($userId)
    {
        return $this->select('cart.*, products.name, products.price, products.image')
                    ->join('products', 'products.id = cart.product_id')
                    ->where('cart.user_id', $userId)
                    ->findAll();
    }

    public function getCartItem($userId, $productId)
    {
        return $this->where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->first();
    }
}