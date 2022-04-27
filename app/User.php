<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Post;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function role()
    {
        return $this->belongsTo('App\Role');
    }
    public function posts()
    {
        return $this->hasMany('App\Post'); // ModelName of related model
    }
    public function favoritePosts()
    {
        return $this->belongsToMany('App\Post')->withTimestamps();
    }
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    public function scopeAuthors($query)
    {
        return $query->where('role_id', 2);
    }
}
