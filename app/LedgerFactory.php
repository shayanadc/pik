<?php
/**
 * Created by PhpStorm.
 * User: shayanadc
 * Date: 11/19/17
 * Time: 10:G3 AM
 */

namespace App;


class LedgerFactory
{

    /**
     * LedgerFactory constructor.
     */
    public function __construct()
    {
    }

    public function divide($amount, $members, $params)
    {
        $sharePerPerson = $amount / count($members);
        $owner = $params['bill_owner'];
        $owees = array_filter($members, function ($i) use ($owner) {
            return $i != $owner;
        });
        $output['bill_no'] = $params['bill_no'];
        $output['rows'] = array_map(function ($owee) use ($owner, $sharePerPerson) {
            return ['creditor' => $owner, 'owee' => $owee, 'amount' => $sharePerPerson];
        }, $owees);
        return $output;
    }

    public function divideAndStore($amount, $members, $params)
    {
        $x = $this->divide($amount, $members, $params);
        return Ledger::storeRow($x['rows']);
    }
}