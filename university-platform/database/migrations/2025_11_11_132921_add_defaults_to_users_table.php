<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('bio')->nullable()->default('')->change();
            $table->string('avatar')->nullable()->default('')->change();
        });

        // Update existing null values to empty strings
        DB::table('users')->whereNull('bio')->update(['bio' => '']);
        DB::table('users')->whereNull('avatar')->update(['avatar' => '']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
