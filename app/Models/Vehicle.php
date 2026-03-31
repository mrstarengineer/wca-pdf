<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Vehicle
 *
 * @property int $id
 * @property string $vin
 * @property string $year
 * @property string $lot_number
 * @property int|null $color_id
 * @property int|null $category_id
 * @property int $make_id
 * @property int $vehicle_model_id
 * @property int|null $sale_type
 * @property int|null $location_id
 * @property int|null $winner_id
 * @property int|null $vehicle_type_id
 * @property int|null $body_style_id
 * @property int|null $cylinder_id
 * @property int|null $transmission_id
 * @property int|null $fuel_type_id
 * @property int|null $engine_type_id
 * @property int|null $drive_train_id
 * @property int|null $primary_damage_id
 * @property int|null $secondary_damage_id
 * @property int|null $seller_id
 * @property int|null $buyer_id
 * @property int|null $auction_id
 * @property int|null $auction_vehicle_id
 * @property int|null $title_code_id
 * @property int|null $mileage_type_id
 * @property int|null $highlight_id
 * @property int|null $odometer
 * @property float|null $retail_value
 * @property int|null $selling_price
 * @property float|null $reserve_amount
 * @property float|null $start_bid_amount
 * @property string|null $sold_at
 * @property int|null $keys
 * @property string|null $note
 * @property string|null $rejection_note
 * @property string|null $vcc_document
 * @property string|null $thumbnail_image
 * @property int $status
 * @property bool|null $featured
 * @property string|null $handed_over_date
 * @property string|null $handed_over_to
 * @property string|null $handed_over_note
 * @property float|null $commission
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_active
 * @property-read int|null $runs
 * @property-read int|null $total_runs
 * @property-read mixed $gca_commission
 * @property-read string $product_name
 * @property-read string $title
 * @property-read string $title_with_vin
 * @property-read int|null $invoice_product_count
 * @property-read int|null $notifications_count
 * @property-read int|null $vehicle_images_count
 * @property-read int|null $watched_vehicles_count
 * @property-read \App\Models\User|null $salesExecutive
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 */
class Vehicle extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vin',
        'year',
        'make_id',
        'lot_number',
        'color_id',
        'vehicle_model_id',
        'vehicle_type_id',
        'sale_type',
        'body_style_id',
        'cylinder_id',
        'transmission_id',
        'fuel_type_id',
        'engine_type_id',
        'drive_train_id',
        'primary_damage_id',
        'secondary_damage_id',
        'seller_id',
        'buyer_id',
        'auction_id',
        'auction_vehicle_id',
        'location_id',
        'title_code_id',
        'mileage_type_id',
        'highlight_id',
        'odometer',
        'odometer_type',
        'retail_value',
        'selling_price',
        'sold_type',
        'sold_at',
        'reserve_amount',
        'start_bid_amount',
        'thumbnail_image',
        'vcc_document',
        'keys',
        'category_id',
        'note',
        'noted_by',
        'rejection_note',
        'status',
        'featured',
        'commission',
        'is_active',
        'handed_over_date',
        'sales_executive_id',
        'trim',
        'plan',
        'runs',
        'total_runs',
        'doc_approved',
        'doc_received',
        'handed_over_note',
        'handed_over_to',
        'document_type',
        'additional_status',
        'is_export',
        'passing_test',
        'allowed_runs',
        'allowed_listing_fee',
        'specification_id',
        'last_bid_amount',
        'suggested_serial',
        'skip_auction',
        'estimated_repair_price',
        'deleted_at',
    ];

    protected $casts = [
        'created_at'    => 'datetime',
        'featured'      => 'boolean',
        'selling_price' => 'integer',
    ];

    public static $LOT_SEARCH_AVAILABLE_FILTER = [
        'newly_added_vehicle',
        'odometer',
        'year',
        'sale_date',
        'vehicle_type_ids',
        'body_style_ids',
        'cylinder_ids',
        'drive_train_ids',
        'engine_type_ids',
        'fuel_type_ids',
        'location_ids',
        'transmission_ids',
        'model_ids',
        'make_ids',
    ];

    public function getTitleAttribute(): string
    {
        return strtoupper(sprintf('%s %s %s %s', $this->year, data_get($this, 'vehicle_make.name'),
            data_get($this, 'vehicle_model.name'), $this->trim));
    }

    public function getTitleWithVinAttribute(): string
    {
        return sprintf('%s %s %s(%s)', data_get($this, 'vehicle_make.name'),
            data_get($this, 'vehicle_model.name'), $this->year, $this->vin);
    }

    public function getProductNameAttribute(): string
    {
        return sprintf('%s %s %s(%s)', $this->year, data_get($this, 'vehicle_make.name'),
            data_get($this, 'vehicle_model.name'), $this->vin);
    }


    public function vehicle_images(): HasMany
    {
        return $this->hasMany(VehicleImage::class);
    }


    public function vehicle_type(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function body_style(): BelongsTo
    {
        return $this->belongsTo(BodyStyle::class);
    }

    public function cylinder(): BelongsTo
    {
        return $this->belongsTo(Cylinder::class);
    }

    public function vehicle_color(): BelongsTo
    {
        return $this->belongsTo(VehicleColor::class, 'color_id');
    }

    public function transmission(): BelongsTo
    {
        return $this->belongsTo(Transmission::class);
    }

    public function fuel_type(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }

    public function engine_type(): BelongsTo
    {
        return $this->belongsTo(EngineType::class);
    }

    public function drive_train(): BelongsTo
    {
        return $this->belongsTo(DriveTrain::class);
    }

    public function specification(): BelongsTo
    {
        return $this->belongsTo(Specification::class);
    }

    public function primary_damage(): BelongsTo
    {
        return $this->belongsTo(VehicleDamage::class, 'primary_damage_id');
    }

    public function secondary_damage(): BelongsTo
    {
        return $this->belongsTo(VehicleDamage::class, 'secondary_damage_id');
    }

    public function title_code(): BelongsTo
    {
        return $this->belongsTo(TitleCode::class);
    }

    public function mileage_type(): BelongsTo
    {
        return $this->belongsTo(MileageType::class);
    }

    public function highlight(): BelongsTo
    {
        return $this->belongsTo(Highlight::class);
    }


    public function vehicle_make(): BelongsTo
    {
        return $this->belongsTo(Make::class, 'make_id');
    }

    public function vehicle_model(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class);
    }

    public function auction_vehicles(): HasMany
    {
        return $this->hasMany(AuctionVehicle::class);
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
