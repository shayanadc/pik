<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'creator_id'];

    public static function createNew($name, $creatorId)
    {
        return static::create(['name' => $name,'creator_id' => $creatorId]);
    }
    public function bills(){
       return $this->hasMany(Bill::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
