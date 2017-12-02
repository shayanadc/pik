<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name'];

    public static function createNew($name)
    {
        return static::create(['name' => $name]);
    }
    public function bills(){
       return $this->hasMany(Bill::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
