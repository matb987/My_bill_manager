<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bills as billsmodel;

class bills extends Controller
{
    //get all bills for current user and return view dashboard 
    public function index()
    {
        $bills = billsmodel::where('user_id', auth()->user()->id)->get();
        return view('dashboard', ['bills' => $bills]);
    }

    //create new bill for current user and return view dashboard
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required',
            'due_date' => 'required',
        ]);

        $bill = new billsmodel;
        $bill->name = $request->name;
        $bill->user_id = auth()->user()->id;
        $bill->amount = $request->amount;
        $bill->due_date = $request->due_date;
        $bill->save();

        return redirect('/dashboard');
    }

    
}
