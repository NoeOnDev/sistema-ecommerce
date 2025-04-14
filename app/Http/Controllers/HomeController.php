<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Maneja la redirección a la página principal según el estado de autenticación y rol
     */
    public function index()
    {
        // Si el usuario está autenticado
        if (Auth::check()) {
            // Verificar el rol y redirigir al dashboard correspondiente
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('client.dashboard');
            }
        }

        // Si no está autenticado, mostrar la vista de invitado
        return view('guest.home');
    }

    /**
     * Muestra el dashboard del administrador
     */
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Muestra el dashboard del cliente
     */
    public function clientDashboard()
    {
        return view('client.dashboard');
    }
}
