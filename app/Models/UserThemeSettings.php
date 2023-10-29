<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserThemeSettings extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'user_theme_settings';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'theme_style',
        'header_color',
        'sidebar_color',
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
    }
}
