<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserScore extends Model
{
    protected $table = 'user_scores';
    public $timestamps = false;
    protected $fillable = ['user_id', 'laptop_id', 'score'];
}
