@extends('layouts.app')

@section('title', 'تفاصيل الدرجة')

@section('content')
    {{-- مسار التنقل --}}
    <div class="breadcrumb">
        <a href="{{ route('grades.index') }}">سجل الدرجات</a>
        <span class="breadcrumb-separator">←</span>
        <span>تفاصيل الدرجة #{{ $grade->id }}</span>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                تفاصيل الدرجة
            </h2>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('grades.edit', $grade) }}" class="btn btn-sm btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    تعديل
                </a>
                <a href="{{ route('grades.index') }}" class="btn btn-sm btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    رجوع
                </a>
            </div>
        </div>
        <div class="card-body">
            {{-- معلومات الطالب والمادة --}}
            <div class="form-row">
                <div style="background: var(--bg-light); padding: 20px; border-radius: var(--border-radius); border-right: 4px solid var(--primary);">
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">رقم الطالب</div>
                    <div style="font-size: 1.3rem; font-weight: 700; color: var(--primary);">{{ $grade->student_id }}</div>
                    @if($student)
                        <div style="color: var(--text-secondary); margin-top: 4px;">{{ $student['full_name'] ?? '' }}</div>
                    @endif
                </div>

                <div style="background: var(--bg-light); padding: 20px; border-radius: var(--border-radius); border-right: 4px solid var(--secondary);">
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">المادة الدراسية</div>
                    <div style="font-size: 1.3rem; font-weight: 700; color: var(--primary);">{{ $grade->course_id }}</div>
                    @if($course)
                        <div style="color: var(--text-secondary); margin-top: 4px;">{{ $course['name_ar'] ?? $course['name'] ?? '' }}</div>
                    @endif
                </div>
            </div>

            <div class="form-row" style="margin-top: 20px;">
                <div style="background: var(--bg-light); padding: 20px; border-radius: var(--border-radius);">
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">الفصل الدراسي</div>
                    <div style="font-size: 1.1rem; font-weight: 600;">{{ $grade->semester }}</div>
                </div>

                <div style="background: var(--bg-light); padding: 20px; border-radius: var(--border-radius);">
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">المصحح</div>
                    <div style="font-size: 1.1rem; font-weight: 600;">
                        @if($staff)
                            {{ $staff['name'] }}
                        @elseif($grade->graded_by)
                            موظف رقم #{{ $grade->graded_by }}
                        @else
                            <span style="color: var(--text-muted);">غير محدد</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- قسم الدرجات --}}
            <div style="margin: 30px 0 20px; padding-bottom: 10px; border-bottom: 2px solid var(--border-color);">
                <h3 style="font-size: 1rem; color: var(--primary); display: flex; align-items: center; gap: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    تفصيل الدرجات
                </h3>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                <div class="info-box">
                    <div class="info-box-label">أعمال السنة</div>
                    <div class="info-box-value">{{ $grade->coursework_score ?? 0 }}</div>
                    <div style="font-size: 0.85rem; opacity: 0.8;">من 40</div>
                </div>
                
                <div class="info-box">
                    <div class="info-box-label">الامتحان النهائي</div>
                    <div class="info-box-value">{{ $grade->final_score ?? 0 }}</div>
                    <div style="font-size: 0.85rem; opacity: 0.8;">من 60</div>
                </div>
                
                <div class="score-preview">
                    <div class="info-box-label">المجموع الكلي</div>
                    <div class="info-box-value">{{ $grade->total_score }}</div>
                    <div style="font-size: 0.85rem;">من 100</div>
                </div>
            </div>

            {{-- التقدير --}}
            <div style="text-align: center; margin-top: 30px; padding: 30px; background: var(--bg-light); border-radius: var(--border-radius);">
                <div style="margin-bottom: 12px; color: var(--text-muted);">التقدير النهائي</div>
                <span class="grade-badge grade-{{ strtolower($grade->letter_grade) }}" style="font-size: 2.5rem; padding: 16px 48px;">
                    {{ $grade->letter_grade }}
                </span>
                <div style="margin-top: 12px; font-size: 1.1rem; color: var(--text-secondary);">
                    @switch($grade->letter_grade)
                        @case('A') ممتاز @break
                        @case('B') جيد جداً @break
                        @case('C') جيد @break
                        @case('D') مقبول @break
                        @case('F') راسب @break
                    @endswitch
                </div>
            </div>

            {{-- معلومات التسجيل --}}
            <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--border-color); color: var(--text-muted); font-size: 0.85rem; display: flex; gap: 24px;">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px; vertical-align: middle; margin-left: 4px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    تاريخ الإنشاء: {{ $grade->created_at->format('Y-m-d H:i') }}
                </span>
                @if($grade->updated_at->ne($grade->created_at))
                    <span>
                        آخر تعديل: {{ $grade->updated_at->format('Y-m-d H:i') }}
                    </span>
                @endif
            </div>
        </div>
    </div>
@endsection
