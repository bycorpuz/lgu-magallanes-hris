<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrPlantilla extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'hr_plantillas';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'item_number', 'user_id', 'position_id', 'salary_id',
        'status', 'remarks', 'is_plantilla', 'division_office'
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
    }

    public function position(){
        return $this->hasOne(LibPosition::class, 'id', 'position_id');
    }

    public function salary(){
        return $this->hasOne(LibSalary::class, 'id', 'salary_id');
    }
}
