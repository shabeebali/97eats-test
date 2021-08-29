<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRestaurantsTable extends Migration
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
			'category' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
			],
			'location' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
			],
			'description' => [
				'type' => 'TEXT',
				'null' => TRUE
			],
			'thumbnail_image' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
				'null'=> true
			],
			'cover_image' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
				'null'=> true
			],
			'delivery_charge' => [
				'type' => 'DECIMAL',
				'constraint' => '10,2',
				'null' => true
			],
			'delivery_method' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
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
		$this->forge->createTable('restaurants');
	}

	public function down()
	{
		$this->forge->dropTable('restaurants');
	}
}
