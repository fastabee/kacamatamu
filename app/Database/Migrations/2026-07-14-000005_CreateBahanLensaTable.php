<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBahanLensaTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'idbahan_lensa' => ['type' => 'INT', 'auto_increment' => true],
            'nama_bahan'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addPrimaryKey('idbahan_lensa');
        $this->forge->createTable('bahan_lensa');
    }

    public function down(): void
    {
        $this->forge->dropTable('bahan_lensa', true);
    }
}
