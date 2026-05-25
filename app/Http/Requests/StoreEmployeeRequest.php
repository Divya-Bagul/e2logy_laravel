<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\EmployeeValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    use EmployeeValidationRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->employeeRules();
    }

    public function messages(): array
    {
        return $this->employeeMessages();
    }
}
