<?php

namespace App\Http\Controllers\Authentication;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PasswordController extends Controller
{
    public function index(){

        return view('auth.passwords.reset')->with(
            
        );
    }
}