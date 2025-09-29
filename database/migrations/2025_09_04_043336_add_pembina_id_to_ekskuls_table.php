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
    Schema::table('ekskuls', function (Blueprint $table) {
        $table->unsignedBigInteger('pembina_id')->after('id');
    });
}

public function down(): void
{
    Schema::table('ekskuls', function (Blueprint $table) {
        $table->dropColumn('pembina_id');
    });
}

};
