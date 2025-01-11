<?php

namespace Modules\Codes\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Code extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'duration',
        'status',
        'expire_at',
    ];


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            $model->code = $model->generateRandom15DigitNumber();
            $model->expire_at = $model->determineExpirationDate($model->duration);
        });
    }
    private  function generateRandom15DigitNumber()
    {
        return (string) rand(100000000000000, 999999999999999);
    }
    private function determineExpirationDate($duration)
    {
        switch ($duration) {
            case 'daily':
                return now()->addDay();
            case 'weekly':
                return now()->addWeek();
            case 'monthly':
                return now()->addMonth();
            case 'yearly':
                return now()->addYear();
            case 'life_time':
                return now()->addYears(100); // Adds 100 years for lifetime codes  
            default:
                throw new \InvalidArgumentException("Invalid duration: $duration");
        }
    }

    protected static function newFactory()
    {
        return \Modules\Codes\Database\factories\CodeFactory::new();
    }
}
