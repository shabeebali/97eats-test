<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateItemAddonOptionsTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'name' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
			],
			'price' => [
				'type' => 'DECIMAL',
				'constraint' => '10,2',
			],
			'item_addon_id' => [
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => true
			],
			'created_at' => [
				'type' => 'TIMESTAMP',
				'null' => true
			],
			'updated_at' => [
				'type' => 'TIMESTAMP',
				'null' => true
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('item_addon_options');
	}

	public function down()
	{
		$this->forge->dropTable('item_addon_options');
	}
}
