<?php

namespace Bryanjack\Dash\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
	// protected $redirectTo = '/dash';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->redirectTo = env('DEFAULT_LOGIN', '/dash');
		$this->middleware('guest')->except('logout');
	}

	/* Additional handmade */
	
	public function showLoginForm(){
		return view('dash::user.login');
	}

	protected function credentials(Request $request)
	{
		$user = User::where('email', $request->email)->first();
		if ($user) {
			if ($user->status == 0) {
				return ['email' => 'inactive', 'password' => "Your user is inactive, please contact admin"];
			} else {
				return ['email' => $request->email, 'password' => $request->password, 'status' => 1];
			}
		}
		return $request->only($this->username(), 'password');
	}

	protected function sendFailedLoginResponse(Request $request)
	{
		// $errors = [$this->username() => trans('auth.failed')];
		$fields = $this->credentials($request);
		if ($fields['email'] == 'inactive') {
			$errors = $fields['password'];
		} else {
			$errors = [$this->username() => trans('auth.failed')];
		}

		if ($request->expectsJson()) {
			return response()->json($errors, 422);
		}

		return redirect()->back()
			->withInput($request->only($this->username(), 'remember'))
			->withErrors($errors);
	}
}
