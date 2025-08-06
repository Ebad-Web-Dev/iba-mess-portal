<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Validators\Failure;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    private $failures = [];
    private $successCount = 0;

    public function model(array $row)
    {
        $this->successCount++;

        return new Student([
            'serial_no' => $this->cleanNumber($row['s_no']),
            'room_no'   => $this->cleanString($row['room_no']),
            'name'      => $this->cleanString($row['name_of_students']),
            'class'     => $this->cleanString($row['class']),
            'batch'     => $this->cleanString($row['batch']),
            'erp_id'    => $this->cleanString($row['erp_id']),
        ]);
    }

    private function cleanString($value): ?string
    {
        return is_null($value) || $value === '' ? null : trim(preg_replace('/[^\x20-\x7E]/', '', strval($value)));
    }

    private function cleanNumber($value): ?int
    {
        return is_null($value) || $value === '' ? null : intval(preg_replace('/[^0-9]/', '', strval($value)));
    }

    public function rules(): array
    {
        return [
            's_no' => 'required',
            'room_no' => 'required',
            'name_of_students' => 'required',
            'class' => 'required',
            'batch' => 'required',
            'erp_id' => 'required|unique:residents_list,erp_id',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.required' => 'The :attribute field is required in row :row',
            'erp_id.unique' => 'The ERP ID in row :row already exists',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        $this->failures = array_merge($this->failures, $failures);
    }

    public function getFailures()
    {
        return $this->failures;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }
}
