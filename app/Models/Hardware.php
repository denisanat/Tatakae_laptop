<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    protected $table = 'hardware';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'hardware_type',
        'score'
    ];
}
