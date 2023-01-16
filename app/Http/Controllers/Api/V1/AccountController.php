<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Http\Resources\V1\AccountResource;
use App\Http\Resources\V1\AccountCollection;
use App\Http\Requests\V1\StoreAccountRequest;
use App\Http\Requests\V1\UpdateAccountRequest;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::where(['user_id' => auth()->user()->id])
                            ->orderBy('id');
        return new AccountCollection($accounts->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAccountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountRequest $request)
    {
        return (new AccountResource(Account::create($request->all())))
                    ->additional(['message' => 'Account added!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        return new AccountResource($account);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAccountRequest  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        return $account->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Account::destroy($id)) {
            return response()->json([
                'status' => 1,
                'message' => 'Account deleted!'
            ]);
        }
        else {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to delete!'
            ]);
        }
    }
}
