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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('имя');
            $table->string('slug')->unique()->comment('slug');
            $table->string('short_desc')->nullable()->comment('короткое описание');
            $table->text('description')->nullable()->comment('описание');
            $table->string('file_name', 128)->nullable()->comment('название файла');
            $table->unsignedBigInteger('category_id')->comment('ID категории');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
