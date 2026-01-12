@extends('layouts.app')

@section('title', 'رصد درجة جديدة')

@push('styles')
<style>
    /* ==================== توحيد شكل جميع الحقول ==================== */
    
    /* الحقول العادية */
    .form-control,
    .form-select {
        height: 48px !important;
        padding: 12px 16px !important;
        border: 2px solid #dce1e8 !important;
        border-radius: 8px !important;
        background: #fff !important;
        font-size: 1rem !important;
        color: #1a1a2e !important;
        transition: all 0.2s ease !important;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #1a4f7a !important;
        box-shadow: 0 0 0 3px rgba(26, 79, 122, 0.15) !important;
        outline: none !important;
    }
    
    /* Select2 Container */
    .select2-container {
        width: 100% !important;
    }
    
    .select2-container .select2-selection--single {
        height: 48px !important;
        padding: 0 16px !important;
        border: 2px solid #dce1e8 !important;
        border-radius: 8px !important;
        background: #fff !important;
        display: flex !important;
        align-items: center !important;
    }
    
    .select2-container--default .select2-selection--single:focus,
    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #1a4f7a !important;
        box-shadow: 0 0 0 3px rgba(26, 79, 122, 0.15) !important;
        outline: none !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #1a1a2e !important;
        line-height: 44px !important;
        padding-right: 0 !important;
        padding-left: 30px !important;
        font-size: 1rem !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #8892a0 !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px !important;
        left: 8px !important;
        right: auto !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__clear {
        margin-left: 0 !important;
        margin-right: 8px !important;
        font-size: 1.2rem !important;
        color: #8892a0 !important;
    }
    
    /* Select2 Dropdown */
    .select2-dropdown {
        border: 2px solid #1a4f7a !important;
        border-radius: 8px !important;
        box-shadow: 0 8px 24px rgba(0,0,0,0.12) !important;
        margin-top: 4px !important;
    }
    
    .select2-container--default .select2-results__option {
        padding: 12px 16px !important;
        font-size: 1rem !important;
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background: #1a4f7a !important;
        color: #fff !important;
    }
    
    .select2-container--default .select2-search--dropdown .select2-search__field {
        padding: 12px 16px !important;
        border: 2px solid #dce1e8 !important;
        border-radius: 8px !important;
        font-size: 1rem !important;
    }
    
    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        border-color: #1a4f7a !important;
        outline: none !important;
    }
    
    /* Student/Staff Option في القائمة */
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
        background: #c9a227;
        color: #0d3454;
        padding: 3px 12px;
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
        <span>رصد درجة جديدة</span>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                رصد درجة جديدة
            </h2>
        </div>
        <div class="card-body">
            <form action="{{ route('grades.store') }}" method="POST">
                @csrf

                {{-- بيانات الطالب والمادة --}}
                <div class="form-row">
                    {{-- اختيار الطالب --}}
                    <div class="form-group">
                        <label class="form-label">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            الطالب <span class="required">*</span>
                        </label>
                        <select class="form-select @error('student_id') is-invalid @enderror" 
                                id="student_id" 
                                name="student_id" 
                                required>
                            <option value="">ابحث عن الطالب بالاسم أو الرقم...</option>
                            @foreach ($students as $student)
                                <option value="{{ $student['id'] }}"
                                    data-name="{{ $student['full_name'] }}"
                                    {{ old('student_id') == $student['id'] ? 'selected' : '' }}>
                                    {{ $student['full_name'] }} (#{{ $student['id'] }})
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <span class="form-hint">اكتب اسم الطالب للبحث السريع</span>
                    </div>

                    {{-- اختيار المادة --}}
                    <div class="form-group">
                        <label class="form-label">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            المادة الدراسية <span class="required">*</span>
                        </label>
                        <select class="form-select @error('course_id') is-invalid @enderror" 
                                id="course_id" 
                                name="course_id" 
                                required>
                            <option value="">اختر المادة</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course['id'] }}" {{ old('course_id') == $course['id'] ? 'selected' : '' }}>
                                    {{ $course['id'] }} - {{ $course['name_ar'] ?? $course['name'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    {{-- الفصل الدراسي --}}
                    <div class="form-group">
                        <label class="form-label">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            الفصل الدراسي <span class="required">*</span>
                        </label>
                        <select class="form-select @error('semester') is-invalid @enderror" 
                                id="semester" 
                                name="semester" 
                                required>
                            <option value="">اختر الفصل الدراسي</option>
                            <option value="Fall 2024" {{ old('semester') == 'Fall 2024' ? 'selected' : '' }}>الفصل الأول (خريف) 2024</option>
                            <option value="Spring 2025" {{ old('semester') == 'Spring 2025' ? 'selected' : '' }}>الفصل الثاني (ربيع) 2025</option>
                            <option value="Summer 2025" {{ old('semester') == 'Summer 2025' ? 'selected' : '' }}>الفصل الصيفي 2025</option>
                        </select>
                        @error('semester')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- المصحح --}}
                    <div class="form-group">
                        <label class="form-label">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                            المصحح / المحاضر
                        </label>
                        <select class="form-select @error('graded_by') is-invalid @enderror" 
                                id="graded_by" 
                                name="graded_by">
                            <option value="">ابحث عن المصحح بالاسم...</option>
                            @foreach ($staff as $member)
                                <option value="{{ $member['id'] }}"
                                    data-name="{{ $member['name'] }}"
                                    data-rank="{{ $member['academic_rank'] ?? '' }}"
                                    {{ old('graded_by') == $member['id'] ? 'selected' : '' }}>
                                    {{ $member['name'] }} (#{{ $member['id'] }})
                                </option>
                            @endforeach
                        </select>
                        @error('graded_by')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <span class="form-hint">اختياري - اختر اسم المحاضر المصحح</span>
                    </div>
                </div>

                {{-- قسم الدرجات --}}
                <div style="margin: 30px 0 20px; padding-bottom: 10px; border-bottom: 2px solid var(--border-color);">
                    <h3 style="font-size: 1rem; color: var(--primary); display: flex; align-items: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        الدرجات المرصودة
                    </h3>
                </div>

                <div class="form-row">
                    {{-- درجة أعمال السنة --}}
                    <div class="form-group">
                        <label class="form-label">درجة أعمال السنة (من 40)</label>
                        <input type="number" 
                               class="form-control @error('coursework_score') is-invalid @enderror" 
                               id="coursework_score" 
                               name="coursework_score" 
                               value="{{ old('coursework_score') }}" 
                               placeholder="أدخل الدرجة"
                               min="0" 
                               max="40" 
                               step="0.5">
                        @error('coursework_score')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- درجة الامتحان النهائي --}}
                    <div class="form-group">
                        <label class="form-label">درجة الامتحان النهائي (من 60)</label>
                        <input type="number" 
                               class="form-control @error('final_score') is-invalid @enderror" 
                               id="final_score" 
                               name="final_score" 
                               value="{{ old('final_score') }}" 
                               placeholder="أدخل الدرجة"
                               min="0" 
                               max="60" 
                               step="0.5">
                        @error('final_score')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- معاينة المجموع --}}
                <div class="score-preview" style="margin: 24px 0;">
                    <div class="info-box-label">المجموع الكلي</div>
                    <div class="info-box-value" id="totalPreview">0 / 100</div>
                </div>

                {{-- أزرار الإجراء --}}
                <div class="btn-group" style="margin-top: 24px;">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        حفظ الدرجة
                    </button>
                    <a href="{{ route('grades.index') }}" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
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
    // تهيئة Select2 لاختيار الطالب
    $('#student_id').select2({
        dir: 'rtl',
        placeholder: 'ابحث عن الطالب بالاسم أو الرقم...',
        allowClear: true,
        language: {
            noResults: function() { return 'لا توجد نتائج'; },
            searching: function() { return 'جاري البحث...'; }
        },
        templateResult: formatStudent,
        templateSelection: formatStudentSelection
    });

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

    function formatStudent(student) {
        if (!student.id) return student.text;
        var name = $(student.element).data('name') || student.text;
        return $('<div class="student-option"><span class="student-name">' + name + '</span><span class="student-id">' + student.id + '</span></div>');
    }

    function formatStudentSelection(student) {
        if (!student.id) return student.text;
        var name = $(student.element).data('name') || student.text;
        return name + ' (#' + student.id + ')';
    }

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

