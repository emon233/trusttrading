<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    

    protected function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:500',
            'password' => 'required|string|min:6|confirmed',
            'type' => 'required|string',
        ]);
        
        try
        {
            $validatedData['password'] = bcrypt(array_get($validatedData, 'password'));
            $validatedData['status'] = 0;
            $user = app(User::class)->create($validatedData);
        }
        catch(\Exception $ex)
        {
            logger()->error($ex);
            return redirect()->back()->with('message', 'Unable to create new user.');
        }

        return redirect()->back()->with('message', 'Successfully created a new account. Please wait for confirmation.');
    }
}
