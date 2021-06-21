<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Category_model;
use App\Models\Sku_model;
use App\Models\Product_model;
use App\Models\Transaction_model;

class Category extends BaseController
{
	public $db;
	protected $product;

	public function __construct()
    {
        $this->db = \Config\Database::connect();
		$this->product = new Product();
		$this->category_model = new Category_model();
		$this->sku_model = new Sku_model();
		$this->product_model = new Product_model();
		$this->transaction_model = new Transaction_model();
    }

	public function index()
	{
		$data['sidebar'] = 'category';
		return view('admin/v_category', $data);
	}

	public function ajax_load_data()
	{
		$params['draw'] = $_REQUEST['draw'];
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
		$search_value = $_REQUEST['search']['value'];

		$column_order = array(null, 'category_name', 'category_status', null);
		$order_name = (isset($_REQUEST['order'])) ? $column_order[$_REQUEST['order']['0']['column']] : 'category_id';
		$order_dir = (isset($_REQUEST['order'])) ? $_REQUEST['order']['0']['dir'] : 'desc';
		$order = null;
		if (!empty($order_name) && !empty($order_dir)) {
			$order = ' ORDER BY ' . $order_name . ' ' . $order_dir;
		}
        
		$condition = '';
		if(!empty($search_value)){
			$condition = "WHERE category_name like '%".$search_value."%' OR category_status like '%".$search_value."%'";
		}

		if ($length == -1) {
            $length = $this->db->query("SELECT count(*) as jumlah from categories $condition")->getResult();
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }

		$data = array();
		$query = $this->db->query("SELECT * from categories $condition $order limit $start, $length")->getResult();
		$total_count = $this->db->query("SELECT * from categories $condition")->getResult();
        if(!empty($query)){
			$no = 0;
            foreach($query as $key){
				$no++;

				$btn = '<a href="#" class="btn btn-success btn-sm" title="edit" onclick="editCategory('.$key->category_id.')"><i class="fas fa-edit"></i></a>&nbsp
						<a href="#" class="btn btn-danger btn-sm" title="hapus" onclick="deleteCategory('.$key->category_id.')"><i class="fas fa-trash"></i></a>';

				$row = array();
				$row[] = $no;
				$row[] = $key->category_name;
				$row[] = $key->category_status;
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

			$this->db->transStart();

			$data = array(
				'category_name'     => $this->request->getPost('name'),
				'category_status'   => $this->request->getPost('status'),
			);
		
			$simpan = $this->category_model->insertCategory($data);
			$lastId = $this->db->insertID();
	
			$data_sku = array(
				'category_id' 		=> $lastId,
				'kode'				=> strtoupper($this->request->getPost('kode')),
				'bulan' 			=> date('m'),
				'tahun'				=> date('y'),
				'counter'			=> 0
			);
	
			$simpanSku = $this->sku_model->insertSku($data_sku);

			$this->db->transComplete();
	
			if($simpan)
			{
				return json_encode(TRUE); 
			}
		}
		return json_encode(FALSE);
	}

	public function edit($id)
	{  
		$data = $this->category_model->getCategory($id)->getRowArray();
		echo json_encode($data);
	}

	public function update($id)
	{
		if ($this->request->isAJAX()) {

			$this->db->transStart();

			$data = array(
				'category_name'     => $this->request->getPost('name'),
				'category_status'   => $this->request->getPost('status'),
			);
	
			$ubah = $this->category_model->updateCategory($data, $id);
	
			$data_sku = array(
				'kode'				=> strtoupper($this->request->getPost('kode')),
			);
	
			$ubah_sku = $this->sku_model->updateSku($data_sku, $id);

			$this->db->transComplete();
	
			if($ubah)
			{
				return json_encode(TRUE); 
			}
		}	
		return json_encode(FALSE); 
	}

	public function delete($id)
	{
		$this->db->transStart();
		$hapus = $this->category_model->deleteCategory($id);
		$this->sku_model->where('category_id', $id)->delete();
		$product = $this->product_model->getWhere(['category_id', $id])->getRow();
		if(!empty($product)){
			$this->product->deleteImg($product->product_image);
			$this->product_model->where('category_id', $id)->delete();
			$this->transaction_model->where('product_id', $product->id)->delete();
		}
		$this->db->transComplete();
		if($hapus)
		{
			return json_encode(TRUE);  
		}
		return json_encode(FALSE); 
	}
}
