<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use App\Notifications\Emailverify;
use Session;


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
    protected $redirectTo = '/home';

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
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:32',
            'last_name' => 'required|string|max:32',
            'phone'=>'required|numeric|digits:10',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'profile' => 'mimes:jpeg,jpg,png,gif|required|',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $data['profile']->store('product', 'public');      
             $user= User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'profile_picture' => $data['profile']->hashName(),
            'password' => bcrypt($data['password']),
            'verifytoken' =>Str::random(30),
        ]); 

         $user->notify(new Emailverify(['id'=>$user->id,'email'=>$user->email,'token'=>$user->verifytoken]));
         return $user;
             
    }
    
    /**
     * Create  verifyEmailFirst.
     *  Load a blade  for Email verify 
     * @return \Illuminate\Http\Response
     * ----------------------------------------------------------------------------------------------------------*/

    public function verifyEmailFirst()
    {
        return view('email.verifyEmailFirst');
    }

  /**
     * Create verification.
     *    Verify Email
     *  @param  email
     *  @param  code(token)
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------------------------------------------- */
    public function verification($email,$code)
    {     
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($code)!=30 ) {
          return "Invalid Url format ";
          Session::flash('error', 'Invalid Url format ');  
          
        }
    
        $user=User::where('email','=',$email)->where('verifytoken','=',$code)->first();
        if ($user) {
           $isupdated= User::where('email','=',$email)->where('verifytoken','=',$code)->update(['status'=>1,'verifytoken'=>null]); 
           if ($isupdated) { 
            Session::flash('success', ' Profile  Updated!');    
           }else{
           Session::flash('error', 'Oop !! Something Wrong !!');  
           }}
        else{
            Session::flash('error', 'User not found !!');                      
        }
        return redirect('login');

      

    }



}
