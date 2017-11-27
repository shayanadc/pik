<?php

namespace App;

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
    protected $fillable = [
        'name',
        'surname',
        'telegram_id',
        'telegram_username',
        'phone_no'
//        'email',
//        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
//        'password', 'remember_token',
    ];
    static function findOrMakeNew($array){
        return static::firstOrCreate($array);
    }
    public function sum($x,$y){
        return $x + $y;
    }
}
