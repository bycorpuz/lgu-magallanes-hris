<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibSignatory extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'lib_signatories';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'user_id', 'for',
        'param1_signatory', 'param1_designation',
        'param2_signatory', 'param2_designation',
        'param3_signatory', 'param3_designation'
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
    }
}
