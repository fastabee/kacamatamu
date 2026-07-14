<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJabatanTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'idjabatan'    => ['type' => 'INT', 'auto_increment' => true],
            'nama_jabatan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'deleted'      => ['type' => 'INT', 'null' => true, 'comment' => '0 = ada, 1 = dihapus'],
        ]);
        $this->forge->addPrimaryKey('idjabatan');
        $this->forge->createTable('jabatan');
    }

    public function down(): void
    {
        $this->forge->dropTable('jabatan', true);
    }
}
