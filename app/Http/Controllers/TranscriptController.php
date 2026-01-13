<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Services\StudentService;
use App\Services\StaffService;
use App\Services\CourseService;
use App\Helpers\GradeHelper;
use Illuminate\Http\JsonResponse;

/**
 * TranscriptController - متحكم السجل الأكاديمي
 * Provides student transcript API
 * 
 * @author Team 404
 */
class TranscriptController extends Controller
{
    public function __construct(
        protected StudentService $studentService,
        protected StaffService $staffService,
        protected CourseService $courseService
    ) {
    }

    /**
     * Get student transcript
     * الحصول على السجل الأكاديمي للطالب
     * 
     * GET /api/transcript/{student_id}
     */
    public function show(int $student_id): JsonResponse
    {
        // Get student info from mock data
        $allStudents = $this->studentService->getAllStudents();
        $student = collect($allStudents)->firstWhere('id', $student_id);

        // Get all grades for this student
        $grades = Grade::where('student_id', $student_id)
            ->orderBy('semester')
            ->orderBy('course_id')
            ->get();

        if ($grades->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'لا توجد درجات مسجلة لهذا الطالب'
            ], 404);
        }

        // Build transcript records with course and staff details
        $records = [];
        $gradesForGPA = [];

        foreach ($grades as $grade) {
            // Get course details from mock service
            $course = $this->courseService->getCourse($grade->course_id);
            $credits = $course['credits'] ?? 3;

            // Get staff name who graded
            $staffName = null;
            if ($grade->graded_by) {
                $staff = $this->staffService->getStaffById($grade->graded_by);
                $staffName = $staff['name'] ?? null;
            }

            $totalScore = $grade->total_score;
            $letterGrade = GradeHelper::getLetterGrade($totalScore);

            $records[] = [
                'course_id' => $grade->course_id,
                'course_name' => $course['name'] ?? $grade->course_id,
                'course_name_ar' => $course['name_ar'] ?? null,
                'semester' => $grade->semester,
                'credits' => $credits,
                'coursework_score' => (float) $grade->coursework_score,
                'final_score' => (float) $grade->final_score,
                'total' => $totalScore,
                'grade' => $letterGrade,
                'grade_description' => GradeHelper::getGradeDescription($letterGrade),
                'passed' => GradeHelper::isPassing($totalScore),
                'graded_by' => $staffName,
                'graded_at' => $grade->updated_at->toDateTimeString(),
            ];

            // Collect for GPA calculation
            $gradesForGPA[] = [
                'total_score' => $totalScore,
                'credits' => $credits
            ];
        }

        // Calculate GPA
        $gpa = GradeHelper::calculateGPA($gradesForGPA);
        $totalCredits = array_sum(array_column($gradesForGPA, 'credits'));
        $passedCredits = array_sum(array_map(function ($g) {
            return GradeHelper::isPassing($g['total_score']) ? $g['credits'] : 0;
        }, $gradesForGPA));

        return response()->json([
            'success' => true,
            'data' => [
                'student_id' => $student_id,
                'student_name' => $student['full_name'] ?? 'N/A',
                'records' => $records,
                'summary' => [
                    'total_courses' => count($records),
                    'total_credits' => $totalCredits,
                    'passed_credits' => $passedCredits,
                    'gpa' => $gpa,
                    'gpa_scale' => '4.0'
                ]
            ]
        ]);
    }
}
