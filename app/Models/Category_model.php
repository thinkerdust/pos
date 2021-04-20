<?php

namespace App\Models;

use CodeIgniter\Model;

class Category_model extends Model
{
	protected $table = 'categories';
      
    public function getCategory($id = false)
    {
        if($id === false){
            return $this->findAll();
        } else {
            return $this->getWhere(['category_id' => $id]);
        }   
    }
}
