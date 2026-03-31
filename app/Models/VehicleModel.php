<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\VehicleModel
 *
 * @property int $id
 * @property int $make_id
 * @property string $name
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Make|null $make
 */
class VehicleModel extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'make_id', 'status'];

    protected $casts = [
        'status' => 'integer',
    ];

    public function make()
    {
        return $this->belongsTo(Make::class);
    }
}
