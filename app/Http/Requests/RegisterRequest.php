<?php

namespace App\Http\Requests;


class RegisterRequest extends BaseRequestApi
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|numeric|exists:customers,id',
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',
            'password_confirmation' => 'required|same:password',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'customer_id' => 'Müşteri Id (customer_id))',
            'name' => 'İsim (name)',
            'email' => 'E-Posta (email)',
            'password' => 'Şifre (password)',
            'password_confirmation' => 'Şifre Tekrarı (password_confirmation)',
        ];
    }


    protected function prepareForValidation(): void
    {
        if (!$this->getValidatorInstance()->fails()) {
            $this->merge([
                'password' => bcrypt($this->password),
            ]);
        }
    }

}
