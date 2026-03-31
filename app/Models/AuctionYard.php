<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\AuctionYard
 *
 * @property int $id
 * @property string $name
 * @property int $location_id
 * @property string|null $phone
 * @property string|null $fax
 * @property string|null $hours
 * @property string|null $physical_address
 * @property string|null $mailing_address
 * @property string|null $directions
 * @property string|null $banner_image
 * @property int|null $general_manager_id
 * @property int|null $regional_manager_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $general_manager
 * @property-read \App\Models\Location|null $location
 * @property-read \App\Models\User|null $regional_manager
 */
class AuctionYard extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'location_id',
        'phone',
        'fax',
        'hours',
        'physical_address',
        'mailing_address',
        'directions',
        'banner_image',
        'general_manager_id',
        'regional_manager_id',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];


    public function general_manager()
    {
        return $this->belongsTo(User::class, 'general_manager_id');
    }

    public function regional_manager()
    {
        return $this->belongsTo(User::class, 'regional_manager_id');
    }
}
