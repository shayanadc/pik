<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ledger extends Model
{

    static function storeRow($array){
       return DB::table('ledgers')->insert($array);
    }
}