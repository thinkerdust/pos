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
        
		$condition = '';
		if(!empty($search_value)){
			$condition = "WHERE category_name like '%".$search_value."%' OR category_status like '%".$search_value."%'";
		}

		if ($length == -1) {
            $length = $this->db->query("SELECT count(*) as jumlah from categories $condition")->getResult();
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }

        $search_value = $_REQUEST['search']['value'];
		$data = array();
		$query = $this->db->query("SELECT * from categories $condition limit $start, $length")->getResult();
		$total_count = $this->db->query("SELECT * from categories $condition")->getResult();
        if(!empty($query)){
            $data[] = $query;
        }

        $json_data = array(
            "draw" => intval($params['draw']),
            "recordsTotal" => count($total_count),
            "recordsFiltered" => count($total_count),
            "data" => $data   // total data array
        );

        echo json_encode($json_data);
	}
}
