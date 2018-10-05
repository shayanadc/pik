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
   static function filterBy($userId,$groupId = null, $between = null){
       //Todo: if you are not in this group throw exception
       $ledgers = new Ledger();
        $fLedger = $ledgers->userFilter($userId);
        if($groupId != null){
            $billIds = Bill::groupFilter($groupId)->get()->pluck('id');
            $fLedger = $fLedger->whereIn('bill_no', $billIds);
            if($between != null){
                $fLedger = $fLedger->userFilter($between);
            }
            return $fLedger->get();
        }
        return $fLedger->get();
   }
}