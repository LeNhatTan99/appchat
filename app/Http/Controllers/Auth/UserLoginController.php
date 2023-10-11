<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserLoginController extends Controller
{
       /**
     * show form login with user.
     *
     * @return void
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Login with user
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:8'
        ]);
        if (\Auth::attempt($request->only(['email','password']), $request->get('remember'))){
            return redirect()->route('user.dashboard');
        }
        return back()->with('message', __('auth.email-or-password-is-incorrect'));
    }


     /**
     *  logout user
     *
     * @return RedirectResponse
     */
    public function logout() {      
        \Auth::logout();
        return redirect()->route('login');
    }

}
