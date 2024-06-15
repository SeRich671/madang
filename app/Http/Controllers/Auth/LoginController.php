<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectTo = config('app.url');
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request): array
    {
        // the value in the 'email' field in the request
        $username = $request->get($this->username());

        // check if the value is a validate email address and assign the field name accordingly
        $field = filter_var($username, FILTER_VALIDATE_EMAIL) ? $this->username()  : 'login';

        // return the credentials to be used to attempt login
        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
        ];
    }
}
