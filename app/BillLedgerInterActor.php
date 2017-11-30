<?php
/**
 * Created by PhpStorm.
 * User: shayanadc
 * Date: 11/30/17
 * Time: 4:24 PM
 */

namespace App;


class BillLedgerInterActor
{
    public function divideAndStoreBillInLedger($amount, $members, $params){
        $new = new LedgerFactory();
        $ledger = $new->divide($amount,$members,$params);
        $ledgerRow = $ledger['rows'];
        $billNo = $ledger['bill_no'];
        $rows = array_map(function($item) use ($billNo){
            return ['creditor' => $item['creditor'], 'owe' => $item['owe'], 'amount' => $item['owe'], 'bill_no' => $billNo];
        },$ledgerRow,[]);
        Ledger::storeRow($rows);
        return $ledger;
    }

}