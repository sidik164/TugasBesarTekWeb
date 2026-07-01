<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateModulPelatihanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'judul' => ['type' => 'VARCHAR', 'constraint' => 150],
            'urutan' => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('modul_pelatihan', true);
    }

    public function down()
    {
        $this->forge->dropTable('modul_pelatihan', true);
    }
}