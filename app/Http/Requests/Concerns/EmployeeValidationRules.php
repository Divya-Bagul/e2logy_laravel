<?php

namespace App\Http\Requests\Concerns;

use App\Models\Employee;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

trait EmployeeValidationRules
{
    protected function prepareForValidation(): void
    {
        $merged = [];

        if ($this->has('employee_code')) {
            $merged['employee_code'] = trim((string) $this->employee_code);
        }

        if ($this->has('email')) {
            $merged['email'] = trim((string) $this->email);
        }

        if ($this->has('phone')) {
            $merged['phone'] = trim((string) $this->phone);
        }

        if ($merged !== []) {
            $this->merge($merged);
        }
    }

    protected function employeeRules(Employee|int|null $ignoreEmployee = null): array
    {
        return [
            'full_name' => ['required', 'string', 'min:2', 'max:15'],
            'employee_code' => [
                'required',
                'string',
                'min:1',
                'max:6',
                'regex:/^[A-Za-z0-9]+$/',
                $this->uniqueAmongActiveEmployees('employee_code', $ignoreEmployee),
            ],
            'department_id' => ['required', 'exists:departments,id'],
            'manager_id' => ['required', 'exists:managers,id'],
            'joining_date' => ['required', 'date'],
            'email' => [
                'required',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'max:255',
                $this->uniqueAmongActiveEmployees('email', $ignoreEmployee),
            ],
            'phone' => [
                'required',
                'regex:/^\d{10}$/',
                $this->uniqueAmongActiveEmployees('phone', $ignoreEmployee),
            ],
            'address' => ['required', 'string', 'max:500'],
        ];
    }

    protected function uniqueAmongActiveEmployees(string $column, Employee|int|null $ignoreEmployee = null): Unique
    {
        $rule = Rule::unique('employees', $column)->withoutTrashed();

        if ($ignoreEmployee !== null) {
            $rule->ignore($ignoreEmployee);
        }

        return $rule;
    }

    protected function employeeMessages(): array
    {
        return [
            'full_name.required' => 'Full name is required.',
            'full_name.min' => 'Full name must be at least 2 characters.',
            'full_name.max' => 'Full name must not exceed 15 characters.',
            'employee_code.required' => 'Employee code is required.',
            'employee_code.min' => 'Employee code must be at least 1 character.',
            'employee_code.max' => 'Employee code must not exceed 6 characters.',
            'employee_code.regex' => 'Employee code may only contain letters and numbers.',
            'employee_code.unique' => 'This employee code is already used by another active employee.',
            'joining_date.required' => 'Joining date is required.',
            'joining_date.date' => 'Joining date must be a valid date.',
            'email.required' => 'Email address is required.',
            'email.regex' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already used by another active employee.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number must be exactly 10 digits (numbers only).',
            'phone.unique' => 'This phone number is already used by another active employee.',
            'address.required' => 'Address is required.',
            'address.max' => 'Address must not exceed 500 characters.',
        ];
    }
}
