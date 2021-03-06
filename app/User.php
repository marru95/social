<?php

namespace App;

use App\Models\Status;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['avatar'];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function link()
    {
       return route('users.show', $this);
    }

    public function avatar()
    {
        return 'https://image.shutterstock.com/image-vector/people-icon-vector-user-symbol-600w-1714434235.jpg';
    }

    public function statuses(){

        return $this->hasMany(Status::class);
    }
    public function getAvatarAttribute()
    {
        return $this->avatar();
    }



}
