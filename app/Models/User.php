<?php

namespace App\Models;

use App\Models\Traits\HasActivation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Resources\UserResource;
 use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * User Class
 */
class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles , InteractsWithMedia, HasActivation;

    /**
     *
     */
    public const ADMIN = 'admin';

    /**
     *
     */
    public const MODERATOR = 'moderator';

    /**
     *
     */
    public const MALE = 'male';

    /**
     *
     */
    public const FEMALE = 'female';

    /**
     *
     */
    public const TYPES = [
        self::ADMIN,
        self::MODERATOR,
    ];

    /**
     *
     */
    public const GENDERS = [
        self::MALE,
        self::FEMALE,
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'type', 'phone' , 'gender', 'password', 'is_block','country_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_block'=>'boolean'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            $user->type = self::MODERATOR;
            $user->is_block = false;
        });
    }

    /*Mutators*/
    /**
     * @param $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /*Helpers*/
    /**
     * @return UserResource
     */
    public function getResource(): UserResource
    {
        return new UserResource($this->fresh());
    }
    /**
     * Get the access token currently associated with the user. Create a new.
     *
     * @param  string|null  $device
     * @return string
     */
    public function createTokenForDevice(string $device = null): string
    {
        $device = $device ?: 'Unknown Device';

        $this->tokens()->where('name', $device)->delete();

        return $this->createToken($device)->plainTextToken;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->type===self::ADMIN;
    }

    /**
     * @return bool
     */
    public function isModerator(): bool
    {
        return $this->type===self::MODERATOR;
    }
    /**
     * The user profile image url.
     *
     */
    public function getAvatar()
    {
        return $this->getFirstMediaUrl('images');
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('images')
            ->useFallbackUrl(asset('images/anonymous-user.jpg'))
            ->useFallbackPath(asset('images/anonymous-user.jpg'));
    }
    /*Relations*/
    /**
     * @return HasMany
     */
    public function orderHistories(): HasMany
    {
        return $this->hasMany(OrderHistory::class);
    }

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
