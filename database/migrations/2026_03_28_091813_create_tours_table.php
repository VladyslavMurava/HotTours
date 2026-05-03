<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('tours', function (Blueprint $table) {
        $table->id();
        $table->foreignId('destination_id'); // Зовнішній ключ
        $table->string('title'); // Назва туру
        $table->text('description')->nullable(); // Опис туру
        $table->integer('price'); // Ціна
        $table->integer('duration'); // Тривалість у днях
        $table->date('departure_date')->nullable(); // Дата вильоту
        $table->string('image')->nullable(); // Фотографія
        $table->boolean('is_hot')->default(true); // Ознака гарячого туру
        
        // Обмеження зовнішнього ключа
        $table->foreign('destination_id')->references('id')->on('destinations')
              ->onDelete('CASCADE')->onUpdate('CASCADE');
              
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
