<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];

    public function get_all_categories()
    {
        return $this->asObject()->findAll();
    }
}
