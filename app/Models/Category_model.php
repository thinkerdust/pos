<?php

namespace App\Models;

use CodeIgniter\Model;

class Category_model extends Model
{
	protected $table = 'categories';
      
    public function getCategory($id = false)
    {
        if($id === false){
            return $this->table('categories')
                        ->join('ms_sku', 'categories.category_id = ms_sku.category_id')
                        ->get();
        } else {
            return $this->table('categories')
                        ->join('ms_sku', 'categories.category_id = ms_sku.category_id')
                        ->where('categories.category_id', $id)
                        ->get();
        }   
    }

    public function insertCategory($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function updateCategory($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['category_id' => $id]);
    }

    public function deleteCategory($id)
    {
        return $this->db->table($this->table)->delete(['category_id' => $id]);
    }
}
