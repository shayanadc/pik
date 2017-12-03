<?php
/**
 * Created by PhpStorm.
 * User: shayanadc
 * Date: 12/3/17
 * Time: 4:31 PM
 */

namespace App;


class LedgerBoundary
{
   static function filterBy($userId,$groupId = null){
       $ledgers = new Ledger();
       if($groupId != null){
           $billIds = Bill::groupFilter($groupId)->get()->pluck('id');
           $ledgers = Ledger::whereIn('bill_no', $billIds);
       }
       return $ledgers->userFilter($userId)->get();
   }
}