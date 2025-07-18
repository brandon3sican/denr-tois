<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\TravelOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with key metrics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $totalTravelOrders = TravelOrder::count();
        
        // Get counts for different statuses
        $statusCounts = [
            'pending' => 0,
            'for_recommendation' => 0,
            'for_approval' => 0,
            'approved' => 0,
            'disapproved' => 0,
            'cancelled' => 0,
            'completed' => 0
        ];

        if (Schema::hasColumn('travel_orders', 'status')) {
            $statusCounts = [
                'for_recommendation' => TravelOrder::where('status', 'For Recommendation')->count(),
                'for_approval' => TravelOrder::where('status', 'For Approval')->count(),
                'approved' => TravelOrder::where('status', 'Approved')->count(),
                'disapproved' => TravelOrder::where('status', 'Disapproved')->count(),
                'cancelled' => TravelOrder::where('status', 'Cancelled')->count(),
                'completed' => TravelOrder::where('status', 'Completed')->count(),
                'pending' => TravelOrder::whereIn('status', ['For Recommendation', 'For Approval'])->count(),
            ];
        }
        
        $recentTravelOrders = TravelOrder::with('employee')
            ->when(Schema::hasColumn('travel_orders', 'status'), function($query) {
                $query->orderByRaw("FIELD(status, 'For Recommendation', 'For Approval', 'Approved', 'Disapproved', 'Cancelled', 'Completed')");
            })
            ->latest()
            ->take(5)
            ->get();

        $data = [
            'totalEmployees' => Employee::count(),
            'totalUsers' => User::count(),
            'totalTravelOrders' => $totalTravelOrders,
            'pendingTravelOrders' => $statusCounts['pending'],
            'statusCounts' => $statusCounts,
            'recentTravelOrders' => $recentTravelOrders,
            'user' => Auth::user(),
        ];

        return view('dashboard', $data);
    }
}
