<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Services\StudentService;
use App\Services\StaffService;
use App\Services\CourseService;
use App\Http\Requests\StoreGradeRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * GradeController - متحكم الدرجات
 * Handles grade CRUD operations
 * 
 * @author Team 404
 */
class GradeController extends Controller
{
    public function __construct(
        protected StudentService $studentService,
        protected StaffService $staffService,
        protected CourseService $courseService
    ) {
    }

    /**
     * Display a listing of grades
     * عرض قائمة الدرجات
     */
    public function index(Request $request): View
    {
        $query = Grade::query();

        // Fetch all students first (needed for search and display)
        $allStudents = $this->studentService->fetchAllStudents();
        $studentsMap = collect($allStudents)->keyBy('id');

        // Filter by student (ID or Name)
        if ($request->filled('student_id')) {
            $search = $request->student_id;

            // If numeric, assume ID
            if (is_numeric($search)) {
                $query->where('student_id', $search);
            }
            // If text, search by name in fetched students list
            else {
                $matchingStudentIds = collect($allStudents)
                    ->filter(function ($student) use ($search) {
                        return stripos($student['full_name'] ?? '', $search) !== false;
                    })
                    ->pluck('id')
                    ->toArray();

                // If no name matches, ensure no results (empty array)
                if (empty($matchingStudentIds)) {
                    // Force empty result efficiently
                    $query->where('student_id', -1);
                } else {
                    $query->whereIn('student_id', $matchingStudentIds);
                }
            }
        }

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Filter by semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $grades = $query->orderBy('created_at', 'desc')->paginate(15);
        $courses = $this->courseService->getAllCourses();

        return view('grades.index', compact('grades', 'courses', 'studentsMap'));
    }

    /**
     * Show the form for creating a new grade
     * عرض نموذج إضافة درجة
     */
    public function create(): View
    {
        $courses = $this->courseService->getAllCourses();
        $students = $this->studentService->getAllStudents();
        $staff = $this->staffService->getAllStaffForDropdown();
        return view('grades.create', compact('courses', 'students', 'staff'));
    }

    /**
     * Store a newly created grade
     * حفظ درجة جديدة
     */
    public function store(StoreGradeRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // 1. Verify student enrollment (مؤقتاً معطل - API وهمي)
        // NOTE: تم تعطيل هذا التحقق مؤقتاً لأن API الطلاب وهمي
        // فعّل هذا الكود عند ربط API حقيقي
        /*
        $isEnrolled = $this->studentService->isEnrolledInCourse(
            $validated['student_id'],
            $validated['course_id'],
            $validated['semester']
        );

        if (!$isEnrolled) {
            return back()
                ->withInput()
                ->withErrors(['student_id' => 'الطالب غير مسجل في هذه المادة لهذا الفصل']);
        }
        */

        // 2. Verify course exists (mock check)
        if (!$this->courseService->courseExists($validated['course_id'])) {
            return back()
                ->withInput()
                ->withErrors(['course_id' => 'المادة غير موجودة في النظام']);
        }

        // 3. Verify graded_by staff exists (مؤقتاً معطل - API وهمي)
        /*
        if (!empty($validated['graded_by'])) {
            if (!$this->staffService->staffExists($validated['graded_by'])) {
                return back()
                    ->withInput()
                    ->withErrors(['graded_by' => 'المصحح غير موجود في نظام الموظفين']);
            }
        }
        */

        // 4. Check for duplicate grade
        $existingGrade = Grade::where('student_id', $validated['student_id'])
            ->where('course_id', $validated['course_id'])
            ->where('semester', $validated['semester'])
            ->first();

        if ($existingGrade) {
            return back()
                ->withInput()
                ->withErrors(['student_id' => 'توجد درجة مسجلة مسبقاً لهذا الطالب في هذه المادة لهذا الفصل']);
        }

        // 5. Create the grade
        $grade = Grade::create($validated);

        return redirect()
            ->route('grades.show', $grade)
            ->with('success', 'تم حفظ الدرجة بنجاح');
    }

    /**
     * Display the specified grade
     * عرض درجة محددة
     */
    public function show(Grade $grade): View
    {
        // Get course details from mock service
        $course = $this->courseService->getCourse($grade->course_id);

        // Get student details (if API available)
        $student = $this->studentService->getStudent($grade->student_id);

        // Get staff details (if graded_by is set)
        $staff = $grade->graded_by
            ? $this->staffService->getStaffById($grade->graded_by)
            : null;

        return view('grades.show', compact('grade', 'course', 'student', 'staff'));
    }

    /**
     * Show the form for editing the specified grade
     * عرض نموذج تعديل الدرجة
     */
    public function edit(Grade $grade): View
    {
        $courses = $this->courseService->getAllCourses();
        $staff = $this->staffService->getAllStaffForDropdown();
        return view('grades.edit', compact('grade', 'courses', 'staff'));
    }

    /**
     * Update the specified grade
     * تحديث الدرجة
     */
    public function update(StoreGradeRequest $request, Grade $grade): RedirectResponse
    {
        $validated = $request->validated();

        // Verify graded_by staff exists (if provided)
        if (!empty($validated['graded_by'])) {
            if (!$this->staffService->staffExists($validated['graded_by'])) {
                return back()
                    ->withInput()
                    ->withErrors(['graded_by' => 'المصحح غير موجود في نظام الموظفين']);
            }
        }

        $grade->update($validated);

        return redirect()
            ->route('grades.show', $grade)
            ->with('success', 'تم تحديث الدرجة بنجاح');
    }

    /**
     * Remove the specified grade
     * حذف الدرجة
     */
    public function destroy(Grade $grade): RedirectResponse
    {
        $grade->delete();

        return redirect()
            ->route('grades.index')
            ->with('success', 'تم حذف الدرجة بنجاح');
    }

    /**
     * Check if grade exists for student/course/semester (AJAX)
     * التحقق من وجود درجة مسجلة سابقاً
     * 
     * GET /grades/check-existing?student_id=1&course_id=CS101&semester=Fall 2024
     */
    public function checkExisting(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer',
            'course_id' => 'required|string',
            'semester' => 'required|string',
        ]);

        $grade = Grade::where('student_id', $request->student_id)
            ->where('course_id', $request->course_id)
            ->where('semester', $request->semester)
            ->first();

        if ($grade) {
            return response()->json([
                'exists' => true,
                'grade' => [
                    'id' => $grade->id,
                    'coursework_score' => $grade->coursework_score,
                    'final_score' => $grade->final_score,
                    'graded_by' => $grade->graded_by,
                    'notes' => $grade->notes,
                ],
                'message' => 'توجد درجة مسجلة سابقاً - سيتم تحميلها للتعديل'
            ]);
        }

        return response()->json([
            'exists' => false,
            'grade' => null,
            'message' => null
        ]);
    }
}
