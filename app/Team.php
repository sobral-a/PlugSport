<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $timestamps = false;
    protected $casts = [
        'banned' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'banned'
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function players()
    {
        return $this->belongsToMany(User::class, 'user_team')->withPivot('status');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'team_event')->withPivot('status');
    }

    public function availabilities()
    {
        return $this->belongsToMany(User::class, 'availability')->withPivot('status', 'event_id');
    }

}
