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
        Schema::table('categories', function (Blueprint $table) {
            // 先將 category_type 欄位設置為可為 null
            $table->string('category_type')->nullable()->change();
        });
    
        // 然後更改欄位名稱
        if (Schema::hasColumn('categories', 'category_type')) {
            DB::statement('ALTER TABLE categories CHANGE category_type category_id VARCHAR(255)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 反向操作
        if (Schema::hasColumn('categories', 'category_id')) {
            DB::statement('ALTER TABLE categories CHANGE category_id category_type VARCHAR(255)');
        }

        Schema::table('categories', function (Blueprint $table) {
            // 將 category_id 設置回不可為 null
            $table->string('category_id')->nullable(false)->change();
        });
    }
};
