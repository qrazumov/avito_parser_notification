<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'text', 'status', 'article_id', 'int_process'
    ];


}
