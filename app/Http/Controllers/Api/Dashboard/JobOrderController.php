<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Resources\JobOrderResource;
use App\Models\JobOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobOrderController extends Controller
{

    public function index(Request $request)
    {
        $job_orders = JobOrder::filter()->latest()->paginate();

        return JobOrderResource::collection($job_orders);
    }




    public function show(JobOrder $job_order)
    {
        return new JobOrderResource($job_order);
    }
}
