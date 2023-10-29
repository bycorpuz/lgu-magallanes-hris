<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'user_logs';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'module',
        'action',
        'data',
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
    }
}
