<?php

namespace App\Http\Requests;

class SmsRequest extends BaseRequestApi
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'send_date' => 'required|date|after:' . \Carbon\Carbon::now()->format('Y-m-d H:i:s') . '|date_format:d.m.Y H:i',
            'numbers' => 'required|array|min:1',
            'numbers.*.number' => 'required|numeric',
            'numbers.*.message' => 'required|string',
        ];
    }


    public function attributes(): array
    {
        return [
            'send_date' => 'Gönderim Tarihi (send_date)',
            'numbers' => 'Numaralar (numbers)',
            'numbers.*.number' => 'Numara (numbers.*.number)',
            'numbers.*.message' => 'Mesaj (numbers.*.message)',
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->getValidatorInstance()->fails()) {

            $arr = [];
            foreach ($this->numbers as $key => $number) {
                $arr[$key]['number'] = $number['number'];
                $arr[$key]['message'] = $number['message'];
            }

            $this->merge([
                'send_date' => \Carbon\Carbon::createFromFormat('d.m.Y H:i', $this->send_date)->format('Y-m-d H:i:s'),
                'numbers' => $arr,
            ]);
        }
    }


}
