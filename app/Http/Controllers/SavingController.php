<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saving;

class SavingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $savings = Saving::all();
        return response(["response" => "OK", "savings" => $savings], 200);
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
            "name" => "required|max:255",
            "register" => "required|json",
            "color" => "required",
            "user_id" => "required|integer"
        ]);
        $data = $request->all();
        $storedData = Saving::create($data);
   
        return response(["response" => "Expense created successfully","storedData" => $storedData], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $saving = Saving::where('id', $id)->firstOrFail();
        if (!isset($saving)) {
            return response(['response' => 'Element not found'], 401);
        }

        return response(["response" => "OK", 'saving' => $saving], 200);
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

        $saving = Saving::where('id', $id)->firstOrFail();
        if (!isset($saving)) {
            return response(['response' => 'Element not found'], 404);
        }

        $saving->update($request->all());
        return response(["response" => "Element updated successfully", 'saving' => $saving], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Saving::destroy($id);
        return response(["response" => "Element deleted sucessfully"], 200);
    }
}
