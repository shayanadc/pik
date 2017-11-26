<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name'];
    public static function entryNew($name){
    return static::create(['name' => $name]);
}
}
