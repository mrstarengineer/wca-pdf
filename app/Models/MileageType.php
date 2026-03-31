<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MileageType
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class MileageType extends BaseModel
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status'];
}
