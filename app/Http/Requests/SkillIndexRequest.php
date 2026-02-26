<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\SkillCategory;

class SkillIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'keyword' => ['nullable', 'string', 'max:300'],
            'category' => ['nullable', new Enum(SkillCategory::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'keyword.max' => '文字数上限を超えました、入力文字数を減らしてください。',
        ];
    }
}