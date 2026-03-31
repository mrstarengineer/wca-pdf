<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Catalogue
 *
 * @property int $id
 * @property string $name
 * @property int|null $created_by
 * @property string|null $file
 * @property array|null $misc
 * @property int|null $number_of_vehicles
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 */
class Catalogue extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'file',
        'created_by',
        'number_of_vehicles',
        'misc',
    ];

    protected $casts = [
        'misc' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
