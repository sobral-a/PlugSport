<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    public $timestamps = false;
    protected $table = 'sport';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

}
