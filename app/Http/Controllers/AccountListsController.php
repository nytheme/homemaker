<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccountList;
use App\User;

class AccountListsController extends Controller
{
    public function index()
    {
        $accountLists = AccountList::where('user_id', \Auth::id())->orderBy('created_at', 'desc')->get();
        $users = User::where('id', \Auth::id())->get();
        
        $data = [
            'accountLists' => $accountLists, 
            'users' => $users
        ];
        
        return view('accountLists', $data);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:191'
        ]);

        $accountLists = new AccountList;
        $accountLists->user_id = $request->user_id;
        $accountLists->name = $request->name;
        $accountLists->memo = $request->memo;
        $accountLists->switch = $request->switch;
        $accountLists->save();

        return redirect()->back();
    }
    
    public function destroy($id)
    {
        $accountLists = \App\AccountList::find($id);

        $accountLists->delete();

        return redirect()->back();
    }
    
    public function edit(Request $request, $id) {
        $accountLists = AccountList::find($id);
        return view('accountLists', ['accountLists' => $accountLists]);
    }
    
    public function update(Request $request, $id) {

        $accountLists = AccountList::find($id);
        $accountLists->switch = $request->switch;
        $accountLists->save();
 
        return redirect()->back();
    }
}
