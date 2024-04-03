<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller{
    public function login(LoginRequest $request){
        $request->validated();
        if(Auth::attempt(["username"=>$request->username,"password"=>$request->password])){
            $user = Auth::user();
            if($user->status === 0){
                return response()->json(["message"=>"Your account is inactive"],401);
            }else{
                $user->tokens()->delete();                
                $department = $user->department->name;
                $user = $user->makeHidden("password","email_verified_at","created_at","updated_at","salary","bank","IBAN","part_time","type","status","unemployment_date","birthday","ID_image","license_image","otp","start_date","Duration_contract","ID_no","department_id","company_id");
                $user->departments  = $department;
                $user->company;
                if ($user->image)$user->image = 'https://'.request()->getHttpHost().'/storage/profile/'.$user->image;
                $user->token = $user->createToken($request->userAgent())->plainTextToken;
                $user = collect($user)->map(function ($value, $key) {
                    if($key == "sick_vacation"|| $key == "annual_vacation")$value =0;
                    return is_null($value) ? '' : $value;
                })->toArray();
                return response()->json(["success"=>true,"user"=>$user],200);
            }
        }else{
            return response()->json(["message"=>"The username or password is incorrect please try again"],401);
        }
    }
    public function logout(Request $request){
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json(["message"=>"logout successfuly"],200);
    }
}
