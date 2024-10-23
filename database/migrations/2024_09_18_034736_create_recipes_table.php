<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('instructions'); 
            $table->text('ingredient'); 
            $table->string('cook_method')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('prep_time')->nullable();
            $table->integer('cook_time')->nullable();
            $table->decimal('price')->nullable();
            $table->integer('time')->nullable();
            $table->integer('servings')->nullable();
            $table->string('cuisine')->nullable();
            $table->unsignedBigInteger('purpose_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
