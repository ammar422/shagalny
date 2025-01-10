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

    protected static function newFactory()
    {
        return \Modules\Codes\Database\factories\CodeFactory::new();
    }
}
