<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class Users_model extends Model{
    protected $table = 'users';
    protected $useTimestamps = true;
    protected $allowedFields = ['username','email','password', 'created_at', 'updated_at'];
}