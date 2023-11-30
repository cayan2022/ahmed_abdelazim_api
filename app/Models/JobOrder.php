<?php

namespace App\Models;

use App\Http\Filters\DoctorFilter;
use App\Http\Filters\Filterable;
use App\Http\Filters\JobOrderFilter;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\JobOrderResource;
use App\Models\Traits\HasActivation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class JobOrder extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia,Filterable;

    protected $fillable = [
        'name',
        'email',
        'phone'
    ];

    protected $filter=JobOrderFilter::class;

    public const MEDIA_COLLECTION_NAME = 'job_order_cv';

    public function getResource(): JobOrderResource
    {
        return new JobOrderResource($this->fresh());
    }

    public function getCV()
    {
        return $this->getFirstMediaUrl(self::MEDIA_COLLECTION_NAME);
    }


}
