<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\VehicleImage
 *
 * @property int $id
 * @property string $name
 * @property string|null $thumbnail
 * @property int $status
 * @property int $type
 * @property int $vehicle_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $extension
 * @property-read VehicleImage|null $vehicle
 */
class VehicleImage extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'thumbnail',
        'status',
        'vehicle_id',
        'type',
    ];

    protected $appends = ['extension'];

    public function vehicle()
    {
        return $this->belongsTo(VehicleImage::class);
    }

    public function getExtensionAttribute()
    {
        return pathinfo($this->name, PATHINFO_EXTENSION);
    }
}
