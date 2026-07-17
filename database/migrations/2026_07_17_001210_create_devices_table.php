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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('marque');
            $table->string('numero_serie')->unique();
            $table->string('etat'); // neuf, bon, en panne
            $table->date('date_achat');
            $table->text('description')->nullable();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
