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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // bank_transfer, qris, e_wallet
            $table->string('name');
            $table->string('account_number')->nullable();
            $table->string('account_owner')->nullable();
            $table->string('image_path')->nullable(); // Logo or QRIS Image
            $table->text('description')->nullable(); // QRIS instructions
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Seed default methods so invoice payment details display immediately
        DB::table('payment_methods')->insert([
            [
                'type' => 'bank_transfer',
                'name' => 'BCA Transfer',
                'account_number' => '123456789',
                'account_owner' => 'Mekar Pharmacy',
                'image_path' => null,
                'description' => null,
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'qris',
                'name' => 'GPN / QRIS MEKAR PHARMACY',
                'account_number' => null,
                'account_owner' => null,
                'image_path' => null,
                'description' => 'Scan QRIS Resmi Mekar Pharmacy menggunakan aplikasi perbankan atau e-wallet Anda.',
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
