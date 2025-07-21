<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\OfficialStation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OfficialStationController extends Controller
{
    public function index(Request $request)
    {
        $validSortFields = ['code', 'name', 'region_id', 'is_active', 'created_at'];
        $sortField = in_array($request->get('sort'), $validSortFields) ? $request->get('sort') : 'created_at';
        $sortDirection = $request->get('direction', 'desc');
        $sortDirection = in_array(strtolower($sortDirection), ['asc', 'desc']) ? $sortDirection : 'desc';
        
        $search = $request->get('search', '');
        
        $stations = OfficialStation::with('region')
            ->when($search, function($query) use ($search) {
                return $query->where('code', 'like', "%{$search}%")
                           ->orWhere('name', 'like', "%{$search}%")
                           ->orWhereHas('region', function($q) use ($search) {
                               $q->where('name', 'like', "%{$search}%");
                           });
            })
            ->when($sortField === 'region_id', function($query) use ($sortDirection) {
                return $query->join('regions', 'official_stations.region_id', '=', 'regions.id')
                    ->orderBy('regions.name', $sortDirection)
                    ->select('official_stations.*');
            })
            ->when(in_array($sortField, ['code', 'name', 'is_active', 'created_at']), function($query) use ($sortField, $sortDirection) {
                return $query->orderBy($sortField, $sortDirection);
            })
            ->paginate(10)
            ->withQueryString();
            
        return view('official-stations.index', compact('stations', 'sortField', 'sortDirection', 'search'));
    }

    public function create()
    {
        $regions = Region::where('is_active', true)->orderBy('name')->get();
        return view('official-stations.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'code' => 'required|string|max:20|unique:official_stations',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'officer_in_charge' => 'required|string|max:255',
            'officer_position' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // If contact number or email is not provided, use the region's
        if (empty($validated['contact_number'])) {
            $region = Region::find($validated['region_id']);
            $validated['contact_number'] = $region->contact_number;
        }
        
        if (empty($validated['email'])) {
            $region = Region::find($validated['region_id']);
            $validated['email'] = $region->email;
        }

        OfficialStation::create($validated);

        return redirect()->route('official-stations.index')
            ->with('success', 'Official Station created successfully.');
    }

    public function show(OfficialStation $officialStation)
    {
        $officialStation->load('region');
        return view('official-stations.show', compact('officialStation'));
    }

    public function edit(OfficialStation $officialStation)
    {
        $regions = Region::where('is_active', true)->orderBy('name')->get();
        return view('official-stations.edit', compact('officialStation', 'regions'));
    }

    public function update(Request $request, OfficialStation $officialStation)
    {
        $validated = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('official_stations')->ignore($officialStation->id),
            ],
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'officer_in_charge' => 'required|string|max:255',
            'officer_position' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $officialStation->update($validated);

        return redirect()->route('official-stations.index')
            ->with('success', 'Official Station updated successfully');
    }

    public function destroy(OfficialStation $officialStation)
    {
        try {
            $officialStation->delete();
            return redirect()->route('official-stations.index')
                ->with('success', 'Official Station deleted successfully');
                
        } catch (\Exception $e) {
            return redirect()->route('official-stations.index')
                ->with('error', 'Error deleting official station: ' . $e->getMessage());
        }
    }

    // API Method to get stations by region (keep this for the travel order form)
    public function getByRegion($regionId)
    {
        $stations = OfficialStation::where('region_id', $regionId)
            ->where('is_active', true)
            ->select('id', 'code', 'name', 'address')
            ->get();
            
        return response()->json($stations);
    }
}
