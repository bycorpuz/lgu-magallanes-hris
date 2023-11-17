<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrLeaveCreditsAvailableList extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'hr_leave_credits_available_list';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'leave_credits_available_id', 'month', 'year', 'value',
        'date_from', 'date_to', 'remarks'
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
    }
}
