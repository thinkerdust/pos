<?php

namespace App\Models;

use CodeIgniter\Model;

class Sku_model extends Model
{
	protected $table = 'ms_sku';

	public function get_counter($id) {
		$date1 = date("y-m-d");
        $date = date_create($date1);
        $y    = date_format($date, "y");
        $m    = date_format($date, "m");

        $no_nota = "";
        $set_no = "";
        
        $bln = "";
        $thn = "";

        //Cek Nomor Counter
        $cek = $this->db->table($this->table)->getWhere(['category_id' => $id])->getRow();
		
		if ($cek->bulan != $m || $cek->tahun !=$y) {
            $set_no = 1;
            $bln = $m;
            $thn = $y;
            $no_nota = "000" . $set_no;
        } else {
            $bln = $m;
            $thn = $y;
            $set_no = $cek->counter + 1;

            if (strlen($set_no) == 1) {
                $no_nota = "000" . $set_no;
            } elseif (strlen($set_no) == 2) {
                $no_nota = "00" . $set_no;
            } elseif (strlen($set_no) == 3) {
                $no_nota = "0" . $set_no;
            } else {
                $no_nota = $set_no;
            }
        }
        // === Output nomor nota === //
        $auto_no_nota = $cek->kode .'-'. $thn . $bln .'-'. $no_nota;
        $data = array(
          'no_nota'   => $auto_no_nota,
          'set_nomor' => $set_no,
          'bulan' => $bln,
          'tahun' => $thn);
        return $data;
	}

	public function insertSku($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

	public function updateSku($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['category_id' => $id]);
    }
}
