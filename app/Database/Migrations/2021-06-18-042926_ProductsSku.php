<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductsSku extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'sku_id' => [
				'type' 				=> 'INT',
				'constraint'        => 20,
                'unsigned'          => TRUE,
                'auto_increment'    => TRUE
			],
            'category_id'           => [
                'type'              => 'BIGINT',
                'constraint'        => 20,
                'unsigned'          => TRUE,
                'null'              => TRUE
            ],
            'kode'         => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ],
            'bulan'         => [
                'type'              => 'VARCHAR',
                'constraint'        => '2',
            ],
			'tahun'         => [
                'type'              => 'VARCHAR',
                'constraint'        => '2',
            ],
			'counter'         => [
                'type'              => 'INT',
                'constraint'        => '11',
            ],
        ]);
        $this->forge->addKey('sku_id', TRUE);
        $this->forge->createTable('ms_sku');
	}

	public function down()
	{
		$this->forge->dropTable('ms_sku');
	}
}
