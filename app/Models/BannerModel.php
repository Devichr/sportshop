<?php

namespace App\Models;

use CodeIgniter\Model;

class BannerModel extends Model
{
    protected $table = 'banners';
    protected $primaryKey = 'id';
    protected $allowedFields = ['image', 'title', 'description'];

    public function get_all_banners()
    {
        return $this->asObject()->findAll();
    }
}
