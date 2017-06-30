<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Event;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;
    protected $casts = [
        'isAdmin' => 'boolean',
        'wantsRappel' => 'boolean'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'profil'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function inTeams()
    {
        return $this->belongsToMany(Team::class, 'user_team')->withPivot('status');
    }

    public function inTeamAccepted()
    {
        return $this->belongsToMany(Team::class, 'user_team')->wherePivot('status', 'player');
    }
}
