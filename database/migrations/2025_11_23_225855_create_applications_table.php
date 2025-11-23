<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('criterion_id')->constrained()->onDelete('cascade');
            $table->foreignId('criterion_item_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('basis')->nullable();
            $table->text('comment')->nullable();
            $table->integer('status')->default(1);
            $table->text('answer')->nullable();
            $table->integer('score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
