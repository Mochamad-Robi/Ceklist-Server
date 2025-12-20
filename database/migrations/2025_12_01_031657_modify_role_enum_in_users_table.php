<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum role untuk menambah super_admin dan viewer
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'inspector', 'viewer') DEFAULT 'inspector'");
    }

    public function down(): void
    {
        // Kembalikan ke enum lama
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'inspector') DEFAULT 'inspector'");
    }
};