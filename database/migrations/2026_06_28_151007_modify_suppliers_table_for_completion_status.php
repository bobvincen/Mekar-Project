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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->text('alamat')->nullable()->change();
            $table->string('telepon')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('status')->default('Belum Lengkap')->after('email');
        });

        // Set existing suppliers that have all required fields to 'Lengkap'
        \DB::table('suppliers')
            ->whereNotNull('alamat')
            ->whereNotNull('telepon')
            ->whereNotNull('email')
            ->update(['status' => 'Lengkap']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->text('alamat')->nullable(false)->change();
            $table->string('telepon')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->dropColumn('status');
        });
    }
};
