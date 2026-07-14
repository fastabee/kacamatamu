<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBentukFrameTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'idbentuk_frame' => ['type' => 'INT', 'auto_increment' => true],
            'nama_bentuk'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addPrimaryKey('idbentuk_frame');
        $this->forge->createTable('bentuk_frame');
    }

    public function down(): void
    {
        $this->forge->dropTable('bentuk_frame', true);
    }
}
