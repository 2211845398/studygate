<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Grade Model - نموذج الدرجات
 * Team 404 - Examination & Grades System
 */
class Grade extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'student_id',
        'course_id',
        'semester',
        'coursework_score',
        'final_score',
        'graded_by',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'student_id' => 'integer',
        'coursework_score' => 'decimal:2',
        'final_score' => 'decimal:2',
        'graded_by' => 'integer',
    ];

    /**
     * Calculate total score (coursework + final)
     * حساب الدرجة الكلية
     */
    public function getTotalScoreAttribute(): float
    {
        return ($this->coursework_score ?? 0) + ($this->final_score ?? 0);
    }

    /**
     * Get letter grade based on total score
     * الحصول على التقدير الحرفي
     */
    public function getLetterGradeAttribute(): string
    {
        $total = $this->total_score;

        if ($total >= 90)
            return 'A';
        if ($total >= 80)
            return 'B';
        if ($total >= 70)
            return 'C';
        if ($total >= 60)
            return 'D';
        return 'F';
    }

    /**
     * Get grade points for GPA calculation
     * نقاط التقدير لحساب المعدل
     */
    public function getGradePointsAttribute(): float
    {
        $total = $this->total_score;

        if ($total >= 90)
            return 4.0;
        if ($total >= 80)
            return 3.0;
        if ($total >= 70)
            return 2.0;
        if ($total >= 60)
            return 1.0;
        return 0.0;
    }
}
