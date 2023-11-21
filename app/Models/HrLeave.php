<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrLeave extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'hr_leaves';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'tracking_code', 'leave_type_id', 'user_id',
        'days', 'date_from', 'date_to', 'is_with_pay', 'status', 'remarks',
        'date_approved', 'date_disapproved', 'date_cancelled', 'date_processing',
        'details_b1', 'details_b1_name', 'details_b2', 'details_b2_name', 'details_b3_name',
        'details_b4', 'details_b5', 'details_d1'
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
    }

    public function userPersonalInformations(){
        return $this->hasOne(UserPersonalInformation::class, 'user_id', 'user_id');
    }

    public function leaveType(){
        return $this->hasOne(LibLeaveType::class, 'id', 'leave_type_id');
    }
}
