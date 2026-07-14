<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBentukLensaTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'idbentuk_lensa' => ['type' => 'INT', 'auto_increment' => true],
            'nama_bentuk'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addPrimaryKey('idbentuk_lensa');
        $this->forge->createTable('bentuk_lensa');
    }

    public function down(): void
    {
        $this->forge->dropTable('bentuk_lensa', true);
    }
}
