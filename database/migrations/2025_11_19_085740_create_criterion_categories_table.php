<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriterionCategoriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('criterion_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criterion_main_category_id')->constrained()->onDelete('cascade');
            $table->text('name');
            $table->integer('max_score');
            $table->integer('order')->default(1000);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('criterion_categories');
    }
}
