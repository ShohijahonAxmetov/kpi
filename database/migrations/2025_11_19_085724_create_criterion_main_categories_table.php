<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriterionMainCategoriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('criterion_main_categories', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->integer('max_score');
            $table->integer('order')->default(1000);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('criterion_main_categories');
    }
}
