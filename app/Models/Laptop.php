<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    protected $table = 'laptops';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'price',
        'release_date',
        'site_link',
        'image_link',
        'page_score',

        'model',
        'processor',
        'graphic_card',
        'memory',
        'storage',
        'display'
    ];
}
