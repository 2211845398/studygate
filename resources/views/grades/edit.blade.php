@extends('layouts.app')

@section('title', 'تعديل الدرجة')

@push('styles')
<style>
    .select2-container {
        width: 100% !important;
    }
    
    .select2-container .select2-selection--single {
        height: 48px;
        padding: 10px 16px;
        border: 2px solid var(--border-color);
        border-radius: var(--border-radius);
        display: flex;
        align-items: center;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: var(--text-primary);
        line-height: 26px;
        padding-right: 0;
    }
    
    .student-option {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 4px 0;
    }
    
    .student-option .student-name {
        font-weight: 500;
    }
    
    .student-option .student-id {
        background: var(--secondary);
        color: var(--primary-dark);
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 700;
    }
</style>
@endpush

@section('content')
    {{-- مسار التنقل --}}
    <div class="breadcrumb">
        <a href="{{ route('grades.index') }}">سجل الدرجات</a>
        <span class="breadcrumb-separator">←</span>
        <a href="{{ route('grades.show', $grade) }}">الدرجة #{{ $grade->id }}</a>
        <span class="breadcrumb-separator">←</span>
        <span>تعديل</span>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                تعديل الدرجة #{{ $grade->id }}
            </h2>
        </div>
        <div class="card-body">
            <form action="{{ route('grades.update', $grade) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- معلومات ثابتة --}}
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">رقم الطالب</label>
                        <input type="text" class="form-control" value="{{ $grade->student_id }}" disabled
                            style="background: var(--bg-light);">
                        <input type="hidden" name="student_id" value="{{ $grade->student_id }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">رمز المادة</label>
                        <input type="text" class="form-control" value="{{ $grade->course_id }}" disabled
                            style="background: var(--bg-light);">
                        <input type="hidden" name="course_id" value="{{ $grade->course_id }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">الفصل الدراسي</label>
                        <input type="text" class="form-control" value="{{ $grade->semester }}" disabled
                            style="background: var(--bg-light);">
                        <input type="hidden" name="semester" value="{{ $grade->semester }}">
                    </div>

                    {{-- المصحح --}}
                    <div class="form-group">
                        <label class="form-label">المصحح / المحاضر</label>
                        <select class="form-select @error('graded_by') is-invalid @enderror" 
                                id="graded_by" 
                                name="graded_by">
                            <option value="">ابحث عن المصحح بالاسم...</option>
                            @foreach ($staff as $member)
                                <option value="{{ $member['id'] }}"
                                    data-name="{{ $member['name'] }}"
                                    data-rank="{{ $member['academic_rank'] ?? '' }}"
                                    {{ old('graded_by', $grade->graded_by) == $member['id'] ? 'selected' : '' }}>
                                    {{ $member['name'] }} (#{{ $member['id'] }})
                                </option>
                            @endforeach
                        </select>
                        @error('graded_by')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- قسم الدرجات --}}
                <div style="margin: 30px 0 20px; padding-bottom: 10px; border-bottom: 2px solid var(--border-color);">
                    <h3 style="font-size: 1rem; color: var(--primary); display: flex; align-items: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        تعديل الدرجات
                    </h3>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">درجة أعمال السنة (من 40)</label>
                        <input type="number" class="form-control @error('coursework_score') is-invalid @enderror"
                            id="coursework_score" name="coursework_score"
                            value="{{ old('coursework_score', $grade->coursework_score) }}" placeholder="أدخل الدرجة"
                            min="0" max="40" step="0.5">
                        @error('coursework_score')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">درجة الامتحان النهائي (من 60)</label>
                        <input type="number" class="form-control @error('final_score') is-invalid @enderror"
                            id="final_score" name="final_score" value="{{ old('final_score', $grade->final_score) }}"
                            placeholder="أدخل الدرجة" min="0" max="60" step="0.5">
                        @error('final_score')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- معاينة المجموع --}}
                <div class="score-preview" style="margin: 24px 0;">
                    <div class="info-box-label">المجموع الكلي</div>
                    <div class="info-box-value" id="totalPreview">{{ $grade->total_score }} / 100</div>
                </div>

                {{-- أزرار الإجراء --}}
                <div class="btn-group" style="margin-top: 24px;">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        حفظ التعديلات
                    </button>
                    <a href="{{ route('grades.show', $grade) }}" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
{{-- jQuery --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
{{-- Select2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // تهيئة Select2 لاختيار المصحح
    $('#graded_by').select2({
        dir: 'rtl',
        placeholder: 'ابحث عن المصحح بالاسم...',
        allowClear: true,
        language: {
            noResults: function() { return 'لا توجد نتائج'; },
            searching: function() { return 'جاري البحث...'; }
        },
        templateResult: formatStaff,
        templateSelection: formatStaffSelection
    });

    function formatStaff(staff) {
        if (!staff.id) return staff.text;
        var name = $(staff.element).data('name') || staff.text;
        var rank = $(staff.element).data('rank') || '';
        var rankLabel = rank === 'Lecturer' ? 'محاضر' : (rank === 'Assistant' ? 'معيد' : '');
        return $('<div class="student-option"><span class="student-name">' + name + '</span><span class="student-id">' + (rankLabel || '#' + staff.id) + '</span></div>');
    }

    function formatStaffSelection(staff) {
        if (!staff.id) return staff.text;
        var name = $(staff.element).data('name') || staff.text;
        return name + ' (#' + staff.id + ')';
    }
});

function updateTotal() {
    const coursework = parseFloat(document.getElementById('coursework_score').value) || 0;
    const final = parseFloat(document.getElementById('final_score').value) || 0;
    const total = coursework + final;
    document.getElementById('totalPreview').textContent = total.toFixed(1) + ' / 100';
}

document.getElementById('coursework_score').addEventListener('input', updateTotal);
document.getElementById('final_score').addEventListener('input', updateTotal);
</script>
@endpush