<?php

namespace App\Models;

use CodeIgniter\Model;

class Transaction_model extends Model
{
	protected $table = 'transactions';
      
    public function getTransaction($id = false)
    {
        if($id === false){
            return $this->table('transactions')
                        ->select('products.product_name, transactions.*')
                        ->join('products', 'products.product_id = transactions.product_id')
                        ->get()
                        ->getResultArray();
        } else {
            return $this->table('transactions')
                        ->select('products.product_name, transactions.*')
                        ->join('products', 'products.product_id = transactions.product_id')
                        ->where('transactions.trx_id', $id)
                        ->get()
                        ->getRowArray();
        }  
    }

    public function insertTransaction($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function updateTransaction($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['trx_id' => $id]);
    }

    public function deleteTransaction($id)
    {
        return $this->db->table($this->table)->delete(['trx_id' => $id]);
    } 
}
