<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user List.
     *
     * @return \Illuminate\Http\Response
     *-----------------------------------------------------------------------------------------------------*/
        public function index()
        {
            $users=User::where('id','!=',Auth::user()->id)->paginate(15);;
            return view('home',compact('users'));
        }

        /**
     * Show the user profile.
     *
     * @return \Illuminate\Http\Response
     *-----------------------------------------------------------------------------------------------------*/
        public function profile()
        {
       
            $user = Auth::user();
            return view('profile',compact('user'));
        }

    
  /**
     * update user profile .
     * @param  \Illuminate\Http\Request  $request
     *-----------------------------------------------------------------------------------------------------*/
    public function updateprofile(Request  $request)
    {
        Session::flash('success', ' Profile  Updated!'); 
        $this->validate($request,[
            'first_name' => 'required|string|max:32',
            'last_name' => 'required|string|max:32',
            'phone'=>'required|numeric|digits:10',
            'email' => 'required|string|email|max:255|unique:users,email,'.Auth::user()->id,
        ]);

       $result= User::find(Auth::user()->id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone'=> $request->phone,
            'email' => $request->email,
        ]);
        if ($result) {
            Session::flash('success', ' Profile  Updated!'); 
        }else{
            Session::flash('error', 'Somthing Wrong !'); 
        } 
          return redirect('profile');

    }

  /**
     * Update profile Image .
     *
     *  @param  \Illuminate\Http\Request  $request
     *-----------------------------------------------------------------------------------------------------*/
    public function updateprofileimage(Request  $request)
    {
 
        $validation = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif'
           ]);

       if($validation->passes())
       {
            $user_id = Auth::user()->id;
            $request->file('file')->store('product', 'public');   
            $profile_picture=$request->file('file')->hashName();
            $isupdate=User::find($user_id)->update(['profile_picture' => $profile_picture]);
            if ($isupdate) {
            return response()->json('file upload'); 
            }else{
                return response()->json('file not upload');
            }
        }
        else
        {
            return response()->json([
            'message'   => $validation->errors()->all()
            ]);
        }     
      
    }









}
