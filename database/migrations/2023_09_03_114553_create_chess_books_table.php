<?php

use App\Http\Helpers\Constant;
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
        Schema::create('chess_books', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('name');
            $table->enum('type', Constant::$bookTypes);
            $table->unsignedBigInteger('book_type_id');
            $table->foreign('book_type_id')->references('id')->on('book_types')->onDelete('cascade');
            $table->string('book_file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chess_books');
    }
};