// حساب المجموع
function updateTotal() {
    const coursework = parseFloat(document.getElementById('coursework_score').value) || 0;
    const final = parseFloat(document.getElementById('final_score').value) || 0;
    const total = coursework + final;
    document.getElementById('totalPreview').textContent = total.toFixed(1) + ' / 100';
}

document.getElementById('coursework_score').addEventListener('input', updateTotal);
document.getElementById('final_score').addEventListener('input', updateTotal);
updateTotal();

// ==================== تحميل الدرجات السابقة تلقائياً ====================
let existingGradeId = null;

function checkExistingGrade() {
    const studentId = $('#student_id').val();
    const courseId = $('#course_id').val();
    const semester = $('#semester').val();
    
    // تأكد من ملء كل الحقول
    if (!studentId || !courseId || !semester) {
        hideExistingGradeAlert();
        return;
    }
    
    // إرسال طلب AJAX
    $.ajax({
        url: '/grades/check-existing',
        method: 'GET',
        data: {
            student_id: studentId,
            course_id: courseId,
            semester: semester
        },
        success: function(response) {
            if (response.exists && response.grade) {
                // عرض رسالة التنبيه
                showExistingGradeAlert(response.message);
                
                // تعبئة الحقول بالبيانات الموجودة
                existingGradeId = response.grade.id;
                $('#coursework_score').val(response.grade.coursework_score || '');
                $('#final_score').val(response.grade.final_score || '');
                if (response.grade.graded_by) {
                    $('#graded_by').val(response.grade.graded_by).trigger('change');
                }
                $('#notes').val(response.grade.notes || '');
                
                // تحديث المجموع
                updateTotal();
                
                // تغيير زر الحفظ للتعديل
                $('button[type="submit"]').html('<i class="bi bi-pencil-square ms-2"></i> تحديث الدرجة');
                
                // تغيير action الفورم للتعديل
                $('form').attr('action', '/grades/' + existingGradeId);
                if (!$('form input[name="_method"]').length) {
                    $('form').prepend('<input type="hidden" name="_method" value="PUT">');
                }
            } else {
                hideExistingGradeAlert();
                existingGradeId = null;
                
                // إعادة الفورم للحالة العادية
                $('button[type="submit"]').html('<i class="bi bi-check-circle ms-2"></i> حفظ الدرجة');
                $('form').attr('action', '/grades');
                $('form input[name="_method"]').remove();
            }
        }
    });
}

function showExistingGradeAlert(message) {
    let alertEl = $('#existing-grade-alert');
    if (!alertEl.length) {
        alertEl = $('<div id="existing-grade-alert" class="alert alert-info alert-dismissible fade show" role="alert" style="background: #d1ecf1; border: 2px solid #1a4f7a; border-radius: 12px; margin-bottom: 20px;">' +
            '<i class="bi bi-info-circle me-2"></i>' +
            '<strong>تنبيه:</strong> <span class="alert-message"></span>' +
            '</div>');
        $('.page-header').after(alertEl);
    }
    alertEl.find('.alert-message').text(message);
    alertEl.show();
}

function hideExistingGradeAlert() {
    $('#existing-grade-alert').hide();
}

// ربط الأحداث
$('#student_id').on('change', checkExistingGrade);
$('#course_id').on('change', checkExistingGrade);
$('#semester').on('change', checkExistingGrade);
</script>
@endpush