<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Spatie\MediaLibrary\HasMedia;
use App\Http\Filters\BranchFilter;
use App\Models\Traits\HasActivation;
use App\Http\Resources\BranchResource;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Branch extends Model implements HasMedia, TranslatableContract
{
    use HasFactory, InteractsWithMedia, Translatable, Filterable, HasActivation;

    protected $fillable = [
        'city',
        'address',
        'telephone',
        'whatsapp',
        'map',
        'is_block',
    ];

    protected $filter = BranchFilter::class;

    public $translatedAttributes = ['name', 'short_description','full_description'];

    protected $casts = [
        'phone'=>'string',
        'whatsapp'=>'string',
        'is_block'=>'boolean'
    ];
    public const MEDIA_COLLECTION_NAME = 'branch_avatar';
    public const MEDIA_COLLECTION_URL = 'images/branch.png';
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /*Helpers*/
    /**
     * @return BranchResource
     */
    public function getResource(): BranchResource
    {
        return new BranchResource($this->fresh());
    }
    public function getAvatar()
    {
        return $this->getFirstMediaUrl(self::MEDIA_COLLECTION_NAME);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION_NAME)
            ->useFallbackUrl(asset(self::MEDIA_COLLECTION_URL))
            ->useFallbackPath(asset(self::MEDIA_COLLECTION_URL));
    }
}
