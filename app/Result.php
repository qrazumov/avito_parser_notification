<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'filter_id', 'title', 'desc', 'link', 'phone', 'price', 'src', 'status', 'ads_id'
    ];
}
