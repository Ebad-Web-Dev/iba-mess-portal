<?php

namespace App\Providers;

use App\Models\Student;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $erpId = session('student_erp_id');
            $student = Student::where('erp_id', $erpId)->first();
            $view->with('student', $student);
    });
    }
}
