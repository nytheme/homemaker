<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Expense;
use App\User;

class ExpensesController extends Controller
{
    public function indexShow_exp()
    {   
        $today = date("Y/m/d");
        $this_month_1st = date("Y/m/01");
        $this_month_last = date("Y/m/t");
        //$sum = Expense::where('user_id', \Auth::id())->where('day', '>=', $this_month_1st)->where('day', '<=', $today)->sum("money");
        $this_month_sum = Expense::where('user_id', \Auth::id())->whereBetween('day', [$this_month_1st, $this_month_last])->sum("money");
        $expenses = Expense::where('user_id', \Auth::id())->whereBetween('day', [$this_month_1st, $this_month_last])->orderBy('day', 'desc')->get();
        $users = User::where('id', \Auth::id())->get();
        //チャート用の変数
        $food =  Expense::where('user_id', \Auth::id())->where('category','食費')->whereBetween('day', [$this_month_1st, $this_month_last])->sum("money");
        $medical = Expense::where('user_id', \Auth::id())->where('category','保険・医療')->whereBetween('day', [$this_month_1st, $this_month_last])->sum("money");
        $fixed = Expense::where('user_id', \Auth::id())->where('category','固定費')->whereBetween('day', [$this_month_1st, $this_month_last])->sum("money");
        $clothes = Expense::where('user_id', \Auth::id())->where('category','衣類')->whereBetween('day', [$this_month_1st, $this_month_last])->sum("money");
        $pocket = Expense::where('user_id', \Auth::id())->where('category','小遣い')->whereBetween('day', [$this_month_1st, $this_month_last])->sum("money");
        $daily = Expense::where('user_id', \Auth::id())->where('category','日用品')->whereBetween('day', [$this_month_1st, $this_month_last])->sum("money");
        $outdoor = Expense::where('user_id', \Auth::id())->where('category','レジャー')->whereBetween('day', [$this_month_1st, $this_month_last])->sum("money");
        $others = Expense::where('user_id', \Auth::id())->where('category','その他')->whereBetween('day', [$this_month_1st, $this_month_last])->sum("money");
        
        //カレンダー用
        $day_sum_totals = Expense::where('user_id', \Auth::id())->whereBetween('day', [$this_month_1st, $this_month_last])->get();
        
        $data = [
            'expenses' => $expenses, 
            'users' => $users,
            'this_month_sum' => $this_month_sum,
            //チャート用の変数
            'food' => $food,
            'medical' => $medical,
            'fixed' => $fixed,
            'clothes' => $clothes,
            'pocket' => $pocket,
            'daily' => $daily,
            'outdoor' => $outdoor,
            'others' => $others,
            
            'day_sum_totals' => $day_sum_totals
        ];
        
        return view('show_exp', $data);
    }
    
    public function indexWrite_exp()
    {
        $users = User::where('id', \Auth::id())->get();
        
        $data = [
            'users' => $users
        ];
        
        return view('write_exp', $data);
    }
    
    public function indexPast_exp()
    {   
        $today = date("Y/m/d");
        $this_month_1st = date("Y/m/01");
        $this_month_last = date("Y/m/t");
        //$sum = Expense::where('user_id', \Auth::id())->where('day', '>=', $this_month_1st)->where('day', '<=', $today)->sum("money");
        $this_month_sum = Expense::where('user_id', \Auth::id())->whereBetween('day', [$this_month_1st, $this_month_last])->sum("money");
        $expenses = Expense::where('user_id', \Auth::id())->whereBetween('day', [$this_month_1st, $this_month_last])->orderBy('day', 'desc')->get();
        $users = User::where('id', \Auth::id())->get();
        
        $data = [
            'expenses' => $expenses, 
            'users' => $users,
            'this_month_sum' => $this_month_sum,
        ];
        
        return view('past_exp', $data);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'money' => 'required|max:191'
        ]);

        $expenses = new Expense;
        $expenses->user_id = $request->user_id;
        $expenses->category = $request->category;
        $expenses->name = $request->name;
        $expenses->money = $request->money;
        $expenses->day = $request->day;
        $expenses->save();

        return redirect()->back();
    }
    
    public function destroy($id)
    {
        $expenses = \App\Expense::find($id);

        $expenses->delete();

        return redirect()->back();
    }
    
        public function indexCalendar()
    {   
        $today = date("Y/m/d");
        $this_month_1st = date("Y/m/01");
        $this_month_last = date("Y/m/t");
        $this_month_sum = Expense::where('user_id', \Auth::id())->whereBetween('day', [$this_month_1st, $this_month_last])->sum("money");
        $expenses = Expense::where('user_id', \Auth::id())->whereBetween('day', [$this_month_1st, $this_month_last])->orderBy('day', 'desc')->get();
        $users = User::where('id', \Auth::id())->get();
        
        $data = [
            'expenses' => $expenses, 
            'users' => $users,
            'this_month_sum' => $this_month_sum,
        ];
        
        return view('calendar', $data);
    }
}
