<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * StaffService - خدمة الموظفين الأكاديميين
 * Integration with Academic Staff Management System
 * Based on Staff-Managementapi-docs.json
 * Requires Bearer Token authentication
 * 
 * @author Team 404
 */
class StaffService
{
    protected string $baseUrl;
    protected string $token;

    public function __construct()
    {
        $this->baseUrl = config('services.staff_api.url', 'http://127.0.0.1:8000');
        $this->token = config('services.staff_api.token', '');
    }

    /**
     * Get all staff members with optional filtering
     * الحصول على جميع الموظفين
     * 
     * GET /api/v1/staff
     * Query: academic_rank (lecturer|assistant), page
     * Headers: Authorization: Bearer {token}
     * Response: { success, data: [...], links, meta }
     */
    public function getAllStaff(?string $academicRank = null, int $page = 1): ?array
    {
        try {
            $query = ['page' => $page];
            if ($academicRank) {
                $query['academic_rank'] = $academicRank;
            }

            $response = Http::timeout(10)
                ->withToken($this->token)
                ->get("{$this->baseUrl}/api/v1/staff", $query);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? $data;
            }

            if ($response->status() === 401) {
                Log::error("StaffService: Unauthorized - Invalid token");
            }

            return null;
        } catch (\Exception $e) {
            Log::error("StaffService: Exception occurred", [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get a specific staff member by ID
     * الحصول على موظف معين
     * 
     * GET /api/v1/staff/{staff_id}
     * Response: { success, data: { id, name, title, email, faculty_id, phone, office, academic_rank } }
     */
    public function getStaffById(int $staffId): ?array
    {
        try {
            $response = Http::timeout(10)
                ->withToken($this->token)
                ->get("{$this->baseUrl}/api/v1/staff/{$staffId}");

            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? $data;
            }

            if ($response->status() === 401) {
                Log::error("StaffService: Unauthorized - Invalid token");
            }

            if ($response->status() === 404) {
                Log::warning("StaffService: Staff not found", ['staff_id' => $staffId]);
            }

            return null;
        } catch (\Exception $e) {
            Log::error("StaffService: Failed to get staff", [
                'staff_id' => $staffId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get staff members by faculty
     * الحصول على موظفين حسب الكلية
     * 
     * GET /api/v1/faculties/{faculty_id}/staff
     */
    public function getStaffByFaculty(int $facultyId): ?array
    {
        try {
            $response = Http::timeout(10)
                ->withToken($this->token)
                ->get("{$this->baseUrl}/api/v1/faculties/{$facultyId}/staff");

            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? $data;
            }

            return null;
        } catch (\Exception $e) {
            Log::error("StaffService: Failed to get faculty staff", [
                'faculty_id' => $facultyId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Validate if staff member exists
     * التحقق من وجود الموظف
     */
    public function staffExists(int $staffId): bool
    {
        return $this->getStaffById($staffId) !== null;
    }

    /**
     * Get all staff for dropdown selection (fetches all pages)
     * الحصول على جميع الموظفين للقائمة المنسدلة
     */
    public function getAllStaffForDropdown(): array
    {
        try {
            $allStaff = [];
            $page = 1;
            $maxPages = 25; // Safety limit

            do {
                $response = Http::timeout(10)
                    ->withToken($this->token)
                    ->get("{$this->baseUrl}/api/v1/staff", ['page' => $page]);

                if (!$response->successful()) {
                    break;
                }

                $data = $response->json();
                $staffOnPage = $data['data'] ?? [];
                $allStaff = array_merge($allStaff, $staffOnPage);

                // Check if there are more pages
                $totalPages = $data['meta']['total_pages'] ?? 1;
                $page++;

            } while ($page <= $totalPages && $page <= $maxPages);

            if (count($allStaff) > 0) {
                return $allStaff;
            }
        } catch (\Exception $e) {
            Log::error("StaffService: Failed to fetch all staff", [
                'error' => $e->getMessage()
            ]);
        }

        // Return mock data if API is unavailable
        return $this->getMockStaff();
    }

    /**
     * Mock staff data for testing
     * بيانات وهمية للموظفين
     */
    protected function getMockStaff(): array
    {
        return [
            ['id' => 1, 'name' => 'د. أحمد محمد الطرابلسي', 'title' => 'Dr.', 'academic_rank' => 'Lecturer', 'email' => 'ahmed@university.edu'],
            ['id' => 2, 'name' => 'د. فاطمة علي السنوسي', 'title' => 'Dr.', 'academic_rank' => 'Lecturer', 'email' => 'fatima@university.edu'],
            ['id' => 3, 'name' => 'أ. خالد عبدالله المنصوري', 'title' => 'Mr.', 'academic_rank' => 'Assistant', 'email' => 'khaled@university.edu'],
            ['id' => 4, 'name' => 'د. سالم إبراهيم الغرياني', 'title' => 'Dr.', 'academic_rank' => 'Lecturer', 'email' => 'salem@university.edu'],
            ['id' => 5, 'name' => 'أ. نورية محمد الفيتوري', 'title' => 'Ms.', 'academic_rank' => 'Assistant', 'email' => 'nouria@university.edu'],
            ['id' => 6, 'name' => 'د. عمر حسن البرغثي', 'title' => 'Dr.', 'academic_rank' => 'Lecturer', 'email' => 'omar@university.edu'],
            ['id' => 7, 'name' => 'أ. مريم سعيد الزليتني', 'title' => 'Ms.', 'academic_rank' => 'Assistant', 'email' => 'mariam@university.edu'],
            ['id' => 8, 'name' => 'د. يوسف عبدالرحمن الككلي', 'title' => 'Dr.', 'academic_rank' => 'Lecturer', 'email' => 'youssef@university.edu'],
        ];
    }
}
