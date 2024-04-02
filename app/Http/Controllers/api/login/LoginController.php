<?php

namespace App\Http\Controllers\api\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\User;
use Exception;
use GrahamCampbell\ResultType\Success;
use Illuminate\Auth\Events\Validated;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation;
class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $this->validate($request,[
                "username"=>"required|min:3|max:255",
                "password"=>"required|min:6",
            ]);
        } catch (Exception $e) {
            return response()->json(["error"=>$e->getMessage()],400);
        }
        if (auth()->attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = User::where('username', $request->username)->first();
            $id = $user->id;
            $name = $user->name;
            $email = $user->email;
            $department =  $user->department->name;
            $position = $user->position;
            $status = $user->status;
            $company_id = $user->company_id;
            $company = Company::where('id', $company_id)->first();
            if ($company) {
                $company_name = $company->name;
                $company_lat = $company->latitude;
                $company_long = $company->longitude;
                $max_distance = $company->max_distance;
            }
            $img = '';
            if ($user->image != '') {
                $img = 'https://'.request()->getHttpHost().'/storage/profile/'.$user->image;
            }
            $token =$user->createToken("auth-token")->plainTextToken;
            return response()->json([
                "token"=>$token,
                'message' => 'Login successful', "status" => 200, "ID" => $id, "name" => $name,
                "username" => $request->username,
                "email" => $email,
                "department" => $department,
                "image" => $img,
                "UserStatus" => $status, "company_name" => $company_name,
                "latitude" => $company_lat, "longitude" => $company_long,
                'max_distance' => $max_distance
            ],200);
        }else{
            return response()->json(["error"=>"the password or username is incorrect please try again"],404);
        }
    }
    public function sendOtp(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'id' => 'required',
        ]);
        $email = $request->input('email');

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email address.',
                'email' => $email
            ], 400);
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        $id = $request->input('id');

        // Send OTP via email

        Mail::raw("Your OTP is: $otp", function ($message) use ($email) {
            $message->to($email)
                ->subject('One-Time Password (OTP)');
        });



        User::where('id', $id)
            ->update([
                'email' => $email,
                'otp' => $otp
            ]);

        // Store the OTP in the session


        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully.',
        ], 200);
    }

    public function verifyOtp(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP.',
            ], 400);
        }

        // Verify the OTP
        $otp = $request->input('otp');

        // Retrieve the stored OTP from the session


        $id = $request->input('id');

        $user = User::find($id);
        $storedOtp = $user->otp;

        if (!$storedOtp || $otp != $storedOtp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP.',


            ], 400);
        }

        // OTP is valid, perform further actions or return success response
        // For example, update the user as verified, log in the user, etc.

        // Clear the OTP from the session
        $user->otp = '';
        $user->status = 1;
        $user->save();


        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully.',

        ], 200);
    }
}
