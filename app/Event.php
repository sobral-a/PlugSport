<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $casts = [
        'isAdmin' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'adresss', 'teams_number', 'date', 'description'
    ];

    public function sport()
    {
      return $this->belongsTo(Sport::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
