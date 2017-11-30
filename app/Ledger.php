<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ledger extends Model
{

    static function storeRow($array){
       return DB::table('ledgers')->insert($array);
    }
    public function bill(){
        return $this->belongsTo(Bill::class,'bill_no');
    }
    public function creditorUser(){
        return $this->belongsTo(User::class,'creditor');
    }
    public function oweUser(){
        return $this->belongsTo(User::class,'owe');
    }
    public function getDescriptionAttribute(){
        return $this->bill->description;
    }
}