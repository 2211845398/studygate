<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * جدول الدرجات - Team 404
     */
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            
            // External IDs from other microservices
            $table->unsignedBigInteger('student_id');  // من نظام الطلاب - Team CodeWave
            $table->string('course_id', 20);           // من نظام المواد - Team CYPERWAVE
            $table->string('semester', 20);            // الفصل الدراسي مثل "Fall 2024"
            
            // Scores
            $table->decimal('coursework_score', 5, 2)->nullable();  // أعمال السنة - من 40
            $table->decimal('final_score', 5, 2)->nullable();       // الامتحان النهائي - من 60
            
            // Graded by (Staff ID from Team DevX)
            $table->unsignedBigInteger('graded_by')->nullable();
            
            $table->timestamps();
            
            // Prevent duplicate grades for same student in same course and semester
            $table->unique(['student_id', 'course_id', 'semester'], 'unique_grade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
