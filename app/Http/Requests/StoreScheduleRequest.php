<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:50'],
            'description' => ['nullable', 'max:200'],
            'deadline' => ['required', 'date'],
            'status' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'title' => '予定タイトル',
            'description' => '予定詳細',
            'deadline' => '期限日',
            'status' => '重要度'
        ];
    }
}
