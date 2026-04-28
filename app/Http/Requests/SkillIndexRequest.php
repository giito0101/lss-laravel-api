<?php

namespace App\Http\Requests;

use App\Enums\SkillCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SkillIndexRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'q' => $this->normalizeString($this->input('q')),
            'category' => $this->normalizeString($this->input('category')),
            'area' => $this->normalizeString($this->input('area')),
        ]);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'min:1', 'max:300'],
            'category' => ['nullable', new Enum(SkillCategory::class)],
            'area' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'q.max' => '文字数上限を超えました、入力文字数を減らしてください。',
            'area.max' => 'エリア名が長すぎます。',
        ];
    }

    private function normalizeString(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $trimmed = trim($value);

        return $trimmed === '' ? null : $trimmed;
    }
}
