<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBahanFrameTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'idbahan_frame' => ['type' => 'INT', 'auto_increment' => true],
            'nama_bahan'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addPrimaryKey('idbahan_frame');
        $this->forge->createTable('bahan_frame');
    }

    public function down(): void
    {
        $this->forge->dropTable('bahan_frame', true);
    }
}
