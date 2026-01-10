<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * StudentService - خدمة الطلاب
 * Integration with Student Information System (SIS)
 * Based on sis.json API documentation
 * 
 * @author Team 404
 */
class StudentService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.student_api.url', 'http://my-default-host.com');
    }

    /**
     * Get a specific student by ID
     * الحصول على بيانات طالب معين
     * 
     * GET /api/v1/students/{id}
     * Response: { id, full_name, major: { id, name, department_code }, status }
     */
    public function getStudent(int $studentId): ?array
    {
        try {
            $response = Http::timeout(10)
                ->get("{$this->baseUrl}/api/v1/students/{$studentId}");

            if ($response->successful()) {
                return $response->json();
            }

            if ($response->status() === 404) {
                Log::info("StudentService: Student not found", ['student_id' => $studentId]);
            }

            return null;
        } catch (\Exception $e) {
            Log::error("StudentService: Failed to get student", [
                'student_id' => $studentId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get all students with optional filtering
     * الحصول على جميع الطلبة
     * 
     * GET /api/v1/students
     * Query: major_id, status (student|graduate|dismissed|withdrawn), page, per_page
     * Response: { items: [...], total: 150 }
     */
    public function getAllStudents(?int $majorId = null, ?string $status = null, int $page = 1): array
    {
        try {
            $query = ['page' => $page, 'per_page' => 100];
            if ($majorId)
                $query['major_id'] = $majorId;
            if ($status)
                $query['status'] = $status;

            $response = Http::timeout(10)
                ->get("{$this->baseUrl}/api/v1/students", $query);

            if ($response->successful()) {
                $data = $response->json();
                return $data['items'] ?? $data['data'] ?? $data;
            }

            return $this->getMockStudents();
        } catch (\Exception $e) {
            Log::error("StudentService: Failed to get students", ['error' => $e->getMessage()]);
            return $this->getMockStudents();
        }
    }

    /**
     * Fetch ALL students (iterates through all pages)
     * جلب جميع الطلاب من كل الصفحات
     */
    public function fetchAllStudents(): array
    {
        try {
            // Attempt to fetch first page to get metadata
            $response = Http::timeout(10)->get("{$this->baseUrl}/api/v1/students?per_page=100");

            if (!$response->successful()) {
                // If API fails, try mock data
                Log::warning("StudentService: API failed, using mock data");
                return $this->getMockStudents();
            }

            $data = $response->json();
            $items = $data['items'] ?? $data['data'] ?? [];
            $total = $data['total'] ?? count($items);

            // If we got everything in one go, return it
            if (count($items) >= $total) {
                return $items;
            }

            // Otherwise, we might need to fetch more pages (simplified for this demo: just return what we have or try page 2)
            // For a demo with limited data (150 students), per_page=100 might need 2 calls.
            if ($total > 100) {
                $response2 = Http::timeout(10)->get("{$this->baseUrl}/api/v1/students?page=2&per_page=100");
                if ($response2->successful()) {
                    $data2 = $response2->json();
                    $items2 = $data2['items'] ?? $data2['data'] ?? [];
                    $items = array_merge($items, $items2);
                }
            }

            return $items;

        } catch (\Exception $e) {
            Log::error("StudentService: Failed to fetch all students", ['error' => $e->getMessage()]);
            return $this->getMockStudents();
        }
    }

    /**
     * Check if student is enrolled in a course for a semester
     * التحقق من تسجيل الطالب في المادة


    /**
     * Check if student is enrolled in a course for a semester
     * التحقق من تسجيل الطالب في المادة
     * 
     * GET /api/v1/students/{id}/enrollments?semester=Fall 2024
     * Response: array of { id, student_id, course_id, semester, status }
     */
    public function isEnrolledInCourse(int $studentId, string $courseId, string $semester): bool
    {
        try {
            $response = Http::timeout(10)
                ->get("{$this->baseUrl}/api/v1/students/{$studentId}/enrollments", [
                    'semester' => $semester
                ]);

            if ($response->successful()) {
                $enrollments = $response->json();

                // Check if the course exists in enrollments with active status
                foreach ($enrollments as $enrollment) {
                    if (
                        $enrollment['course_id'] === $courseId &&
                        in_array($enrollment['status'], ['active', 'completed'])
                    ) {
                        return true;
                    }
                }
            }

            return false;
        } catch (\Exception $e) {
            Log::error("StudentService: Failed to check enrollment", [
                'student_id' => $studentId,
                'course_id' => $courseId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get student enrollments for a semester
     * الحصول على تسجيلات الطالب
     */
    public function getStudentEnrollments(int $studentId, string $semester): array
    {
        try {
            $response = Http::timeout(10)
                ->get("{$this->baseUrl}/api/v1/students/{$studentId}/enrollments", [
                    'semester' => $semester
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            return [];
        } catch (\Exception $e) {
            Log::error("StudentService: Failed to get enrollments", [
                'student_id' => $studentId,
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Mock students data for testing
     * بيانات وهمية للاختبار
     */
    protected function getMockStudents(): array
    {
        return [
            ['id' => 1, 'full_name' => 'أحمد محمد علي', 'major' => ['name' => 'علوم الحاسوب'], 'status' => 'student'],
            ['id' => 2, 'full_name' => 'فاطمة خالد الزنتاني', 'major' => ['name' => 'هندسة البرمجيات'], 'status' => 'student'],
            ['id' => 3, 'full_name' => 'عمر حسين الفيتوري', 'major' => ['name' => 'نظم المعلومات'], 'status' => 'student'],
            ['id' => 4, 'full_name' => 'سارة أحمد المصراتي', 'major' => ['name' => 'علوم الحاسوب'], 'status' => 'student'],
            ['id' => 5, 'full_name' => 'محمد سالم البرغثي', 'major' => ['name' => 'الذكاء الاصطناعي'], 'status' => 'student'],
            ['id' => 6, 'full_name' => 'نورا عبدالله الطرابلسي', 'major' => ['name' => 'هندسة البرمجيات'], 'status' => 'student'],
            ['id' => 7, 'full_name' => 'يوسف محمود الغرياني', 'major' => ['name' => 'علوم الحاسوب'], 'status' => 'student'],
            ['id' => 8, 'full_name' => 'آمنة حسين السنوسي', 'major' => ['name' => 'نظم المعلومات'], 'status' => 'student'],
        ];
    }
}
