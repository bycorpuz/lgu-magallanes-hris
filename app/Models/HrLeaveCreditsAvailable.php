<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrLeaveCreditsAvailable extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'hr_leave_credits_available';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'leave_type_id', 'user_id', 'available', 'used', 'balance'
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
    }

    public function leaveType(){
        return $this->hasOne(LibLeaveType::class, 'id', 'leave_type_id');
    }
}
