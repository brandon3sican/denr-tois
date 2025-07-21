<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RegionController extends Controller
{
    public function index(Request $request)
    {
        $validSortFields = ['code', 'name', 'region_center', 'is_active', 'created_at'];
        $sortField = in_array($request->get('sort'), $validSortFields) ? $request->get('sort') : 'created_at';
        $sortDirection = $request->get('direction', 'desc');
        $sortDirection = in_array(strtolower($sortDirection), ['asc', 'desc']) ? $sortDirection : 'desc';
        
        $search = $request->get('search', '');
        
        $regions = Region::when($search, function($query) use ($search) {
                return $query->where('code', 'like', "%{$search}%")
                           ->orWhere('name', 'like', "%{$search}%")
                           ->orWhere('region_center', 'like', "%{$search}%");
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->withQueryString();
            
        return view('regions.index', compact('regions', 'sortField', 'sortDirection', 'search'));
    }

    public function create()
    {
        return view('regions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:regions',
            'name' => 'required|string|max:255',
            'region_center' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Region::create($validated);

        return redirect()->route('regions.index')
            ->with('success', 'Region created successfully.');
    }

    public function show(Region $region)
    {
        $region->load('officialStations');
        return view('regions.show', compact('region'));
    }

    public function edit(Region $region)
    {
        return view('regions.edit', compact('region'));
    }

    public function update(Request $request, Region $region)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:10',
                Rule::unique('regions')->ignore($region->id),
            ],
            'name' => 'required|string|max:255',
            'region_center' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $region->update($validated);

        return redirect()->route('regions.index')
            ->with('success', 'Region updated successfully');
    }

    public function destroy(Region $region)
    {
        try {
            DB::beginTransaction();
            
            // Delete related official stations
            $region->officialStations()->delete();
            
            // Delete the region
            $region->delete();
            
            DB::commit();
            
            return redirect()->route('regions.index')
                ->with('success', 'Region and its official stations deleted successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('regions.index')
                ->with('error', 'Error deleting region: ' . $e->getMessage());
        }
    }
}
