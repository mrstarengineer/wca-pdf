<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * App\Models\Auction
 *
 * @property int $id
 * @property int $location_id
 * @property int $auction_yard_id
 * @property string $auction_at
 * @property int|null $auction_type
 * @property string|null $catalog_url
 * @property string|null $queue
 * @property int|null $status
 * @property string|null $break_title
 * @property string|null $break_ended_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AuctionVehicle> $auction_vehicles
 * @property-read \App\Models\AuctionYard|null $auction_yard
 * @property-read mixed $display_name
 * @property-read mixed $yard_display_name
 * @property-read \App\Models\Location|null $location
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 */
class Auction extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'auction_yard_id',
        'auction_at',
        'status',
        'auction_type',
        'catalog_url',
        'break_title',
        'break_ended_at',
        'purpose',
    ];

    protected $casts = ['auction_at' => 'datetime'];


    public function auction_yard()
    {
        return $this->belongsTo(AuctionYard::class);
    }

    public function auction_vehicles()
    {
        return $this->hasMany(AuctionVehicle::class)->orderBy('item_number');
    }

    public function getYardDisplayNameAttribute()
    {
        return data_get($this, 'auction_yard.name').', '.data_get($this, 'location.name');
    }

    public function getDisplayNameAttribute()
    {
        return data_get($this, 'auction_yard.name').' ('.\Carbon\Carbon::parse($this->auction_at)->format('d/m/Y h:i a') .')';
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


}
