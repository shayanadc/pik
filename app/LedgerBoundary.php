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
   static function filterBy($userId, $groupId = null, $between = null){
       //Todo: if you are not in this group throw exception
       $ledgers = new Ledger();
       $fLedger = $ledgers->userFilter($userId);
       if($between){
           $fLedger = $fLedger->userFilter($between);
       }
        if($groupId) {
            $billIds = Bill::groupFilter($groupId)->get()->pluck('id');
            $fLedger = $fLedger->whereIn('bill_no', $billIds);
        }

        return $fLedger->where('settle',false)->get();
   }
}