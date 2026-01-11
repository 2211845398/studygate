<?php

namespace App\Helpers;

/**
 * GradeHelper - مساعد حسابات الدرجات
 * Helper class for grade calculations
 * 
 * @author Team 404
 */
class GradeHelper
{
    /**
     * Calculate letter grade from total score
     * حساب التقدير الحرفي
     */
    public static function getLetterGrade(float $totalScore): string
    {
        if ($totalScore >= 90)
            return 'A';
        if ($totalScore >= 80)
            return 'B';
        if ($totalScore >= 70)
            return 'C';
        if ($totalScore >= 60)
            return 'D';
        return 'F';
    }

    /**
     * Calculate grade points from total score
     * حساب نقاط التقدير
     */
    public static function getGradePoints(float $totalScore): float
    {
        if ($totalScore >= 90)
            return 4.0;
        if ($totalScore >= 80)
            return 3.0;
        if ($totalScore >= 70)
            return 2.0;
        if ($totalScore >= 60)
            return 1.0;
        return 0.0;
    }

    /**
     * Calculate GPA from an array of grades with credits
     * حساب المعدل التراكمي
     * 
     * @param array $grades Array of ['total_score' => float, 'credits' => int]
     * @return float
     */
    public static function calculateGPA(array $grades): float
    {
        if (empty($grades)) {
            return 0.0;
        }

        $totalPoints = 0;
        $totalCredits = 0;

        foreach ($grades as $grade) {
            $totalScore = $grade['total_score'] ?? 0;
            $credits = $grade['credits'] ?? 3;

            $gradePoints = self::getGradePoints($totalScore);
            $totalPoints += $gradePoints * $credits;
            $totalCredits += $credits;
        }

        if ($totalCredits === 0) {
            return 0.0;
        }

        return round($totalPoints / $totalCredits, 2);
    }

    /**
     * Get grade description in Arabic
     * وصف التقدير بالعربية
     */
    public static function getGradeDescription(string $letterGrade): string
    {
        return match ($letterGrade) {
            'A' => 'ممتاز',
            'B' => 'جيد جداً',
            'C' => 'جيد',
            'D' => 'مقبول',
            'F' => 'راسب',
            default => 'غير محدد',
        };
    }

    /**
     * Check if grade is passing
     * التحقق من النجاح
     */
    public static function isPassing(float $totalScore): bool
    {
        return $totalScore >= 60;
    }
}
