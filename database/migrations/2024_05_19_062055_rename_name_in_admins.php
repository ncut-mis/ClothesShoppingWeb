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
        Schema::table('admins', function (Blueprint $table) {
            if (Schema::hasColumn('admins', 'name')) {
                DB::statement('ALTER TABLE `admins` CHANGE `name` `LastName` VARCHAR(255)');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            if (Schema::hasColumn('admins', 'LastName')) {
                DB::statement('ALTER TABLE `admins` CHANGE `LastName` `name` VARCHAR(255)');
            }
        });
    }
};
