<?php

namespace App\Http\Controllers;

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
use GrahamCampbell\ResultType\Success;

class TransferController extends Controller
{

    public function transfer(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->input('id');
            $user = User::findOrFail($id);
            if ($user) {
                auth()->login($user);
                return redirect()->intended('/dashboard');
            } else {
                return redirect()->route('login');
            }
        } else {
            return redirect()->route('login');
        }
    }
}
