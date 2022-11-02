<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResetPasswodController extends Controller
{
    public function sendPasswordResetEmail(Request $request){

        if (!$this->validateEmail($request->email)){
            return $this->failedResponse();
        }

        $this->sendEmail($request->email);
        
        return $this->successsResponse();
    }

    public function validateEmail($email){
        return !!User::where('email', $email)->first();
    }

    public function failedResponse(){
        return response()->json(['message' => 'Email doesn\'t found on our database'], Response::HTTP_NOT_FOUND);
    }

    public function sendEmail($email){

        $token = $this->generateToken($email);
        Mail::to($email)->send(new ResetPasswordMail($token));
    }

    public function generateToken($email){
        $isOtherToken = DB::table('password_resets')->where('email', $email)->first();
  
        if($isOtherToken) {
          return $isOtherToken->token;
        }
  
        $token = Str::random(80);
        $this->storeToken($token, $email);
        return $token;
      }

      public function storeToken($token, $email){
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()            
        ]);
    }

    public function successsResponse(){
        return response()->json(['message' => 'Reset Email is send successfully, please check your inbox.'], Response::HTTP_OK);
    }

}
