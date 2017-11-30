<?php
/**
 * Created by PhpStorm.
 * User: shayanadc
 * Date: 11/19/17
 * Time: 10:33 AM
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
        $output['rows'] = array_map(function ($owe) use ($owner, $sharePerPerson) {
            return ['creditor' => $owner, 'owe' => $owe, 'amount' => $sharePerPerson];
        }, $owees);
        return $output;
    }

    public function sort($arr)
    {
        return $arr['creditor'] > $arr['owe'] ?
            ['creditor' => $arr['owe'], 'owe' => $arr['creditor'], 'amount' => $arr['amount'] * -1] : $arr;
    }

    public function addition($carry, $item)
    {
        $key = $item['creditor'] . '-' . $item['owe'];
        if (isset($carry[$key])) {
            $carry[$key]['amount'] += $item['amount'];
        } else {
            $carry[$key] = $item;
        }
        return $carry;
    }

    public function reverse($item)
    {
        if ($item['amount'] < 0) {
            return ['creditor' => $item['owe'], 'owe' => $item['creditor'], 'amount' => $item['amount'] * -1];
        } else {
            return $item;
        }
    }

    public function calcStatus($arrays)
    {
        $sortArray = array_map([$this, 'sort'], $arrays);
        $additionArray = array_reduce($sortArray, [$this, 'addition'], []);
        return array_values(array_map([$this, 'reverse'], $additionArray));
    }
}