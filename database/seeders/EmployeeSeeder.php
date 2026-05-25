<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::pluck('id', 'name');
        $managers = Manager::pluck('id', 'name');

        $employees = [
            ['full_name' => 'John Smith', 'employee_code' => 'E001', 'department' => 'Sales', 'manager' => 'Michael Lee', 'joining_date' => '2020-02-15', 'email' => 'john.smith@example.com', 'phone' => '5550101001', 'address' => '123 Main St'],
            ['full_name' => 'Emma Johnson', 'employee_code' => 'E002', 'department' => 'HR', 'manager' => 'Sarah Miller', 'joining_date' => '2019-06-20', 'email' => 'emma.johnson@example.com', 'phone' => '5550101002', 'address' => '456 Oak Ave'],
            ['full_name' => 'Michael Brown', 'employee_code' => 'E003', 'department' => 'IT', 'manager' => 'David Chen', 'joining_date' => '2021-03-10', 'email' => 'michael.brown@example.com', 'phone' => '5550101003', 'address' => '789 Pine Rd'],
            ['full_name' => 'Olivia Davis', 'employee_code' => 'E004', 'department' => 'Marketing', 'manager' => 'Lisa Anderson', 'joining_date' => '2018-11-05', 'email' => 'olivia.davis@example.com', 'phone' => '5550101004', 'address' => '321 Elm St'],
            ['full_name' => 'William Wilson', 'employee_code' => 'E005', 'department' => 'Finance', 'manager' => 'Michael Lee', 'joining_date' => '2022-01-18', 'email' => 'william.wilson@example.com', 'phone' => '5550101005', 'address' => '654 Maple Dr'],
            ['full_name' => 'Sophia Martin', 'employee_code' => 'E006', 'department' => 'Operations', 'manager' => 'Sarah Miller', 'joining_date' => '2020-08-22', 'email' => 'sophia.martin@example.com', 'phone' => '5550101006', 'address' => '987 Cedar Ln'],
            ['full_name' => 'James Anderson', 'employee_code' => 'E007', 'department' => 'Sales', 'manager' => 'Michael Lee', 'joining_date' => '2019-04-12', 'email' => 'james.anderson@example.com', 'phone' => '5550101007', 'address' => '147 Birch Way'],
            ['full_name' => 'Isabella Taylor', 'employee_code' => 'E008', 'department' => 'HR', 'manager' => 'Sarah Miller', 'joining_date' => '2021-07-30', 'email' => 'isabella.taylor@example.com', 'phone' => '5550101008', 'address' => '258 Willow Ct'],
            ['full_name' => 'Benjamin Thomas', 'employee_code' => 'E009', 'department' => 'IT', 'manager' => 'David Chen', 'joining_date' => '2017-12-01', 'email' => 'benjamin.thomas@example.com', 'phone' => '5550101009', 'address' => '369 Spruce Blvd'],
            ['full_name' => 'Mia Jackson', 'employee_code' => 'E010', 'department' => 'Marketing', 'manager' => 'Lisa Anderson', 'joining_date' => '2023-05-14', 'email' => 'mia.jackson@example.com', 'phone' => '5550101010', 'address' => '741 Ash Pl'],
        ];

        foreach ($employees as $employee) {
            Employee::create([
                'full_name' => $employee['full_name'],
                'employee_code' => $employee['employee_code'],
                'department_id' => $departments[$employee['department']],
                'manager_id' => $managers[$employee['manager']],
                'joining_date' => $employee['joining_date'],
                'email' => $employee['email'],
                'phone' => $employee['phone'],
                'address' => $employee['address'],
            ]);
        }
    }
}
