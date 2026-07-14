<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLensaTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            // Kolom PK di SQL asli memang bernama idframe (bukan idlensa)
            'idframe'        => ['type' => 'INT', 'auto_increment' => true],
            'nama_lensa'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'idbentuk_lensa' => ['type' => 'INT', 'null' => true],
            'idbahan_lensa'  => ['type' => 'INT', 'null' => true],
            'harga_beli'     => ['type' => 'TEXT', 'null' => true],
            'harga_jual'     => ['type' => 'TEXT', 'null' => true],
            'deleted'        => ['type' => 'INT', 'null' => true, 'comment' => '0 ada, 1 dihapus'],
        ]);
        $this->forge->addPrimaryKey('idframe');
        $this->forge->createTable('lensa');
    }

    public function down(): void
    {
        $this->forge->dropTable('lensa', true);
    }
}
