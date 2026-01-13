@extends('layouts.app')

@section('title', 'سجل الدرجات')

@section('content')
    {{-- مسار التنقل --}}
    <div class="breadcrumb">
        <a href="{{ url('/') }}">الرئيسية</a>
        <span class="breadcrumb-separator">←</span>
        <span>سجل الدرجات</span>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                سجل الدرجات
            </h2>
            <a href="{{ route('grades.create') }}" class="btn btn-primary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                رصد درجة جديدة
            </a>
        </div>
        <div class="card-body">
            {{-- فلاتر البحث --}}
            <form action="{{ route('grades.index') }}" method="GET" style="margin-bottom: 24px;">
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" class="form-control" name="student_id" value="{{ request('student_id') }}"
                            placeholder="اسم الطالب أو رقمه">
                    </div>
                    <div class="form-group">
                        <select class="form-select" name="course_id">
                            <option value="">جميع المواد</option>
                            @foreach($courses as $course)
                                <option value="{{ $course['id'] }}" {{ request('course_id') == $course['id'] ? 'selected' : '' }}>
                                    {{ $course['id'] }} - {{ $course['name_ar'] ?? $course['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-select" name="semester">
                            <option value="">جميع الفصول</option>
                            <option value="Fall 2024" {{ request('semester') == 'Fall 2024' ? 'selected' : '' }}>خريف 2024
                            </option>
                            <option value="Spring 2025" {{ request('semester') == 'Spring 2025' ? 'selected' : '' }}>ربيع 2025
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-secondary" style="width: 100%;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                style="width: 18px; height: 18px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            بحث
                        </button>
                    </div>
                </div>
            </form>

            {{-- عرض الجدول أو الحالة الفارغة --}}
            @if($grades->isEmpty())
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3>لا توجد درجات مسجلة</h3>
                    <p>ابدأ برصد أول درجة للطلاب</p>
                    <a href="{{ route('grades.create') }}" class="btn btn-primary" style="margin-top: 16px;">
                        رصد درجة جديدة
                    </a>
                </div>
            @else
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>الرقم</th>
                                <th>اسم الطالب</th>
                                <th>رمز المادة</th>
                                <th>الفصل الدراسي</th>
                                <th>أعمال السنة</th>
                                <th>النهائي</th>
                                <th>المجموع</th>
                                <th>التقدير</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $grade)
                                <tr>
                                    <td>{{ $grade->id }}</td>
                                    <td>
                                        <div style="font-weight: bold;">
                                            {{ $studentsMap[$grade->student_id]['full_name'] ?? 'غير معروف' }}</div>
                                        <div style="font-size: 0.85em; color: #6c757d;">#{{ $grade->student_id }}</div>
                                    </td>
                                    <td>{{ $grade->course_id }}</td>
                                    <td>{{ $grade->semester }}</td>
                                    <td>{{ $grade->coursework_score ?? '-' }}</td>
                                    <td>{{ $grade->final_score ?? '-' }}</td>
                                    <td><strong>{{ $grade->total_score }}</strong></td>
                                    <td>
                                        <span class="grade-badge grade-{{ strtolower($grade->letter_grade) }}">
                                            {{ $grade->letter_grade }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 8px;">
                                            <a href="{{ route('grades.show', $grade) }}" class="btn btn-sm btn-secondary"
                                                title="عرض">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" style="width: 16px; height: 16px;">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('grades.edit', $grade) }}" class="btn btn-sm btn-secondary"
                                                title="تعديل">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" style="width: 16px; height: 16px;">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('grades.destroy', $grade) }}" method="POST"
                                                style="display: inline;"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذه الدرجة؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" style="width: 16px; height: 16px;">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($grades->hasPages())
                    <div class="pagination">
                        {{-- Previous --}}
                        @if($grades->onFirstPage())
                            <span>« السابق</span>
                        @else
                            <a href="{{ $grades->previousPageUrl() }}">« السابق</a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach($grades->getUrlRange(1, $grades->lastPage()) as $page => $url)
                            @if($page == $grades->currentPage())
                                <span class="active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if($grades->hasMorePages())
                            <a href="{{ $grades->nextPageUrl() }}">التالي »</a>
                        @else
                            <span>التالي »</span>
                        @endif
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection