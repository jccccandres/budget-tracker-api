<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\V1\TransactionResource;
use App\Http\Resources\V1\TransactionCollection;
use App\Http\Requests\V1\StoreTransactionRequest;

use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->query();
        // $transactions = Transaction::where(['user_id' => auth()->user()->id]);

        // if (!empty($params['date'])) {
        //     $transactions->whereBetween('date_transact', [date('Y-m-01', strtotime($params['date'])), date('Y-m-t', strtotime($params['date']))]);
        // }

        // return new TransactionCollection($transactions->get());

        $transactions = Transaction::where(['user_id' => auth()->user()->id])
                            ->whereBetween('date_transact', [date('Y-m-01', strtotime($params['date'])), date('Y-m-t', strtotime($params['date']))])
                            ->orderBy('date_transact', 'DESC')
                            ->get()
                            ->groupBy(
                                function($val) {
                                    return Carbon::parse($val->date_transact)->format('F j, Y');
                                }
                            )->map(function($group) {
                                return [
                                    'sum' => $group->sum('amount'),
                                    'transactions' => new TransactionCollection($group)
                                ];
                            });
        return $transactions;
    }                           

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionRequest $request)
    {
        $data = $request->all();
        if ($data['typeId'] == 2 || $data['typeId'] == 3) {
            $data['amount'] *= -1;
        }

        return (new TransactionResource(Transaction::create($data)))
                        ->additional(['message' => 'Transaction added!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransactionRequest  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function transactionMonths()
    {
        return Transaction::getTransactionMonths();
    }
}
