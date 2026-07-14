<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFrameTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'idframe'        => ['type' => 'INT', 'auto_increment' => true],
            'nama_frame'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'idbentuk_frame' => ['type' => 'INT', 'null' => true],
            'idbahan_frame'  => ['type' => 'INT', 'null' => true],
            'harga_jual'     => ['type' => 'INT', 'null' => true],
            'harga_beli'     => ['type' => 'INT', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('idframe');
        $this->forge->createTable('frame');
    }

    public function down(): void
    {
        $this->forge->dropTable('frame', true);
    }
}
