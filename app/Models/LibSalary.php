<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibSalary extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'lib_salaries';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'tranche', 'grade', 'step', 'basic'
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
    }
}
