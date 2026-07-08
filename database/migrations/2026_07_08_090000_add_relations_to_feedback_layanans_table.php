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
        Schema::table('feedback_layanans', function (Blueprint $table) {
            $table->foreignId('transaksi_id')->nullable()->after('id')->constrained('transaksis')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->after('transaksi_id')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback_layanans', function (Blueprint $table) {
            $table->dropForeign(['transaksi_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['transaksi_id', 'user_id']);
        });
    }
};
