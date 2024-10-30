<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class CashierManagement extends Controller
{
    //
    public function display(){
        $cashiers = User::where('role', 'cashier')->get();
        return view('admin/admin-user_management', ['cashiers' => $cashiers]);
    }
     public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'role'=>'required',
            'password' => 'required|string|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/'
            ],[
                'password.regex' => 'The password must contain at least one letter, one number, and one special character.',
                
            
            ]
        );
    //if the password doesn't meet the requirements, return an error
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/', $data['password'])) {
        return redirect('/admin/user_management')->with('error', 'The password must contain at least one letter, one number, and one special character.');
    }
    //if the username already exists, return an error
    if (User::where('username', $data['username'])->exists()) {
        return redirect('/admin/user_management')->with('error', 'Username already exists. Please use a different username.');
    }
    else{
        User::create($data);
        return redirect('/admin/user_management')->with('success', 'Cashier Added');
           
    }


    }

    public function update(Request $request, string $id)
    {
        try{
            $cashiers = User::find($id);
            $cashiers->update($request->validate([
                'name' => 'required|string',
                'username' => 'required|string|unique:users,username,'.$id,
                'password' => 'required|string|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/'
            ],[
                'password.regex' => 'The password must contain at least one letter, one number, and one special character.',
            
            ]));
            return redirect('/admin/user_management')->with('success', 'Cashier Updated');
        }
        catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) { // MySQL error code for duplicate entry
                return redirect('/admin/user_management')->with('error', 'Duplicate entry for username. Please use a different username.');
            } else {
                // Handle other query exceptions or rethrow the exception
                throw $e;
            }
        }
    }
    public function destroy(string $id): RedirectResponse
    {
        User::destroy('delete from users where id = ?',[$id]);
        return redirect('/admin/user_management')->with('success', 'Account deleted!'); 
    }
    public function archive(string $id): RedirectResponse
    {
        $user = User::find($id);
        $user->archive = 1;
        $user->save();
        return redirect('/admin/user_management')->with('success', 'Account archived!'); 
    }
    public function restore(string $id): RedirectResponse
    {
        $user = User::find($id);
        $user->archive = 0;
        $user->save();
        return redirect('/admin/user_management')->with('success', 'Account restored!');
    }
   
}
