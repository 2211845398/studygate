<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * StoreGradeRequest - طلب حفظ الدرجة
 * Validation rules for grade submission
 * 
 * @author Team 404
 */
class StoreGradeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'student_id' => ['required', 'integer', 'min:1'],
            'course_id' => ['required', 'string', 'max:20'],
            'semester' => ['required', 'string', 'max:20'],
            'coursework_score' => ['nullable', 'numeric', 'min:0', 'max:40'],
            'final_score' => ['nullable', 'numeric', 'min:0', 'max:60'],
            'graded_by' => ['nullable', 'integer', 'min:1'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'student_id.required' => 'رقم الطالب مطلوب',
            'student_id.integer' => 'رقم الطالب يجب أن يكون رقماً صحيحاً',
            'course_id.required' => 'رمز المادة مطلوب',
            'semester.required' => 'الفصل الدراسي مطلوب',
            'coursework_score.max' => 'درجة أعمال السنة لا يمكن أن تتجاوز 40',
            'coursework_score.min' => 'درجة أعمال السنة لا يمكن أن تكون سالبة',
            'final_score.max' => 'درجة الامتحان النهائي لا يمكن أن تتجاوز 60',
            'final_score.min' => 'درجة الامتحان النهائي لا يمكن أن تكون سالبة',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'student_id' => 'رقم الطالب',
            'course_id' => 'رمز المادة',
            'semester' => 'الفصل الدراسي',
            'coursework_score' => 'درجة أعمال السنة',
            'final_score' => 'درجة الامتحان النهائي',
            'graded_by' => 'المصحح',
        ];
    }
}
