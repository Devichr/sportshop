<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role', 'favorite_sport','first_name','last_name','email','phone','otp','is_active'];

    public function get_user_by_username($username)
    {
        return $this->where('username', $username)->first();
    }

    public function insert_user($data)
    {
        return $this->insert($data);
    }
}
