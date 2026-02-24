<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkillIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'keyword' => ['nullable', 'string', 'max:300'],
        ];
    }

    public function messages(): array
    {
        return [
            'keyword.max' => '文字数上限を超えました、入力文字数を減らしてください。',
        ];
    }
}