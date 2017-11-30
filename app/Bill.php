<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['description', 'cost', 'user_id', 'group_id'];
    //todo: change func
    static function entryNew($array){
        return static::Create($array);
    }
    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
