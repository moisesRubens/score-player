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
        Schema::create('players_performance', function (Blueprint $table) {
            $table->foreignId('player_id')->constrained()->cascadeOnDelete();
            $table->foreignId('match_id')->constrained()->cascadeOnDelete();

            $table->integer('individual_kills')->default(0);
            $table->integer('individual_survive')->default(0);
            $table->enum('map', ['erangel', 'miramar', 'rondo']);

            $table->timestamps();

            $table->primary(['player_id', 'match_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players_performance');
    }
};
