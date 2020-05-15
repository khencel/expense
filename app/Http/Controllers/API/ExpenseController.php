<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Expenses;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Expenses::with('category')->where('user_id',\Auth::user()->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expense = request()->validate([
            'category_id' => 'required',
            'amount' => 'required',
            'entry_date' => 'required'
        ]);

        Expenses::create(['user_id' => \Auth::user()->id]+$expense);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Expenses::find($id);
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
        $expense = request()->validate([
            'category_id' => 'required',
            'amount' => 'required',
            'entry_date' => 'required'
        ]);

        Expenses::find($id)->update($expense);
    }

    /**
     * Remove the specified resource from storage.
     *p
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Expenses::find($id)->delete();
    }
}
