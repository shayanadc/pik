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
    private $legendFactory;
    public function __construct()
    {
        $this->legendFactory = new LedgerFactory();
    }
    public function addBillNoToRows($ledger){
        $ledgerRow = $ledger['rows'];
        $billNo = $ledger['bill_no'];
        return array_map(function($item) use ($billNo){
            return ['creditor' => $item['creditor'], 'owe' => $item['owe'], 'amount' => $item['amount'], 'bill_no' => $billNo];
        },$ledgerRow,[]);
    }

    public function divideAndStoreBillInLedger($amount, $members, $params){
        $ledger = $this->legendFactory->divide($amount,$members,$params);
        $rows = $this->addBillNoToRows($ledger);
        Ledger::storeRows($rows);
        return $ledger;
    }

}