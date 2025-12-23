<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Models\Park;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParkController extends BaseController
{
    public function index()
    {
        $parks = park::get();
        return $this->sendResponse($parks, 'Park list fetched successfully.', null, 200);
    }

    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'short_description' => 'required|string',
                'description' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'country' => 'required|string',
                'train' => 'required|string',
                'airport' => 'required|string',
                'safari_session' => 'required|string',
                'wildlife_found' => 'required|string',
                'safari_cost' => 'required|numeric',
                'safari_mode' => 'required|string',
                'closed_months' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error', $validator->errors(), 422);
            }

            $park = Park::create($validator->validated());

            return $this->sendResponse($park, 'Park created successfully.');

        } catch (\Exception $e) {
            return $this->sendError('Unexpected Error', [$e->getMessage()], 500);
        }
    }
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:parks,id',
                'title' => 'required|string|max:255',
                'short_description' => 'required|string',
                'description' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'country' => 'required|string',
                'train' => 'required|string',
                'airport' => 'required|string',
                'safari_session' => 'required|string',
                'wildlife_found' => 'required|string',
                'safari_cost' => 'required|numeric',
                'safari_mode' => 'required|string',
                'closed_months' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error', $validator->errors(), 422);
            }

            $park = Park::findOrFail($request->id);
            $park->fill($validator->validated());
            $park->save();

            return $this->sendResponse($park, 'Park updated successfully.');

        } catch (\Exception $e) {
            return $this->sendError('Unexpected Error', [$e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $park = Park::find($id);

        if (!$park) {
            return response()->json([
                'status' => false,
                'message' => 'Park not found.',
            ], 404);
        }

        $park->delete();

        return response()->json([
            'status' => true,
            'message' => 'Park deleted successfully.',
        ]);
    }

}
