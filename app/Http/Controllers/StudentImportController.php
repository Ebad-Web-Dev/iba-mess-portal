<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;

class StudentImportController extends Controller
{
    public function showImportForm()
    {
        return view('admin.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ]);

        $import = new StudentsImport();

        try {
            Excel::import($import, $request->file('file'));

            $failures = $import->getFailures();
            $successCount = $import->getSuccessCount();

            if (count($failures) > 0) {
                $errors = [];
                foreach ($failures as $failure) {
                    $errors[] = sprintf(
                        "Row %d: %s (Column: %s, Value: '%s')",
                        $failure->row(),
                        implode(', ', $failure->errors()),
                        $failure->attribute(),
                        $failure->values()[$failure->attribute()] ?? 'empty'
                    );
                }

                return back()
                    ->with('warning', "Imported {$successCount} records with errors")
                    ->with('import_errors', $errors);
            }

            return back()->with('success', "Successfully imported {$successCount} records");
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
