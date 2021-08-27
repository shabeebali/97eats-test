<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTokensTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'token' => [
				'type' => 'VARCHAR',
				'constraint' => 256
			],
			'user_id' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => true
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('user_tokens');
	}

	public function down()
	{
		$this->forge->dropTable('user_tokens');
	}
}
