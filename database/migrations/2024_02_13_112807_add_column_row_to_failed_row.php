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

        if (!Schema::hasTable('failed_rows')) {
            Schema::create('failed_rows', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
            });
        }

        // Теперь добавляем столбец 'row'
        Schema::table('failed_rows', function (Blueprint $table) {
            $table->unsignedBigInteger('row')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('failed_rows', function (Blueprint $table) {
            $table->dropColumn('row');
        });
    }
};
