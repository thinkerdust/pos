<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Product_model;
use App\Models\Category_model;
use App\Models\Sku_model;
use App\Models\Transaction_model;

class Product extends BaseController
{
    public $db;
 
    public function __construct()
    {
        $this->category_model = new Category_model();
        $this->product_model = new Product_model();
        $this->sku_model = new Sku_model();
        $this->transaction_model = new Transaction_model();
        $this->db = \Config\Database::connect();
    }

	public function index()
	{
		$data['sidebar'] = 'product';
        $get_category = $this->category_model->getCategory()->getResultArray();
        $category[-1] = '-- Select Category --';
        foreach($get_category as $key){
            $category[$key['category_id']] = $key['category_name'];
        }
        $data['category'] = $category;

        echo view('admin/v_product', $data);
	}

    public function ajax_load_data()
	{
		$params['draw'] = $_REQUEST['draw'];
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
		$search_value = $_REQUEST['search']['value'];

		$column_order = array(null, null, 'products.product_sku', 'products.product_name', 'categories.category_name', 'products.product_price', 'products.product_status', null);
		$order_name = (isset($_REQUEST['order'])) ? $column_order[$_REQUEST['order']['0']['column']] : 'products.product_id';
		$order_dir = (isset($_REQUEST['order'])) ? $_REQUEST['order']['0']['dir'] : 'desc';
		$order = null;
		if (!empty($order_name) && !empty($order_dir)) {
			$order = ' ORDER BY ' . $order_name . ' ' . $order_dir;
		}
        
		$condition = '';
		if(!empty($search_value)){
			$condition = "WHERE products.product_sku like '%".$search_value."%' OR products.product_name like '%".$search_value."%' OR categories.category_name like '%".$search_value."%' OR products.product_price like '%".$search_value."%' OR products.product_status like '%".$search_value."%'";
		}

		if ($length == -1) {
            $length = $this->db->query("SELECT count(*) as jumlah from products join categories on categories.category_id = products.category_id $condition")->getResult();
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }

		$data = array();
		$query = $this->db->query("SELECT * from products join categories on categories.category_id = products.category_id $condition $order limit $start, $length")->getResult();
		$total_count = $this->db->query("SELECT * from products join categories on categories.category_id = products.category_id $condition")->getResult();
        if(!empty($query)){
			$no = 0;
            foreach($query as $key){
				$no++;

				$btn = '<a href="#" class="btn btn-success btn-sm" title="edit" onclick="editProduct('.$key->product_id.')"><i class="fas fa-edit"></i></a>&nbsp
						<a href="#" class="btn btn-danger btn-sm" title="hapus" onclick="deleteProduct('.$key->product_id.')"><i class="fas fa-trash"></i></a>';

                $link_img = base_url('uploads/'.$key->product_image);
                $thumbnail = '<a href="#" onclick="zoomImg(\''. $link_img . '\')">
                                <img src="'.$link_img.'" class="rounded-circle" width="80" height="80" alt="product image">
                            </a>';

				$row = array();
				$row[] = $no;
                $row[] = $thumbnail;
				$row[] = $key->product_sku;
				$row[] = $key->product_name;
				$row[] = $key->category_name;
				$row[] = 'Rp. '.number_format($key->product_price);
                $row[] = $key->product_stock;
				$row[] = $key->product_status;
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

            // get file upload
            $image = $this->request->getFile('product_image');
            $name = '';
            if ($image->isValid() && !$image->hasMoved())
            {
                // random name file
                $name = $image->getRandomName();
                // upload file 
                $image->move(ROOTPATH . 'public/uploads', $name);
            }

            $id = $this->request->getPost('product_id');
            $category_id = $this->request->getPost('category_id');
        
            $data = array(
                'category_id'           => $category_id,
                'product_name'          => $this->request->getPost('product_name'),
                'product_price'         => preg_replace('/[^0-9]/', '', $this->request->getPost('product_price')),
                'product_status'        => $this->request->getPost('product_status'),
                'product_description'   => $this->request->getPost('product_desc'),
                'product_stock'         => $this->request->getPost('product_stock'),
            );

            if(!empty($name)){
                $data['product_image'] = $name;
            }
        
            // insert or update
            if(!empty($id)){
                $cek_category = $this->product_model->getWhere(['product_id' => $id])->getRow();
                if($cek_category->category_id !== $category_id) {
                    $sku = $this->get_sku($category_id);
                    $data['product_sku'] = $sku['no_nota'];
                }
                $simpan = $this->product_model->updateProduct($data,$id);
            }else{
                $sku = $this->get_sku($category_id);
                $data['product_sku'] = $sku['no_nota'];
                $simpan = $this->product_model->insertProduct($data);
            }

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
		$data = $this->product_model->getProduct($id);
		echo json_encode($data);
    }

    public function delete($id)
    {
        $data = $this->product_model->getProduct($id);
        
        if(!empty($data)){
            $this->db->transStart();
            $this->deleteImg($data['product_image']);
            $this->product_model->deleteProduct($id);
            $this->transaction_model->where('product_id', $id)->delete();
            $this->db->transComplete();

            return json_encode(TRUE);
        }
        return json_encode(FALSE);
    }

    public function deleteImg($img)
    {
        $pathtodir = $_SERVER['DOCUMENT_ROOT'];
        $pathimg = "\\uploads\\".$img;
        $path = $pathtodir.$pathimg;
        return unlink($path);
    }

    public function get_sku($id)
    {
        $get_no = $this->sku_model->get_counter($id);
        $data = array(
            'bulan'                 => $get_no['bulan'],
            'tahun'                 => $get_no['tahun'],
            'counter'				=> $get_no['set_nomor'],
        );

        $ubah_sku = $this->sku_model->updateSku($data, $id);
        return $get_no;
    }
}
