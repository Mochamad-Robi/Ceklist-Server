<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('server_checklists', function (Blueprint $table) {
            $table->id();
            $table->date('inspection_date');
            $table->string('inspector_name');
            $table->json('checklist_data');
            $table->integer('total_items')->default(0);
            $table->integer('checked_items')->default(0);
            $table->integer('ok_items')->default(0);
            $table->integer('not_ok_items')->default(0);
            $table->integer('attention_items')->default(0);
            $table->string('status')->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_checklists');
    }
};