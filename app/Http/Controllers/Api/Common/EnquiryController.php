<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnquiryRequest;
use App\Services\Enquiry\CreateEnquiryService;

class EnquiryController extends Controller
{
    public function store(
        StoreEnquiryRequest $request,
        CreateEnquiryService $service
    ) {
       
        $enquiry = $service->execute($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Enquiry submitted successfully',
            'data'    => []
        ], 200);
    }
}
