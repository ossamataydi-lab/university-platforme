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
    // No need to rename column, already created as filiere_id
    }


    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->renameColumn('filiere_id', 'filiers_id');
        });
    }
};
