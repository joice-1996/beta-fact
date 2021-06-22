<?php

namespace App\Modules\Login\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Department;
use App\User;
use Validator;
use File;
use Hash;
use Carbon\Carbon;
use Response;
use Config;
use Auth;
use Mail;

class LoginController extends Controller
{
       /**
    Laravel 6.0
    * @package onlineshopping
    * @author Joice Sara Joseph
    * @param 
    * @Date 21-06-2021
    * @module  login
    * Description: Login Form
    **/
   
    public function loginValidation(Request $request)
    {
        //return 1;
        $input=$request->all();
        $email=$input['email'];
        $password=$input['password'];
        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            if(Auth::user()->user_type == 'admin')
            {
                return "admin";
            }
        }

    }
    public function storeUser(Request $request)
    {
        $input=$request->all();
        //return $input;
        $date=date('Y-m-d');
        $time=date('H:i:s');
        $date=$date."T".$time;
        $query=User::insert([
            'name'=>$input['name'],
            'phone'=>$input['phone'],
            'email'=>$input['email'],
            'gender'=>$input['gender'],
            'password'=>Hash::make($input['password']),
            'created'=>$date,
            'user_type'=>'user',
            'status'=>1
        ]);
        if($query)
        {
            
        $data["email"]=$input['email'];
        $data["user_name"]=$input['name'];
        $data["subject"]='Welcome To Online Shopping';

        
        //Sending Mail to the corresponding user

        Mail::send([], $data, function($message)use($data) {
        $message->to($data["email"], $data["user_name"])
        ->subject($data["subject"])
        
        ->setBody('Hi, welcome user!');
        });
        }
        return "success";
       
    }
    
}
