<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
{
    /**
     * Display a listing of the regions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = Region::all();
        return response()->json($regions);
    }

    /**
     * Store a newly created region in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:10|unique:regions',
            'name' => 'required|string|max:255',
            'region_center' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $region = Region::create([
            'code' => $request->code,
            'name' => $request->name,
            'region_center' => $request->region_center,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'is_active' => $request->has('is_active') ? $request->is_active : true,
        ]);

        return response()->json($region, 201);
    }

    /**
     * Display the specified region.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        $region->load('officialStations');
        return response()->json($region);
    }

    /**
     * Update the specified region in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:10|unique:regions,code,' . $region->id,
            'name' => 'required|string|max:255',
            'region_center' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $region->update([
            'code' => $request->code,
            'name' => $request->name,
            'region_center' => $request->region_center,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'is_active' => $request->has('is_active') ? $request->is_active : $region->is_active,
        ]);

        return response()->json($region);
    }

    /**
     * Remove the specified region from storage.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        // Check if region has any official stations
        if ($region->officialStations()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete region with associated official stations.',
                'errors' => [
                    'official_stations' => ['This region has official stations associated with it. Delete them first.']
                ]
            ], 422);
        }

        $region->delete();
        return response()->json(['message' => 'Region deleted successfully']);
    }
}
