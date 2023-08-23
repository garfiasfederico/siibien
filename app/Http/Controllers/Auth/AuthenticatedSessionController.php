<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\EnlaceDependencia;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.loginsiibien');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        
        //Obtenemos y seteamos variables de sesion del usuario
        $idUsuario = Auth::id();        
        $idEnlaceDependencia = User::select("idEnlaceDependencia")->where("id",$idUsuario)->first();
        $infoEnlace = EnlaceDependencia::select("*")->where("idEnlaceDependencia",$idEnlaceDependencia->idEnlaceDependencia)->first();                
        session([
            "idDependencia" => $infoEnlace->idDependencia,
            "enlace" => $infoEnlace->titulo." ".$infoEnlace->nombre." ".$infoEnlace->apellidoP." ".$infoEnlace->apellidoM,
            "idEnlaceDependencia" => $infoEnlace->idEnlaceDependencia            
        ]);
                
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
