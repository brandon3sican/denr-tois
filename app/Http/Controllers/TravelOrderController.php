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
        $travelOrders = TravelOrder::with(['employee', 'status'])->latest()->paginate(10);
        return view('travel-orders.index', compact('travelOrders'));
    }

    public function create()
    {
        $user = auth()->user();
        $employees = $user->is_admin ? Employee::all() : collect();
        $userTypes = TravelOrderUserType::all();
        $regions = \App\Models\Region::where('is_active', true)->get();
        
        // Get the 'For Recommendation' status
        $forRecommendationStatus = TravelOrderStatus::where('name', 'For Recommendation')->first();
        if (!$forRecommendationStatus) {
            // Fallback to the first status if 'For Recommendation' doesn't exist
            $forRecommendationStatus = TravelOrderStatus::first();
        }
        
        // Get the authenticated employee's data if not admin
        $employee = null;
        if (!$user->is_admin && $user->employee) {
            $employee = Employee::with(['position' => function($query) {
                $query->select('id', 'name', 'salary');
            }, 'divSecUnit'])->find($user->employee->id);
        }
        
        return view('travel-orders.create', [
            'employees' => $employees,
            'status_id' => $forRecommendationStatus ? $forRecommendationStatus->id : null,
            'status_name' => $forRecommendationStatus ? $forRecommendationStatus->name : 'For Recommendation',
            'userTypes' => $userTypes,
            'isAdmin' => $user->is_admin,
            'employee' => $employee,
            'regions' => $regions
        ]);
    }

    public function store(Request $request)
    {
        // Get the 'For Recommendation' status
        $forRecommendationStatus = TravelOrderStatus::where('name', 'For Recommendation')->first();
        if (!$forRecommendationStatus) {
            // Fallback to the first status if 'For Recommendation' doesn't exist
            $forRecommendationStatus = TravelOrderStatus::first();
        }

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
            'assistant_or_laborers_count' => 'required|integer|min:0',
            'appropriations' => 'nullable|string',
            'remarks' => 'nullable|string',
            'status_id' => 'required|exists:travel_order_statuses,id',
            'signatories' => 'required|array|min:1',
            'signatories.*.employee_id' => 'required|exists:employees,id',
            'signatories.*.user_type_id' => 'required|exists:travel_order_user_types,id',
        ]);

        $travelOrder = TravelOrder::create($validated);

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
        $travelOrder->load('region');
        return view('travel-orders.show', compact('travelOrder'));
    }

    public function edit(TravelOrder $travelOrder)
    {
        $employees = Employee::all();
        $statuses = TravelOrderStatus::all();
        $userTypes = TravelOrderUserType::all();
        $regions = \App\Models\Region::where('is_active', true)->get();
        
        return view('travel-orders.edit', compact('travelOrder', 'employees', 'statuses', 'userTypes', 'regions'));
    }

    public function update(Request $request, TravelOrder $travelOrder)
    {
        $validated = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'address' => 'required|string',
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'date' => 'required|date',
            'travel_order_no' => 'required|string|unique:travel_orders,travel_order_no,' . $travelOrder->id,
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
        $travelOrder->delete();

        return redirect()->route('travel-orders.index')
            ->with('success', 'Travel Order deleted successfully');
    }
}
