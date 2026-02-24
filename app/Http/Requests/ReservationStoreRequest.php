<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ReservationStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'message' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'message.max' => '入力文字数を減らしてください。',
            'date.required' => '希望日時を再度設定してください',
            'date.date' => '希望日時を再度設定してください',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($v) {
            $date = $this->date('date');
            if (!$date)
                return;

            $now = now();
            if ($date->lt($now) || $date->gt($now->copy()->addYear())) {
                $v->errors()->add('date', '希望日時を再度設定してください');
            }
        });
    }
}