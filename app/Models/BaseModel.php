<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model
{

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            if (Schema::hasColumn($model->getTable(), 'created_by')) {
                if (Auth::check() && !$model->created_by) {
                    $model->created_by = auth()->user()->id;
                }
            }
        });

        static::updating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'created_by')) {
                if (Auth::check() && !$model->updated_by) {
                    $model->updated_by = auth()->user()->id;
                }
            }
        });
    }

}
