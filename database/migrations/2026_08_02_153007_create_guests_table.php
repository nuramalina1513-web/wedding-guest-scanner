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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('code')->unique();

            //maksimal orang yang boleh datang dari satu undangan
            $table->unsignedTinyInteger('invitation_limit')->default(1);

            //jumlah orang yang benar-benar hadir
            $table->unsignedTinyInteger('attended_count')->default(0);

            //kosong berarti barcode belum digunakan
            $table->timestamp('scanned_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
