<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
	public function up()
	{
		$this->forge->addField([
            'id'            => [
                'type'              => 'BIGINT',
                'constraint'        => 20,
                'unsigned'          => TRUE,
                'auto_increment'    => TRUE
            ],
            'username'              => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
                'unique'            => TRUE,
            ],
            'email'                 => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ],
            'password'              => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
            ],
			'created_at' => [
				'type'           => 'DATETIME',
				'null'       	 => true,
			],
			'updated_at' => [
				'type'           => 'DATETIME',
				'null'       	 => true,
			]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('users');
	}

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
