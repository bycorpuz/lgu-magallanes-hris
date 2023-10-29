<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'general_settings';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'site_name',
        'site_email',
        'site_phone',
        'site_meta_keywords',
        'site_meta_description',
        'site_logo',
        'site_favicon',
        'facebook_url',
        'twitter_url',
        'youtube_url',
        'instagram_url'
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
    }
}
