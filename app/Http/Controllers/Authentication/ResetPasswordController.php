<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ResetPasswordController extends Controller
{
    public function index(){

        return view('Auth.passwords.reset');
    }
}
