<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPersonalInformation extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'user_personal_informations';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'user_id', 'firstname', 'middlename', 'lastname', 'ext_name',
        'date_of_birth', 'place_of_birth', 'sex', 'civil_status',
        'ra_house_no', 'ra_street', 'ra_subdivision', 'ra_brgy_code', 'ra_zip_code',
        'tel_no', 'mobile_no'
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
    }
}
