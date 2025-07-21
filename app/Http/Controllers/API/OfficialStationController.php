<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OfficialStation;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OfficialStationController extends Controller
{
    /**
     * Display a listing of the official stations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stations = OfficialStation::with('region')->get();
        return response()->json($stations);
    }

    /**
     * Store a newly created official station in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // If contact number or email is not provided, use the region's
        $region = Region::find($request->region_id);
        $contactNumber = $request->contact_number ?? $region->contact_number;
        $email = $request->email ?? $region->email;

        $station = OfficialStation::create([
            'region_id' => $request->region_id,
            'code' => $request->code,
            'name' => $request->name,
            'address' => $request->address,
            'contact_number' => $contactNumber,
            'email' => $email,
            'officer_in_charge' => $request->officer_in_charge,
            'officer_position' => $request->officer_position,
            'is_active' => $request->has('is_active') ? $request->is_active : true,
        ]);

        return response()->json($station, 201);
    }

    /**
     * Display the specified official station.
     *
     * @param  \App\Models\OfficialStation  $officialStation
     * @return \Illuminate\Http\Response
     */
    public function show(OfficialStation $officialStation)
    {
        $officialStation->load('region');
        return response()->json($officialStation);
    }

    /**
     * Get official stations by region ID.
     *
     * @param  int  $regionId
     * @return \Illuminate\Http\Response
     */
    public function getByRegion($regionId)
    {
        $stations = OfficialStation::where('region_id', $regionId)
            ->where('is_active', true)
            ->select('id', 'code', 'name', 'address')
            ->get();
            
        return response()->json($stations);
    }

    /**
     * Update the specified official station in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OfficialStation  $officialStation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfficialStation $officialStation)
    {
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $officialStation->update([
            'region_id' => $request->region_id,
            'code' => $request->code,
            'name' => $request->name,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'officer_in_charge' => $request->officer_in_charge,
            'officer_position' => $request->officer_position,
            'is_active' => $request->has('is_active') ? $request->is_active : $officialStation->is_active,
        ]);

        return response()->json($officialStation);
    }

    /**
     * Remove the specified official station from storage.
     *
     * @param  \App\Models\OfficialStation  $officialStation
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfficialStation $officialStation)
    {
        $officialStation->delete();
        return response()->json(['message' => 'Official Station deleted successfully']);
    }
}
