<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\AuctionVehicle
 *
 * @property int $id
 * @property int $auction_id
 * @property int $vehicle_id
 * @property int|null $item_number
 * @property int|null $serial
 * @property int|null $start_bid_amount
 * @property int|null $reserve_amount
 * @property int|null $current_bid_amount
 * @property int|null $status
 * @property int|null $winner_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Auction|null $auction
 * @property-read int|null $bids_count
 * @property-read mixed $serial_display_name
 * @property-read int|null $offline_bids_count
 * @property-read \App\Models\Vehicle|null $vehicle
 */
class AuctionVehicle extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'vehicle_id',
        'item_number',
        'current_bid_amount',
        'status',
        'winner_id',
        'serial',
        'skipped',
        'start_bid_amount',
        'sale_type',
        'reserve_amount',
        'is_golden',
        'offer_type',
        'offer_value',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class)->withTrashed();
    }

}
