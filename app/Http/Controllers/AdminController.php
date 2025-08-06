<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
   public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.admin_login');
    }

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
        // Manually set the admin guard
        $request->session()->put('admin', Auth::guard('admin')->user());
        
        // Regenerate both session and token
        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return redirect()->intended(route('admin.dashboard'));
    }

    return back()->withErrors([
        'email' => 'Invalid credentials',
    ])->onlyInput('email');
}
    
    public function dashboard(Request $request)
    {
        if ($request->ajax()) {
            $data = Student::select('id', 'room_no', 'name', 'class', 'batch', 'erp_id', 'enabled');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->enabled ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="' . route("admin.students.edit", $row->id) . '" class="btn btn-sm btn-primary">View</a>';
                    $delBtn = '<form action="' . route("student.delete", $row->id) . '" method="POST" style="display:inline-block;">
                                    ' . csrf_field() . method_field("DELETE") . '
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                            </form>';
                    return $editBtn . ' ' . $delBtn;
                })
                ->rawColumns(['status', 'action']) // Allow HTML for status badge and action buttons
                ->make(true);
        }

        return view('admin.index');
    }


    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.edit_student', compact('student'));
    }

   public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'room_no' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'class' => 'required|string|max:50',
            'batch' => 'required|string|max:20',
            'erp_id' => 'required|string|max:50',
            'enabled' => 'required|boolean',
        ]);

        try {
            // Find the student
            $student = Student::findOrFail($id);
            
            // Update with validated data (excluding serial_no as in your original)
            $student->update($validatedData);
            
            return redirect()->route('admin.dashboard')
                ->with('success', 'Student successfully updated');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating student: '.$e->getMessage())
                ->withInput();
        }
    }
    public function toggleStatus($id)
    {
    $student = Student::findOrFail($id);
    $student->status = !$student->status;
    $student->save();
    return response()->json(['status' => 'success']);
    }

    public function delete($id)
    {
    $student = Student::findOrFail($id);
    $student->delete();
    return response()->json(['status' => 'deleted']);
    }





    // app/Http/Controllers/AdminController.php
    public function logout(Request $request)
    {
        // Clear specific admin session data
        $request->session()->forget('admin');
        
        // Standard logout
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function printVoucher($uid)
    {
        $voucher_info = DB::table('online_payment_profile')->where('uid', $uid)->get();
        dd($voucher_info);
        if ($voucher_info->isEmpty()) {
            abort(404);
        }

        $voucher_copies = ['Bank Copy', 'Student Copy', 'Admin Copy', 'Accounts Copy'];

        return view('student.voucher', [
            'voucher_info' => $voucher_info,
            'voucher_copies' => $voucher_copies,
        ]);
    }


 
    // public function students_meals(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $subscriptions = Subscription::with(['student', 'menuType', 'menuRate'])->get();
            
    //         // Get all UIDs for batch query
    //         $uids = $subscriptions->pluck('uid')->unique();
            
    //         // Query payment status from second database
    //         $paymentStatuses = DB::connection('mysql2')
    //             ->table('online_payment_logs')
    //             ->whereIn('uid', $uids)
    //             ->pluck('current_status', 'uid')
    //             ->toArray();
            
    //         $groupedData = $subscriptions->groupBy('uid')->map(function ($group) use ($paymentStatuses) {
    //             $first = $group->first();
                
    //             // Calculate dates and days
    //             $startDate = Carbon::parse($first->start_date);
    //             $endDate = Carbon::parse($first->end_date);
    //             $totalDays = $startDate->diffInDays($endDate) + 1; // Inclusive
                
    //             // Calculate total price correctly
    //             $totalPrice = 0;
    //             $menuDetails = [];
                
    //             foreach ($group as $subscription) {
    //                 if ($subscription->menuRate) {
    //                     $dailyRate = $subscription->menuRate->menu_rate;
    //                     $menuDetails[] = [
    //                         'name' => $subscription->menuType->menu_name ?? 'Unknown',
    //                         'rate' => $dailyRate,
    //                         'total' => $dailyRate * $totalDays
    //                     ];
    //                     $totalPrice += $dailyRate * $totalDays;
    //                 }
    //             }
                
    //             return [
    //                 'uid' => $first->uid,
    //                 'student_erp' => $first->student_erp,
    //                 'student' => [
    //                     'name' => optional($first->student)->name,
    //                     'class' => optional($first->student)->class,
    //                     'room_no' => optional($first->student)->room_no,
    //                 ],
    //                 'menu_types' => $group->map(fn($s) => $s->menuType->menu_name ?? '-')->unique()->implode('<br>'),
    //                 'menu_rates' => $group->map(fn($s) => $s->menuRate ? 'PKR '.number_format($s->menuRate->menu_rate, 2) : '-')->implode('<br>'),
    //                 'total_price' => 'PKR '.number_format($totalPrice, 2),
    //                 'total_days' => $totalDays,
    //                 'start_date' => $startDate->format('d-M-Y'),
    //                 'end_date' => $endDate->format('d-M-Y'),
    //                 'payment_status' => isset($paymentStatuses[$first->uid]) ? 'Paid' : 'Unpaid',
    //                 '_debug' => [
    //                     'menu_details' => $menuDetails,
    //                     'calculation' => 'sum(daily_rate × '.$totalDays.' days)'
    //                 ]
    //             ];
    //         })->values();
            
    //         return DataTables::of($groupedData)
    //             ->addColumn('payment_status', function($row) {
    //                 $badgeClass = $row['payment_status'] === 'Paid' ? 'badge-success' : 'badge-danger';
    //                 return '<span class="badge ' . $badgeClass . '">' . $row['payment_status'] . '</span>';
    //             })
    //             ->rawColumns(['menu_types', 'menu_rates', 'payment_status'])
    //             ->toJson();
    //     }
        
    //     return view('admin.meals');
    // }




    public function students_meals(Request $request)
{
    if ($request->ajax()) {
        $subscriptions = Subscription::with(['student', 'menuType', 'menuRate'])->get();
        
        // Get all UIDs for batch query
        $uids = $subscriptions->pluck('uid')->unique();
        
        // Query payment status from second database
        $paymentStatuses = DB::connection('mysql2')
            ->table('online_payment_logs')
            ->whereIn('uid', $uids)
            ->pluck('current_status', 'uid')
            ->toArray();
        
        // Update voucher_status in primary database for paid subscriptions
        $paidUids = array_keys(array_filter($paymentStatuses, function($status) {
            return strtolower($status) === 'paid';
        }));
        
        if (!empty($paidUids)) {
            Subscription::whereIn('uid', $paidUids)
                ->where('voucher_status', '!=', 'Paid')
                ->update(['voucher_status' => 'Paid']);
        }
        
        $groupedData = $subscriptions->groupBy('uid')->map(function ($group) use ($paymentStatuses) {
            $first = $group->first();
            
            // Calculate dates and days
            $startDate = Carbon::parse($first->start_date);
            $endDate = Carbon::parse($first->end_date);
            $totalDays = $startDate->diffInDays($endDate) + 1; // Inclusive
            
            // Calculate total price correctly
            $totalPrice = 0;
            $menuDetails = [];
            
            foreach ($group as $subscription) {
                if ($subscription->menuRate) {
                    $dailyRate = $subscription->menuRate->menu_rate;
                    $menuDetails[] = [
                        'name' => $subscription->menuType->menu_name ?? 'Unknown',
                        'rate' => $dailyRate,
                        'total' => $dailyRate * $totalDays
                    ];
                    $totalPrice += $dailyRate * $totalDays;
                }
            }
            
            // Determine payment status - check both voucher_status and payment logs
            $paymentStatus = 'Unpaid';
            if (isset($paymentStatuses[$first->uid]) || $first->voucher_status === 'Paid') {
                $paymentStatus = 'Paid';
            }
            
            return [
                'uid' => $first->uid,
                'student_erp' => $first->student_erp,
                'student' => [
                    'name' => optional($first->student)->name,
                    'class' => optional($first->student)->class,
                    'room_no' => optional($first->student)->room_no,
                ],
                'menu_types' => $group->map(fn($s) => $s->menuType->menu_name ?? '-')->unique()->implode('<br>'),
                'menu_rates' => $group->map(fn($s) => $s->menuRate ? 'PKR '.number_format($s->menuRate->menu_rate, 2) : '-')->implode('<br>'),
                'total_price' => 'PKR '.number_format($totalPrice, 2),
                'total_days' => $totalDays,
                'start_date' => $startDate->format('d-M-Y'),
                'end_date' => $endDate->format('d-M-Y'),
                'payment_status' => $paymentStatus,
                '_debug' => [
                    'menu_details' => $menuDetails,
                    'calculation' => 'sum(daily_rate × '.$totalDays.' days)',
                    'source' => isset($paymentStatuses[$first->uid]) ? 'payment_logs' : ($first->voucher_status === 'Paid' ? 'voucher_status' : 'none')
                ]
            ];
        })->values();
        
        return DataTables::of($groupedData)
            ->addColumn('payment_status', function($row) {
                $badgeClass = $row['payment_status'] === 'Paid' ? 'badge-success' : 'badge-danger';
                return '<span class="badge ' . $badgeClass . '">' . $row['payment_status'] . '</span>';
            })
            ->rawColumns(['menu_types', 'menu_rates', 'payment_status'])
            ->toJson();
    }
    
    return view('admin.meals');
}


}
