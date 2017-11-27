<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['description', 'cost', 'user_id', 'group_id'];
    static function entryNew($array){
        return static::Create($array);
    }
    public function group(){
        return $this->belongsTo(Group::class);
    }
}
