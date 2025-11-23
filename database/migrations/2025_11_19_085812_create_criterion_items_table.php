<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriterionItemsTable extends Migration
{
    public function up(): void
    {
        Schema::create('criterion_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criterion_id')->constrained()->onDelete('cascade');
            $table->text('name');
            $table->integer('max_score');
            $table->string('is_need_basis')->default(0);
            $table->integer('order')->default(1000);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('criterion_items');
    }
}
