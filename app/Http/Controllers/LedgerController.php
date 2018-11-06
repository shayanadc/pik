<?php

namespace App\Http\Controllers;

use App\Bill;
use App\BillLedgerInterActor;
use App\Ledger;
use App\LedgerBoundary;
use App\LedgerFactory;
use App\User;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lB = new LedgerBoundary();
        $ledger = $lB->filterBy($request->get('user'),$request->get('group'),$request->get('friend'));
        if($request->has('calc')){
            $calc = new  LedgerFactory();
            return $calc->calcStatus($ledger->toArray());
        }
        if ($request->has('ledger')){
            $calc = new  LedgerFactory();
            $ledger =  $calc->getLedgerStatus($ledger->toArray());
            if($request->has('user')){
                $newList = [];
                foreach ($ledger['owe'] as $k => $value){
                    if($value  != $request->input('user')){
                        $newList['owe'][] = User::find($value)->toArray();
                    }
                }
                foreach ($ledger['creditor'] as $k => $value){
                    if($value  != $request->input('user')){
                        $newList['creditor'][] = User::find($value)->toArray();
                    }
                }
                $ledger = $newList;
            }
        }
        return $ledger;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bill = Bill::find($request->input('bill_id'));
        $params = ['bill_owner' => $bill->owner, 'bill_no' => $bill->id];
        $ledger = new BillLedgerInterActor();
        return $ledger->divideAndStoreBillInLedger($bill->cost,$request->input('members'),$params);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ledger = Ledger::find($id);
        $ledger->update(['settle' => $request->input('settle')]);
        return $ledger;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
