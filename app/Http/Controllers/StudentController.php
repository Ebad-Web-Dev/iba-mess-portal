<?php

namespace App\Http\Controllers;

use App\Models\MenuRateModel;
use App\Models\Subscription;
use App\Services\OracleService;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\MealsModel;
use App\Models\StudentModel;
use Illuminate\Support\Facades\Auth;
use App\Services\LdapService;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    
   public function showLoginForm(Request $request)
    {
        if ($request->session()->get('student_authenticated')) {
            return redirect()->route('student.dashboard');
        }
        return view('student.login');
    }

    public function index() {
        $title = "Dashboard";
        $erpId = session('student_erp_id');
        $menu = MealsModel::with('rate')->orderBy('menu_name', 'asc')->get();
        
        // Get current month's subscription
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
        
        $subscription = Subscription::where('student_erp', $erpId)
            ->where('end_date', '>=', now())
            ->whereBetween('start_date', [$currentMonthStart, $currentMonthEnd])
            ->first();
        
        $student = Student::where('erp_id', $erpId)
            ->where('enabled', 1)
            ->first();
            
        return view('student.index', compact('menu', 'student', 'subscription', 'title'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'erp_id' => 'required|string',
            'password' => 'required|string'
        ]);

        // 1. Check local database first
        $student = StudentModel::where('erp_id', $request->erp_id)->first();
        
        if (!$student) {
            return back()->withErrors(['erp_id' => 'Invalid ERP ID'])->withInput();
        }

        // 2. LDAP Authentication
        $ldap = new LdapService();
        $authResult = $ldap->authenticate($request->erp_id, $request->password);

        if (!$authResult['success']) {
            return back()->withErrors(['password' => $authResult['message']])->withInput();
        }

        // // 3. Get Oracle Data
        // $oracleService = new OracleService();
        // $oracleData = $oracleService->getUserDetails($request->erp_id);
        // if (empty($oracleData)) {
        //     return back()->withErrors(['erp_id' => 'Oracle record not found'])->withInput();
        // }
        if (!$authResult['success']) {
        return back()->withErrors(['password' => $authResult['message']])->withInput();
        }

        // 3. Check if student exists in `student_list` table (authorization check)
      $isAuthorized = Student::where([
            ['erp_id', '=', $request->erp_id],
            ['enabled', '=', 1]
        ])->exists();

        if (!$isAuthorized) {
            return back()->withErrors(['erp_id' => 'You are not authorized to access this system'])->withInput();
        }

        // 4. Store all data in session
        $request->session()->put([
            'student_authenticated' => true,
            'student_erp_id' => $student->erp_id,
        ]);

        return redirect()->route('student.dashboard');
    }






   public function logout(Request $request)
    {
        $request->session()->forget([
            'student_authenticated',
            'student_erp_id'
        ]);
        $request->session()->regenerate();
        
        return redirect()->route('student.login.form');
    }

    // In your controller (e.g., MealController.php)
    public function get_meal_rates(Request $request)
    {
        \Log::info('Meal rates request received', $request->all());
        
        try {
            $request->validate([
                'meal_plan_id' => 'required|numeric|exists:menus,id'
            ]);

            $menuRate = MenuRateModel::with('menu')
                        ->where('menu_id', $request->meal_plan_id)
                        ->first();

            if (!$menuRate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Menu rate not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'menu_rate' => $menuRate->menu_rate,
                    'menu_name' => $menuRate->menu->name ?? 'Unknown'
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in get_meal_rates: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: '.$e->getMessage()
            ], 500);
        }
    }

    
    private function generateUidForPayment()
    {
        $voucherType = 'Mess Charges'; // Replace with your constant if needed
        $paymentStartLimit = 1000; // Replace with your PAYMENT_START_LIMIT constant

        $onlinePaymentSystem = DB::connection('mysql2');

        // Get the maximum UID for this voucher type
        $maxUid = $onlinePaymentSystem->table('online_payment_profile')
                    ->where('voucher_type', $voucherType)
                    ->max('uid') ?? $paymentStartLimit;

        $uid = (int)$maxUid + 1;

        // Check if UID exists and find the next available
        while ($onlinePaymentSystem->table('online_payment_profile')
                                ->where('uid', $uid)
                                ->exists()) {
            $uid++;
        }

        return $uid;
    }

    public function subscribe(Request $request)
    {
            $title = "Subscriptions";

        // Validate request data
        $validated = $request->validate([
            'selected_meals' => 'required|json',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_amount' => 'required|numeric|min:0',
            'total_days' => 'required|integer|min:1',
            'erp_id' => 'required',
            'student_id' => 'required',
            'first_name' => 'required',
            'program' => 'required',
            'semester' => 'required'
        ]);

        try {
            DB::beginTransaction();
            
            // Decode and validate selected meals
            $selectedMeals = json_decode($request->selected_meals, true);
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($selectedMeals)) {
                throw new \Exception("Invalid meal selection data");
            }

            // Calculate daily total
            $dailyTotal = array_sum(array_column($selectedMeals, 'price'));
            
            // Generate unique payment ID
            $uid = $this->generateUidForPayment();
            
            // Insert payment record
            $onlinePaymentSystem = DB::connection('mysql2');
            
            $paymentData = [
                'uid' => $uid,
                'erp_id' => $validated['erp_id'],
                'email_address' => '',
                'mobile_number' => '',
                'voucher_type' => "Mess Charges",
                'first_name' => $validated['first_name'],
                'semester' => $validated['semester'],
                'date_submited' => now(),
                'remarks' => 0,
                'paid_amount' => $validated['total_amount'],
                'program' => $validated['program'],
                'voucher_due_date' => $validated['end_date'],
                'voucher_expired_date' => $validated['end_date'],
            ];

            $paymentInserted = $onlinePaymentSystem->table('online_payment_profile')->insert($paymentData);
            
            if (!$paymentInserted) {
                throw new \Exception("Failed to create payment record");
            }
            
            // Create subscription records for all selected meals
            $subscriptions = [];
            foreach ($selectedMeals as $meal) {
                $subscription = Subscription::create([
                    'student_erp' => $validated['erp_id'],
                    'student_id' => $validated['student_id'],
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                    'menu_type_id' => $meal['id'],
                    'menu_rate_id' => $meal['rate_id'],
                    'total_price' => $meal['price'] * $validated['total_days'],
                    'total_days' => $validated['total_days'],
                    'uid' => $uid,
                    'status' => 1
                ]);
                
                if (!$subscription) {
                    throw new \Exception("Failed to create subscription record");
                }
                
                $subscriptions[] = $subscription;
            }

            // Prepare session data
            $subscriptionData = [
                'uid' => $uid,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'total_amount' => $validated['total_amount'],
                'total_days' => $validated['total_days'],
                'selected_meals' => $selectedMeals,
                'month' => Carbon::parse($validated['start_date'])->format('F Y'),
                'daily_total' => $dailyTotal
            ];

            // Store in session
            $request->session()->put([
                'subscription_data' => $subscriptionData,
                'has_active_subscription' => true
            ]);

            DB::commit();

            return redirect()->route('student.meal-voucher', $uid)->with([
                'success' => 'Meal subscription created successfully!', 'title' => "Subscriptions"
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Subscription Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to create subscription. Please try again.']);
        }
    }

// In your controller
public function generateVoucher($uid)  // Changed from showVoucher to generateVoucher
{
    try {
        // Get student ERP ID from session
        $erpId = session('student_erp_id');
        if (!$erpId) {
            throw new \Exception("Student session not found");
        }

        // Get current month start and end dates
        $currentMonthStart = now()->startOfMonth()->format('Y-m-d');
        $currentMonthEnd = now()->endOfMonth()->format('Y-m-d');

        // Get all subscriptions for this UID in current month
        $subscriptions = Subscription::where('uid', $uid)
            ->where('student_erp', $erpId)
            ->whereBetween('start_date', [$currentMonthStart, $currentMonthEnd])
            ->with(['menuType', 'menuRate'])
            ->get();

        if ($subscriptions->isEmpty()) {
            throw new \Exception("No subscription found for this month");
        }

        // Use first subscription for common dates
        $firstSubscription = $subscriptions->first();

        // Prepare selected meals data
        $selectedMeals = [];
        $totalAmount = 0;
        foreach ($subscriptions as $subscription) {
            $selectedMeals[] = [
                'name' => $subscription->menuType->menu_name,
                'price' => $subscription->menuRate->menu_rate
            ];
            $totalAmount += $subscription->total_price;
        }

        // Get student data
        $student = Student::where('erp_id', $erpId)
                            ->where('enabled', 1)
                            ->firstOrFail();

        return view('student.voucher', [
            'voucher_data' => [
                'uid' => $uid,
                'start_date' => $firstSubscription->start_date,
                'end_date' => $firstSubscription->end_date,
                'total_days' => $subscriptions->first()->total_days ?? 
                          Carbon::parse($firstSubscription->start_date)
                              ->diffInDays(Carbon::parse($firstSubscription->end_date)) + 1,
                                  'total_amount' => $totalAmount,
                'month' => Carbon::parse($firstSubscription->start_date)->format('F Y')
            ],
            'student' => $student,
            'selected_meals' => $selectedMeals,
               'total_days' => $subscriptions->first()->total_days ?? 
                          Carbon::parse($firstSubscription->start_date)
                              ->diffInDays(Carbon::parse($firstSubscription->end_date)) + 1,
            'total_amount' => $totalAmount,
            'current_month' => true
        ]);

    } catch (\Exception $e) {
        Log::error('Voucher Error: ' . $e->getMessage());
        return redirect()->route('student.dashboard')->withErrors([
            'error' => 'Failed to generate voucher. ' . $e->getMessage()
        ]);
    }
}
    private function getPaymentStatus($uid)
    {
        // Check primary database first
        $subscription = Subscription::where('uid', $uid)->first();
        if ($subscription && $subscription->voucher_status === 'Paid') {
            return 'Paid';
        }
        
        // Check secondary database
        $payment = DB::connection('mysql2')
            ->table('online_payment_logs')
            ->where('uid', $uid)
            ->where('current_status', 'Paid')
            ->first();
        
        return $payment ? 'Paid' : 'Unpaid';
    }
 public function subscriptions(Request $request)
{
    $erpId = session('student_erp_id');
    
    if ($request->ajax()) {
        $subscriptions = Subscription::with(['student', 'menuType', 'menuRate'])
            ->where('student_erp', $erpId)
            ->orderBy('start_date', 'desc')
            ->get();
        
        // Debug: Log raw subscription data
        \Log::debug('Raw Subscriptions:', $subscriptions->toArray());
        
        $groupedData = $subscriptions->groupBy('uid')->map(function ($group) {
            $first = $group->first();
            
            // Calculate dates and days
            $startDate = Carbon::parse($first->start_date);
            $endDate = Carbon::parse($first->end_date);
            $totalDays = $startDate->diffInDays($endDate) + 1; // Inclusive
            
            // Debug: Log date calculation
            \Log::debug('Date Calculation:', [
                'start' => $first->start_date,
                'end' => $first->end_date,
                'days' => $totalDays
            ]);
            
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
            
            // Debug: Log price calculation
            \Log::debug('Price Calculation:', [
                'menu_details' => $menuDetails,
                'total_price' => $totalPrice
            ]);
            
            return [
                'uid' => $first->uid,
                'month' => $startDate->format('F Y'),
                'menu_types' => $group->map(fn($s) => $s->menuType->menu_name ?? '-')->unique()->implode('<br>'),
                'menu_rates' => $group->map(fn($s) => $s->menuRate ? 'PKR '.number_format($s->menuRate->menu_rate, 2) : '-')->implode('<br>'),
                'total_price' => 'PKR '.number_format($totalPrice, 2),
                'total_days' => $totalDays,
                'start_date' => $startDate->format('d-M-Y'),
                'end_date' => $endDate->format('d-M-Y'),
                'payment_status' => $this->getPaymentStatus($first->uid),
                'voucher_link' => route('student.meal-voucher', $first->uid),
                // For debugging:
                '_debug' => [
                    'menu_details' => $menuDetails,
                    'calculation' => 'sum(daily_rate × '.$totalDays.' days)'
                ]
            ];
        })->values();
        
        return DataTables::of($groupedData)
            ->addColumn('payment_status', function($row) {
                $badgeClass = $row['payment_status'] == 'Paid' ? 'badge-success' : 'badge-danger';
                return '<span class="badge ' . $badgeClass . '">' . $row['payment_status'] . '</span>';
            })
            ->addColumn('action', function($row) {
                return '<a href="'.$row['voucher_link'].'" target="_blank" class="btn btn-sm btn-primary">View Voucher</a>';
            })
            ->rawColumns(['menu_types', 'menu_rates', 'payment_status', 'action'])
            ->toJson();
    }
    
    return view('student.subscription');
}


}

