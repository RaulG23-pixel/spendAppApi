<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::all();
        return response(["response" => "OK", "expenses" => compact('expenses')], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'register' => 'required',
            'userd_id' => 'required'
        ]);

        $data = $request->all();

        Expense::create($data);
        return response(["response" => "Expense created successfully"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::where('id', $id)->firstOrFail();
        if (!isset($expense)) {
            return response(['response' => 'Element not found'], 404);
        }

        return response(["response" => "OK", 'expense' => compact('expense')], 200);
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
        $request->validate([
            'name' => 'required|max:255',
            'register' => 'required',
            'userd_id' => 'required'
        ]);

        $expense = Expense::where('id', $id)->firstOrFail();
        if (!isset($expense)) {
            return response(['response' => 'Element not found'], 404);
        }

        $expense->update($request->all());
        return response(["response" => "Element updated successfully", 'expense' => $expense], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Expense::destroy($id);
        return response(["response" => "Element deleted sucessfully"], 200);
    }
}
