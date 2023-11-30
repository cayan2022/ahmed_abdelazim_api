<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Site\CreateJobOrderRequest;
use App\Http\Resources\JobOrderResource;
use App\Http\Resources\OrderResource;
use App\Models\Doctor;
use App\Models\JobOrder;

class JobOrderController extends Controller
{

    public function __invoke(CreateJobOrderRequest $createJobOrderRequest): JobOrderResource
    {
        $job_order = JobOrder::create($createJobOrderRequest->only(['name', 'email', 'phone']));

        if ($createJobOrderRequest->hasFile('cv') && $createJobOrderRequest->file('cv')->isValid()) {
            $job_order->addMediaFromRequest('cv')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(JobOrder::MEDIA_COLLECTION_NAME);
        }

        return $job_order->getResource();
    }
}
