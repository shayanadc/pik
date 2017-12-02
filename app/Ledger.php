<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ledger extends Model
{

    static function storeRows($array){
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
    static function filterBy($userId,$groupId = null){
        $ledgers = new Ledger();
        if($groupId != null){
            $billIds = Bill::where('group_id', $groupId)->get()->pluck('id');
            $ledgers = Ledger::whereIn('bill_no',$billIds);
        }
        return $ledgers->where(function($q) use ($userId){
                $q->where('creditor', $userId)->orWhere('owe', $userId);
            })->get();
    }
}