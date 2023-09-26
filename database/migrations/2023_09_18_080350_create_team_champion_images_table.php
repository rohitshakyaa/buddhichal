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
        Schema::create('team_champion_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_champion_id');
            $table->foreign('team_champion_id')->references('id')->on('team_champions')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_champion_images');
    }
};
