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
        $left_to_pay = $bills->sum('amount') - $bills->where('paid_date', '!=', null)->sum('amount');
        return view('dashboard', ['bills' => $bills , 'left_to_pay' => $left_to_pay]);
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

    //function to add paid date as current date for bill

    public function paid($id)
    {
        $bill = billsmodel::find($id);
        $bill->paid_date = date('Y-m-d');
        $bill->save();

        return redirect('/dashboard');
    }

    //reset paid date for all bills for current user
    public function reset()
    {
        $bills = billsmodel::where('user_id', auth()->user()->id)->get();
        foreach ($bills as $bill) {
            $bill->paid_date = null;
            $bill->save();
        }

        return redirect('/dashboard');
    }
    // delete bill
    public function delete($id)
    {
        $bill = billsmodel::find($id);
        $bill->delete();

        return redirect('/dashboard');
    }
    
}
