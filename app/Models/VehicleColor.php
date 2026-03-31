<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\VehicleColor
 *
 * @property int $id
 * @property string $name
 * @property string|null $color_code
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class VehicleColor extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'color_code', 'created_by', 'updated_by'];
}
