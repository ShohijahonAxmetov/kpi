<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('passport_number')->unique();
            // $table->string('student_passport_number');
            $table->text('surname')->nullable();
            $table->text('father_name')->nullable();
            $table->foreignId('university_id')->nullable()->constrained();
            $table->foreignId('faculty_id')->nullable()->constrained();
            $table->foreignId('direction_id')->nullable()->constrained();
            // $table->foreignId('scholarship_id')->nullable()->constrained();
            $table->string('password');

            $table->foreignId('academic_title_id')->constrained();
            $table->foreignId('academic_degree_id')->constrained();
            $table->foreignId('rank_id')->constrained();

            $table->float('ielts_points')->default(0);
            $table->float('patents_points')->default(0);
            $table->float('articles_points')->default(0);
            $table->float('projects_points')->default(0);
            $table->float('schoolarships_points')->default(0);
            $table->float('tests_points')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
}
