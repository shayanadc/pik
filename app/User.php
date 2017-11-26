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
    static function entryNew($array){
        return static::Create($array);
    }
    static function findWith($array){
        $key = key($array);
        $value = $array[$key];
        return static::where($key,$value)->first();
    }
    static function registerOrFind($array){
        $exist = static::findWith($array);
        if($exist){
            return $exist;
        }
        return static::entryNew($array);
    }
    public function sum($x,$y){
        return $x + $y;
    }
}
