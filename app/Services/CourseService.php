<?php

namespace App\Services;

/**
 * CourseService - خدمة المواد (Mock)
 * Mock Service for Team CYPERWAVE Course System (API not ready yet)
 * 
 * @author Team 404
 */
class CourseService
{
    /**
     * Mock course data
     * بيانات وهمية للمواد
     */
    protected array $mockCourses = [
        'CS101' => [
            'id' => 'CS101',
            'name' => 'Introduction to Programming',
            'name_ar' => 'مقدمة في البرمجة',
            'credits' => 3,
            'department' => 'Computer Science',
        ],
        'CS201' => [
            'id' => 'CS201',
            'name' => 'Data Structures',
            'name_ar' => 'هياكل البيانات',
            'credits' => 3,
            'department' => 'Computer Science',
        ],
        'CS301' => [
            'id' => 'CS301',
            'name' => 'Algorithms',
            'name_ar' => 'الخوارزميات',
            'credits' => 3,
            'department' => 'Computer Science',
        ],
        'ITSE421' => [
            'id' => 'ITSE421',
            'name' => 'Software Engineering',
            'name_ar' => 'هندسة البرمجيات',
            'credits' => 3,
            'department' => 'Information Technology',
        ],
        'ITSE422' => [
            'id' => 'ITSE422',
            'name' => 'Database Systems',
            'name_ar' => 'نظم قواعد البيانات',
            'credits' => 3,
            'department' => 'Information Technology',
        ],
        'MATH101' => [
            'id' => 'MATH101',
            'name' => 'Calculus I',
            'name_ar' => 'التفاضل والتكامل 1',
            'credits' => 4,
            'department' => 'Mathematics',
        ],
        'MATH201' => [
            'id' => 'MATH201',
            'name' => 'Linear Algebra',
            'name_ar' => 'الجبر الخطي',
            'credits' => 3,
            'department' => 'Mathematics',
        ],
        'PHYS101' => [
            'id' => 'PHYS101',
            'name' => 'Physics I',
            'name_ar' => 'الفيزياء 1',
            'credits' => 4,
            'department' => 'Physics',
        ],
    ];

    /**
     * Get course by ID
     * الحصول على مادة حسب الرقم
     * 
     * @param string $courseId
     * @return array|null
     */
    public function getCourse(string $courseId): ?array
    {
        return $this->mockCourses[strtoupper($courseId)] ?? null;
    }

    /**
     * Get all available courses
     * الحصول على جميع المواد المتاحة
     * 
     * @return array
     */
    public function getAllCourses(): array
    {
        return array_values($this->mockCourses);
    }

    /**
     * Check if course exists
     * التحقق من وجود المادة
     * 
     * @param string $courseId
     * @return bool
     */
    public function courseExists(string $courseId): bool
    {
        return isset($this->mockCourses[strtoupper($courseId)]);
    }

    /**
     * Get course credits
     * الحصول على الساعات المعتمدة للمادة
     * 
     * @param string $courseId
     * @return int
     */
    public function getCourseCredits(string $courseId): int
    {
        $course = $this->getCourse($courseId);
        return $course['credits'] ?? 3;
    }

    /**
     * Get courses by department
     * الحصول على مواد حسب القسم
     * 
     * @param string $department
     * @return array
     */
    public function getCoursesByDepartment(string $department): array
    {
        return array_filter($this->mockCourses, function ($course) use ($department) {
            return strtolower($course['department']) === strtolower($department);
        });
    }
}
