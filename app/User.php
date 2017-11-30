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
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
    public function bills(){
        return $this->hasMany(Bill::class,'owner');
    }
    public function creditors(){
        return $this->hasMany(Ledger::class,'creditor','id');
    }
    public function owes(){
        return $this->hasMany(Ledger::class,'owe','id');
    }
}
