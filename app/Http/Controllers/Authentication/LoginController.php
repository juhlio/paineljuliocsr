<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('Auth.login');
    }

    public function authenticate(Request $request)
    {
        $data = $request->only([
            'email',
            'password',
            'remember_token'
        ]);

        $validator = $this->validator($data);

        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::attempt($data)) {
            // Obtém o usuário autenticado
            $user = Auth::user();

            // Obtém as roles associadas ao usuário
            $roles = $user->roles;


            return redirect()->intended('/');
        } else {
            return back()->withErrors([
                'email' => 'Não foi possível logar.',
            ])->withInput();
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:4']
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
