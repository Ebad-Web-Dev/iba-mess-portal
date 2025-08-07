@include('student.src.header')

<style>
    /* Your existing styles */
    .meal-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .meal-header {
        background: #801f0f;
        color: white;
        padding: 15px 20px;
    }
    
    .meal-body {
        padding: 20px;
    }
    
    .meal-option {
        border: 2px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        transition: all 0.3s ease;
        cursor: pointer;
        margin-bottom: 15px;
    }
    
    .meal-option:hover {
        border-color: #3498db;
    }
    
    .meal-option.selected {
        border: 2px solid #4CAF50;
        background-color: #f8f9fa;
        box-shadow: 0 0 10px rgba(76, 175, 80, 0.3);
    }
    
    .meal-option.disabled {
        opacity: 0.7;
        cursor: not-allowed;
        pointer-events: none;
    }
    
    .total-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-top: 20px;
    }
    
    .total-amount {
        color: #e74c3c;
        font-weight: bold;
    }
    
    .subscription-info {
        background: #f8f9fa;
        border-left: 4px solid #2c3e50;
        padding: 15px;
        margin-bottom: 20px;
    }
</style>

<div class="container mt-4">
    <h1 class="text-center mb-4">Monthly Meal Selection</h1>
    
    @php
        $nameParts = explode(' ', $student->name);
        $firstName = $nameParts[0];
        $lastName = implode(' ', array_slice($nameParts, 1));
        
        // Check if user has active subscription
        $hasActiveSubscription = $subscription && $subscription->end_date->isFuture();
        $canSubscribeForNextMonth = $subscription && now()->diffInDays($subscription->end_date) < 5;
    @endphp

    <!-- Meal Selection Card -->
    <div class="meal-card">
        <div class="meal-header">
            <h3><i class="fas fa-utensils me-2"></i> 
                @if($hasActiveSubscription)
                    Your Current Meal Plan ({{ $subscription->start_date->format('F Y') }})
                @else
                    Select Your Meal Plan
                @endif
            </h3>
        </div>
        
        <div class="meal-body">
            @if($hasActiveSubscription)
                <div class="subscription-info">
                    <p>
                        <i class="fas fa-info-circle me-2"></i>
                        You already have an active meal plan for {{ $subscription->start_date->format('F Y') }}.
                        @if($subscription->end_date->isToday())
                            Expires today.
                        @else
                            Valid until: {{ $subscription->end_date->format('M d, Y') }}
                        @endif
                    </p>
                    
                    <div class="text-center mt-3" id="voucher-print-section">
                        <a href="{{ route('student.meal-voucher', $subscription->uid) }}" 
                           target="_blank"
                           class="btn btn-success btn-lg">
                            <i class="fas fa-print me-2"></i> Print Meal Voucher
                        </a>
                    </div>
                    
                    @if($canSubscribeForNextMonth)
                        <div class="mt-3 alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Your current plan will expire soon. You can subscribe for next month starting from 
                            {{ $subscription->end_date->addDay()->format('M d, Y') }}
                        </div>
                    @endif
                </div>
            @endif
            
            <!-- Always show meal options, but disable selection if active subscription -->
            <form id="mealSelectionForm" method="POST" action="{{ route('student.subscribe') }}">
                @csrf
                <input type="hidden" name="selected_meals" id="selectedMealsInput">
                <input type="hidden" name="start_date" id="startDateInput">
                <input type="hidden" name="end_date" id="endDateInput">
                <input type="hidden" name="total_amount" id="totalAmountInput">
                <input type="hidden" name="total_days" id="totalDaysInput">
                <input type="hidden" name="program" value="{{ $student->class ?? '-' }}">
                <input type="hidden" name="semester" value="{{ $student->semester ?? '-' }}">
                <input type="hidden" name="first_name" value="{{ $firstName ?? '-' }}">
                <input type="hidden" name="last_name" value="{{ $lastName ?? '-' }}">
                <input type="hidden" name="erp_id" value="{{ $student->erp_id ?? '-' }}">
                <input type="hidden" name="student_id" value="{{ $student->id ?? '-' }}">

                <!-- Meal Options -->
                <div class="row g-3">
                    @foreach ($menu as $item)
                        <div class="col-md-3">
                            <div class="meal-option h-100 {{ strtolower($item->menu_name) }}-option 
                                 @if($hasActiveSubscription) disabled @endif" 
                                 id="meal-option-{{ $item->id }}"
                                 @if(!$hasActiveSubscription)
                                     onclick="toggleMealSelection({{ $item->id }}, '{{ $item->menu_name }}', {{ $item->rate->menu_rate ?? 0 }}, {{ $item->rate->id ?? 0 }})"
                                 @endif>
                                <div class="d-flex flex-column h-100">
                                    <h4 class="mb-3">
                                        @if(strtolower($item->menu_name) == 'breakfast')
                                            <i class="fas fa-coffee me-2"></i>
                                        @elseif(strtolower($item->menu_name) == 'lunch')
                                            <i class="fas fa-utensils me-2"></i>
                                        @elseif(strtolower($item->menu_name) == 'dinner')
                                            <i class="fas fa-moon me-2"></i>
                                        @else
                                            <i class="fas fa-utensil-spoon me-2"></i>
                                        @endif
                                        {{ $item->menu_name }}
                                    </h4>
                                    <div class="mt-auto">
                                        <div class="input-group">
                                            <span class="input-group-text">PKR</span>
                                            <span class="input-group-text">{{ number_format($item->rate->menu_rate ?? 0, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <!-- Date Selection -->
                    @if(!$hasActiveSubscription)
                        <div class="col-md-3">
                            <div class="meal-option h-100">
                                <div class="d-flex flex-column h-100">
                                    <h4 class="mb-3">Start Date</h4>
                                    <div class="mt-auto">
                                        <input type="text" class="form-control flatpickr-input" id="start-date" name="start_date_visible" placeholder="Select date" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                @if(!$hasActiveSubscription)
                    <!-- Summary Section -->
                    <div class="total-section mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Selected Meals:</strong> <span id="selected-meals">None</span></p>
                                <p><strong>Start Date:</strong> <span id="display-start-date">Not selected</span></p>
                                <p><strong>End Date:</strong> <span id="display-end-date">Not selected</span></p>
                                <p><strong>Number of Days:</strong> <span id="days-count">0</span></p>
                            </div>
                            <div class="col-md-6 text-end">
                                <h4>Total Amount: <span class="total-amount" id="grand-total">PKR 0.00</span></h4>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-secondary btn-lg" id="submit-btn" disabled>
                            <i class="fas fa-check-circle me-2"></i> Confirm Selection & Proceed
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
    // Global variables
    let selectedMeals = [];
    let startDate = null;
    let endDate = null;
    let totalDays = 0;
    let dailyTotal = 0;
    
    // Initialize date picker
    document.addEventListener('DOMContentLoaded', function() {
        // Only initialize if the element exists (for non-subscribed users)
        if (document.getElementById('start-date')) {
            flatpickr("#start-date", {
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: function(selectedDates, dateStr) {
                    console.log("Date selected:", dateStr); // Debug log
                    startDate = selectedDates[0];
                    calculateMonthEndDate();
                    updateSummary();
                    checkSubmitButton();
                }
            });
        }
    });
    
    // Toggle meal selection with enhanced logging
    function toggleMealSelection(mealId, mealName, mealPrice, rateId) {
        console.log("Toggling meal:", mealId, mealName, mealPrice); // Debug log
        
        const mealOption = document.getElementById(`meal-option-${mealId}`);
        if (!mealOption) {
            console.error("Meal option element not found for ID:", `meal-option-${mealId}`);
            return;
        }
        
        const index = selectedMeals.findIndex(meal => meal.id === mealId);
        
        if (index === -1) {
            // Add meal to selection
            selectedMeals.push({
                id: mealId,
                name: mealName,
                price: mealPrice,
                rate_id: rateId
            });
            mealOption.classList.add('selected');
            console.log("Meal added:", mealName); // Debug log
        } else {
            // Remove meal from selection
            selectedMeals.splice(index, 1);
            mealOption.classList.remove('selected');
            console.log("Meal removed:", mealName); // Debug log
        }
        
        // Calculate daily total
        dailyTotal = selectedMeals.reduce((sum, meal) => sum + meal.price, 0);
        console.log("New daily total:", dailyTotal); // Debug log
        
        updateSummary();
        checkSubmitButton();
    }
    
    // Calculate month end date with validation
    function calculateMonthEndDate() {
        if (!startDate) {
            console.error("No start date set for calculation");
            return;
        }
        
        // Get last day of the month
        endDate = new Date(startDate.getFullYear(), startDate.getMonth() + 1, 0);
        
        // Calculate total days (inclusive of start and end dates)
        const timeDiff = endDate - startDate;
        totalDays = Math.floor(timeDiff / (1000 * 60 * 60 * 24)) + 1;
        
        console.log("Calculated dates:", {
            start: startDate,
            end: endDate,
            days: totalDays
        }); // Debug log
    }
    
    // Enhanced updateSummary with element checks
    function updateSummary() {
        console.log("Updating summary with:", {
            selectedMeals,
            startDate,
            endDate,
            totalDays,
            dailyTotal
        }); // Debug log
        
        // Update selected meals display
        const selectedMealsDisplay = document.getElementById('selected-meals');
        if (selectedMealsDisplay) {
            selectedMealsDisplay.textContent = selectedMeals.length > 0 
                ? selectedMeals.map(meal => meal.name).join(', ') 
                : 'None';
        } else {
            console.error("selected-meals element not found");
        }
        
        // Update dates display
        updateElementText('display-start-date', startDate ? startDate.toLocaleDateString() : 'Not selected');
        updateElementText('display-end-date', endDate ? endDate.toLocaleDateString() : 'Not selected');
        updateElementText('days-count', startDate ? totalDays.toString() : '0');
        
        // Calculate and update total amount
        const totalAmount = startDate && selectedMeals.length > 0 
            ? dailyTotal * totalDays 
            : 0;
        updateElementText('grand-total', `PKR ${totalAmount.toFixed(2)}`);
        
        // Update hidden form inputs
        setInputValue('selectedMealsInput', JSON.stringify(selectedMeals));
        setInputValue('startDateInput', startDate ? formatDate(startDate) : '');
        setInputValue('endDateInput', endDate ? formatDate(endDate) : '');
        setInputValue('totalAmountInput', totalAmount);
        setInputValue('totalDaysInput', totalDays);
    }
    
    // Helper function to update element text
    function updateElementText(id, text) {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = text;
        } else {
            console.error(`Element with ID ${id} not found`);
        }
    }
    
    // Helper function to set input value
    function setInputValue(id, value) {
        const input = document.getElementById(id);
        if (input) {
            input.value = value;
        } else {
            console.error(`Input with ID ${id} not found`);
        }
    }
    
    // Enable/disable submit button
    function checkSubmitButton() {
        const submitBtn = document.getElementById('submit-btn');
        if (submitBtn) {
            const shouldEnable = startDate && selectedMeals.length > 0;
            submitBtn.disabled = !shouldEnable;
            console.log("Submit button state:", shouldEnable ? "Enabled" : "Disabled"); // Debug log
        } else {
            console.error("Submit button not found");
        }
    }
    
    // Helper function to format date as YYYY-MM-DD
    function formatDate(date) {
        const d = new Date(date);
        let month = '' + (d.getMonth() + 1);
        let day = '' + d.getDate();
        const year = d.getFullYear();
        
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        
        return [year, month, day].join('-');
    }
</script>

@include('student.src.footer')