<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class EditController extends Controller
{
    public function index()
    {
        $users = User::where('id',\Auth::user()->id)->get();
        
        $data = [
            'users' => $users,
        ];
        
        return view('edit', $data);
    }
    
    public function edit(Request $request, $id) {
        $users = User::find($id);
        return view('edit', ['users' => $users]);
    }
    
    public function update(Request $request, $id) {

        $users = User::find($id);
        $users->name = $request->name;
        $users->budget = $request->budget;
       
        $users->save();
 
        return redirect('show_exp');
    }
}
