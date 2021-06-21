<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Transaction_model;
use App\Models\Product_model;

class Transaction extends BaseController
{
	public $db;

	public function __construct()
    {
		$this->transaction_model = new Transaction_model();
        $this->product_model = new Product_model();
        $this->db = \Config\Database::connect();
    }

	public function index()
	{
		$data['sidebar'] = 'transaction';
		$get_product = $this->product_model->getProduct();
        $product = [];
        $product[''] = '-- Select Product --';
        foreach($get_product as $key){
            $product[$key['product_id']] = $key['product_name'];
        }
        $data['product'] = $product;
		return view('admin/v_transaction', $data);
	}

	public function ajax_load_data()
	{
		$params['draw'] = $_REQUEST['draw'];
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
		$search_value = $_REQUEST['search']['value'];

		$column_order = array(null, 'products.product_name', 'transactions.trx_date', 'transactions.trx_price', null);
		$order_name = (isset($_REQUEST['order'])) ? $column_order[$_REQUEST['order']['0']['column']] : 'transactions.trx_id';
		$order_dir = (isset($_REQUEST['order'])) ? $_REQUEST['order']['0']['dir'] : 'desc';
		$order = null;
		if (!empty($order_name) && !empty($order_dir)) {
			$order = ' ORDER BY ' . $order_name . ' ' . $order_dir;
		}
        
		$condition = '';
		if(!empty($search_value)){
			$condition = "WHERE products.product_name like '%".$search_value."%' OR transactions.trx_date like '%".$search_value."%' OR transactions.trx_price like '%".$search_value."%'";
		}

		if ($length == -1) {
            $length = $this->db->query("SELECT count(*) as jumlah from transactions left join products on products.product_id = transactions.product_id $condition")->getResult();
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }

		$data = array();
		$query = $this->db->query("SELECT * from transactions left join products on products.product_id = transactions.product_id $condition $order limit $start, $length")->getResult();
		$total_count = $this->db->query("SELECT * from transactions left join products on products.product_id = transactions.product_id $condition")->getResult();
        if(!empty($query)){
			$no = 0;
            foreach($query as $key){
				$no++;

				$btn = '<a href="#" class="btn btn-success btn-sm" title="edit" onclick="editTransaction('.$key->trx_id.')"><i class="fas fa-edit"></i></a>&nbsp
						<a href="#" class="btn btn-danger btn-sm" title="hapus" onclick="deleteTransaction('.$key->trx_id.')"><i class="fas fa-trash"></i></a>';

				$row = array();
				$row[] = $no;
                $row[] = $key->product_name;
				$row[] = tgl_indo($key->trx_date);
				$row[] = $key->trx_qty;
				$row[] = 'Rp. '.number_format($key->trx_price);
				$row[] = $btn;

				$data[] = $row; 
			}
        }

        $json_data = array(
            "draw" => intval($params['draw']),
            "recordsTotal" => count($total_count),
            "recordsFiltered" => count($total_count),
            "data" => $data   // total data array
        );

        echo json_encode($json_data);
	}

	public function store()
	{
		if ($this->request->isAJAX()) {

			$product_id = $this->request->getPost('product_id');
			$cek_product = $this->product_model->getProduct($product_id);
			$trx_stock = $this->request->getPost('transaction_qty');
			$product_stock = $cek_product['product_stock'];

			if($trx_stock <= $product_stock) {
				$this->db->transStart();

				$id = $this->request->getPost('transaction_id');
				$product_price = preg_replace('/[^0-9]/', '', $this->request->getPost('transaction_price'));
				$trx_price = (int)$product_price * $trx_stock;

				$data = array(
					'product_id' 	=> $product_id,
					'trx_price'		=> $trx_price,
					'trx_qty'		=> $trx_stock,
					'trx_date'		=> $this->request->getPost('transaction_date'),
				);

				$final_stock = $product_stock - $trx_stock;

				$this->product_model->updateProduct(['product_stock' => $final_stock], $product_id);

				if(!empty($id)){
					$simpan = $this->transaction_model->updateTransaction($data, $id);
				}else{
					$simpan = $this->transaction_model->insertTransaction($data);
				}

				$this->db->transComplete();

				if($simpan)
				{
					return json_encode(TRUE);  
				}
			}   
		}
		return json_encode(FALSE);
	}

	public function edit($id)
	{
		$data = $this->transaction_model->getTransaction($id);
		echo json_encode($data);
	}

	public function delete($id)
	{
		$delete = $this->transaction_model->deleteTransaction($id);
		if($delete)
		{
			return json_encode(TRUE);
		}
		return json_encode(FALSE);
	}
}
