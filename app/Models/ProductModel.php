<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'price', 'sport_type', 'category_id', 'image'];

    public function get_all_products()
    {
        return $this->asObject()->findAll();
    }

    public function get_product($id)
    {
        return $this->asObject()->find($id);
    }

    public function insert_product($data)
    {
        return $this->insert($data);
    }

    public function update_product($id, $data)
    {
        return $this->update($id, $data);
    }

    public function delete_product($id)
    {
        return $this->delete($id);
    }
}
