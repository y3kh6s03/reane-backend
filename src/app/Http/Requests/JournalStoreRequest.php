<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JournalStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'reach_id' => 'required|numeric',
            'skill_id' => 'required|numeric',
            'data.actionNames' => 'required|array',
            'data.actionNames.*.select' => 'required|string',
            'data.description' => 'required|string|max:501',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => '必須項目が送信されていません。',
            'numeric' => '送信されたデータが適合していません',
            'data.actionNames.*.select.required' => 'actionNamesのselectフィールドは必須です。',
            'description.max' => '文字数オーバーです。500文字までで入力してください。'
        ];
    }
}
