<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicDegreesTable extends Migration
{
    public function up(): void
    {
        Schema::create('academic_degrees', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('code');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_degrees');
    }
}
