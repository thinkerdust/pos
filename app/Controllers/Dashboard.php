<?php

namespace App\Controllers;
use App\Models\Transaction_model;
use App\Models\Product_model;
use App\Models\Category_model;
use App\Models\Users_model;

class Dashboard extends BaseController
{
	public $db;

	public function __construct()
    {
		$this->transaction_model = new Transaction_model();
        $this->product_model = new Product_model();
        $this->category_model = new Category_model();
        $this->users_model = new Users_model();
		$this->db = \Config\Database::connect();
    }

	public function index()
	{
		$data['sidebar'] = 'dashboard';
		$data['total_product'] = $this->product_model->countAll();
		$data['total_transaction'] = $this->transaction_model->selectSum('trx_price')->get()->getRow();
		$data['best_seller'] = $this->db->query("SELECT trx.product_id , po.product_name , sum(trx.trx_qty) as total from transactions trx join products po on po.product_id = trx.product_id where po.product_status = 'Active' group by trx.product_id order by total desc limit 1")->getRow();
		$data['js'] = '<script src="'.base_url('assets/apps/js/dashboard.js').'"></script>';

		return view('admin/v_dashboard', $data);
	}

	// hitung total data pada transaction
    public function getCountTrx()
    {
        return $this->transaction_model->countAll();
    }

    // hitung total data pada category
    public function getCountCategory()
    {
        return $this->category_model->countAll();
    }

    // hitung total data pada product
    public function getCountProduct()
    {
        return $this->product_model->countAll();
    }

    // hitung total data pada user
    public function getCountUser()
    {
        return $this->users_model->countAll();
    }

    public function getGrafik()
    {
        $query = $this->db->query("SELECT SUM(trx_price) as total, MONTHNAME(trx_date) as month, COUNT(product_id) as qty FROM transactions GROUP BY MONTHNAME(trx_date) ORDER BY MONTH(trx_date)");
        $hasil = [];
        if(!empty($query)){
            foreach($query->getResultArray() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
        return $hasil;
    }

    public function getLatestTrx()
    {
        return $this->transaction_model
            ->select('products.product_name, transactions.*')
            ->join('products', 'products.product_id = transactions.product_id')
            ->orderBy('transactions.trx_id', 'desc')
            ->limit(5)
            ->get()
            ->getResultArray();
    }

    public function get_chart_json()
    {
        // chart
		$total_transaction	= $this->getCountTrx();
		$total_product  	= $this->getCountProduct();
		$total_category 	= $this->getCountCategory();
		$total_user			= $this->getCountUser();
		$latest_trx			= $this->getLatestTrx();

		$grafik			    = $this->getGrafik();
		$get_grafik			= count($grafik);

        $data = array();

        if(count($grafik) > 0){
            foreach($grafik as $key){
                $data['total'][] = $key['total'];
                $data['bulan'][] = $key['month'];
                $data['qty'][]   = $key['qty'];
            }
        }

        echo json_encode($data);
    }
}
