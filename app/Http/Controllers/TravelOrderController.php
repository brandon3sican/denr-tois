<?php

namespace App\Http\Controllers;

use App\Models\TravelOrder;
use App\Models\Employee;
use App\Models\TravelOrderStatus;
use App\Models\TravelOrderUserType;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TravelOrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // If user is admin, show all travel orders
        // Otherwise, only show travel orders for the logged-in employee
        $query = TravelOrder::with(['employee', 'status']);
        
        if (!$user->is_admin) {
            $query->where('employee_id', $user->employee_id);
        }
        
        $travelOrders = $query->latest()->paginate(10);
        
        return view('travel-orders.index', compact('travelOrders'));
    }

    public function create()
    {
        $user = auth()->user();
        
        // Only admin can select employee, others will use their own employee record
        $employees = $user->is_admin ? Employee::all() : collect();
        
        // Get the current user's employee record if not admin
        $employee = !$user->is_admin ? Employee::find($user->employee_id) : null;
        
        $userTypes = TravelOrderUserType::all();
        $regions = \App\Models\Region::where('is_active', true)->get();
        
        // Get or create the 'For Recommendation' status
        $forRecommendationStatus = TravelOrderStatus::firstOrCreate(
            ['name' => 'For Recommendation'],
            ['description' => 'Travel order is pending recommendation']
        );
        
        return view('travel-orders.create', [
            'employees' => $employees,
            'employee' => $employee,
            'isAdmin' => $user->is_admin,
            'userTypes' => $userTypes,
            'regions' => $regions,
            'forRecommendationStatus' => $forRecommendationStatus,
            'status_id' => $forRecommendationStatus->id
        ]);
    }

    public function store(Request $request)
    {
        // Log the incoming request data
        \Log::info('Travel Order Creation Request:', $request->all());
        
        // Get or create the 'For Recommendation' status
        $validated = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'address' => 'required|string',
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'date' => 'required|date',
            'travel_order_no' => 'required|string|unique:travel_orders,travel_order_no',
            'employee_id' => 'required|exists:employees,id',
            'full_name' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'position' => 'required|string|max:255',
            'div_sec_unit' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'official_station' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'arrival_date' => 'required|date|after_or_equal:departure_date',
            'purpose_of_travel' => 'required|string',
            'per_diem_expenses' => 'required|numeric|min:0',
            'assistant_or_laborers_allowed' => 'required|integer|min:0',
            'appropriations' => 'nullable|string',
            'remarks' => 'nullable|string',
            'status_id' => 'required|exists:travel_order_statuses,id',
            'signatories' => 'required|array|min:1',
            'signatories.*.employee_id' => 'required|exists:employees,id',
            'signatories.*.user_type_id' => 'required|exists:travel_order_user_types,id',
        ]);

        // For non-admin users, ensure they can only create travel orders for themselves
        if (!$user->is_admin) {
            $validated['employee_id'] = $user->employee_id;
            
            // Get the employee data to ensure we have the latest information
            $employee = Employee::findOrFail($user->employee_id);
            $validated['full_name'] = $employee->full_name;
            $validated['position'] = $employee->position;
            $validated['salary'] = $employee->salary;
            $validated['div_sec_unit'] = $employee->div_sec_unit;
        }

        // Get or create the 'For Recommendation' status
        $forRecommendationStatus = TravelOrderStatus::firstOrCreate(
            ['name' => 'For Recommendation'],
            ['description' => 'Travel order is pending recommendation']
        );
        
        // Always use the 'For Recommendation' status for new travel orders
        $request->merge(['status_id' => $forRecommendationStatus->id]);

        // Log the validated data before creation
        \Log::info('Validated data before creation:', $validated);

        try {
            // Create the travel order
            $travelOrder = TravelOrder::create($validated);
            \Log::info('Travel Order Created:', $travelOrder->toArray());
            
            // Add signatories if any
            if (isset($validated['signatories']) && is_array($validated['signatories'])) {
                \Log::info('Adding signatories:', $validated['signatories']);
                foreach ($validated['signatories'] as $signatory) {
                    $travelOrder->signatories()->create([
                        'employee_id' => $signatory['employee_id'],
                        'user_type_id' => $signatory['user_type_id'],
                        'is_signed' => false,
                    ]);
                }
                \Log::info('Signatories added successfully');
            }
            
            return redirect()->route('travel-orders.index')
                ->with('success', 'Travel order created successfully.');
                
        } catch (\Exception $e) {
            \Log::error('Error creating travel order: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withInput()
                ->with('error', 'Error creating travel order: ' . $e->getMessage());
        }

        // Add signatories
        foreach ($request->signatories as $signatory) {
            $travelOrder->signatories()->create([
                'employee_id' => $signatory['employee_id'],
                'user_type_id' => $signatory['user_type_id'],
                'is_signed' => false,
            ]);
        }

        return redirect()->route('travel-orders.index')
            ->with('success', 'Travel Order created successfully.');
    }

    public function show(TravelOrder $travelOrder)
    {
        $user = auth()->user();
        
        // If user is not admin and doesn't own this travel order, deny access
        if (!$user->is_admin && $travelOrder->employee_id !== $user->employee_id) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('travel-orders.show', compact('travelOrder'));
    }

    public function edit(TravelOrder $travelOrder)
    {
        $user = auth()->user();
        
        // If user is not admin and doesn't own this travel order, deny access
        if (!$user->is_admin && $travelOrder->employee_id !== $user->employee_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $employees = $user->is_admin ? Employee::all() : [];
        $statuses = TravelOrderStatus::all();
        $userTypes = TravelOrderUserType::all();
        $regions = \App\Models\Region::where('is_active', true)->get();
        
        return view('travel-orders.edit', compact('travelOrder', 'employees', 'statuses', 'userTypes', 'regions'));
    }

    public function update(Request $request, TravelOrder $travelOrder)
    {
        $user = auth()->user();
        
        // If user is not admin and doesn't own this travel order, deny access
        if (!$user->is_admin && $travelOrder->employee_id !== $user->employee_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'travel_order_no' => 'required|string|max:255',
            'date' => 'required|date',
            'departure_date' => 'required|date',
            'arrival_date' => 'required|date|after_or_equal:departure_date',
            'destination' => 'required|string|max:255',
            'purpose_of_travel' => 'required|string',
            'assistant_or_laborers_count' => 'required|integer|min:0',
            'appropriations' => 'nullable|string',
            'remarks' => 'nullable|string',
            'status_id' => 'required|exists:travel_order_statuses,id',
            'signatories' => 'required|array|min:1',
            'signatories.*.employee_id' => 'required|exists:employees,id',
            'signatories.*.user_type_id' => 'required|exists:travel_order_user_types,id',
        ]);

        $travelOrder->update($validated);

        // Update signatories
        $travelOrder->signatories()->delete();
        foreach ($request->signatories as $signatory) {
            $travelOrder->signatories()->create([
                'employee_id' => $signatory['employee_id'],
                'user_type_id' => $signatory['user_type_id'],
                'is_signed' => false,
            ]);
        }

        return redirect()->route('travel-orders.index')
            ->with('success', 'Travel Order updated successfully');
    }

    public function destroy(TravelOrder $travelOrder)
    {
        $user = auth()->user();
        
        // If user is not admin and doesn't own this travel order, deny access
        if (!$user->is_admin && $travelOrder->employee_id !== $user->employee_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $travelOrder->delete();
        
        return redirect()->route('travel-orders.index')
            ->with('success', 'Travel order deleted successfully');
    }
    
    /**
     * Cancel the specified travel order.
     *
     * @param  \App\Models\TravelOrder  $travelOrder
     * @return \Illuminate\Http\Response
     */
    public function cancel(TravelOrder $travelOrder)
    {
        try {
            $user = auth()->user();
            
            // If user is not admin and doesn't own this travel order, deny access
            if (!$user->is_admin && $travelOrder->employee_id !== $user->employee_id) {
                abort(403, 'Unauthorized action.');
            }
            
            // Debug: Log the incoming travel order data
            \Log::info('Cancel request received for travel order:', [
                'id' => $travelOrder->id,
                'user_id' => $user->id,
                'is_admin' => $user->is_admin,
                'current_status' => $travelOrder->status,
                'status_type' => gettype($travelOrder->status),
                'status_relation_loaded' => $travelOrder->relationLoaded('status'),
            ]);
            
            // Get the current status name for logging
            $currentStatus = is_string($travelOrder->status) 
                ? $travelOrder->status 
                : ($travelOrder->status->name ?? 'unknown');
            
            \Log::debug("Resolved current status: {$currentStatus}");
            
            // Ensure the travel order is in a cancellable state
            if (in_array(strtolower($currentStatus), ['cancelled', 'completed'])) {
                $message = "Cannot cancel a travel order with status: {$currentStatus}";
                \Log::warning($message);
                return redirect()->back()->with('error', $message);
            }
            
            // Get or create the 'Cancelled' status
            $cancelledStatus = TravelOrderStatus::firstOrCreate(
                ['name' => 'cancelled'],
                ['description' => 'Travel order has been cancelled']
            );
            
            \Log::debug("Cancelled status ID: {$cancelledStatus->id}");
            
            // Update the travel order status
            $updateData = [
                'status_id' => $cancelledStatus->id,
                'status' => 'cancelled'
            ];
            
            $updated = $travelOrder->update($updateData);
            
            // Refresh the model to get updated data
            $travelOrder->refresh();
            
            // Log the status change with before/after
            \Log::info("Travel Order #{$travelOrder->id} status update result: " . ($updated ? 'success' : 'failed'), [
                'before' => [
                    'status' => $currentStatus,
                ],
                'after' => [
                    'status' => $travelOrder->status,
                    'status_id' => $travelOrder->status_id,
                ],
                'update_data' => $updateData
            ]);
            
            if (!$updated) {
                throw new \Exception("Failed to update travel order status");
            }
            
            return redirect()->back()
                ->with('success', 'Travel order has been cancelled successfully.');
                
        } catch (\Exception $e) {
            \Log::error("Error cancelling travel order #{$travelOrder->id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Failed to cancel travel order. Please try again.');
        }
    }
}
