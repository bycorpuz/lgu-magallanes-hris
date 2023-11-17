<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibLeaveType extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'lib_leave_types';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'abbreviation', 'name', 'description', 'days',
        'unit', 'is_with_pay'
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
    }
}
