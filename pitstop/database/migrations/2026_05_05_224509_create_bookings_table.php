<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('slot', ['A', 'B', 'C']);
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('jenis_kendaraan');
            $table->string('merek_kendaraan');
            $table->string('nomor_plat');
            $table->unsignedInteger('total_estimasi_harga')->default(0);
            $table->unsignedInteger('total_estimasi_durasi')->default(0);
            $table->enum('status', [
                'pending',
                'diproses',
                'selesai',
                'dibatalkan'
            ])->default('pending');
            $table->text('pesan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
