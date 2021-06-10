<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Category_model;

class Category extends BaseController
{
	public $db;

	public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

	public function index()
	{
		$data['sidebar'] = 'category';
		return view('admin/v_category', $data);
	}

	public function ajax_load_data()
	{
		// $model = new Category_model();
		// $data['categories'] = $model->getCategory();

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
		$data = array(
			'category_name'     => $this->request->getPost('name'),
			'category_status'   => $this->request->getPost('status'),
		);
	
		$model = new Category_model();
		$simpan = $model->insertCategory($data);
		if($simpan)
		{
			return json_encode(TRUE); 
		}
		return json_encode(FALSE);
	}

	public function edit($id)
	{  
		$model = new Category_model();
		$data = $model->getCategory($id)->getRowArray();
		echo json_encode($data);
	}

	public function update($id)
	{	
		$data = array(
			'category_name'     => $this->request->getPost('name'),
			'category_status'   => $this->request->getPost('status'),
		);

		$model = new Category_model();
		$ubah = $model->updateCategory($data, $id);
		if($ubah)
		{
			return json_encode(TRUE); 
		}
		return json_encode(FALSE); 
	}

	public function delete($id)
	{
		$model = new Category_model();
		$hapus = $model->deleteCategory($id);
		if($hapus)
		{
			return json_encode(TRUE);  
		}
		return json_encode(FALSE); 
	}
}
