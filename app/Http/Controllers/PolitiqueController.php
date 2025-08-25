<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolitiqueController extends Controller
{
    /**
     * Affiche la politique de location
     *
     * @return \Illuminate\View\View
     */
    public function politiqueLocation()
    {
        return view('politiquelocation');
    }

    /**
     * Affiche la politique d'annulation
     *
     * @return \Illuminate\View\View
     */
    public function politiqueAnnulation()
    {
        return view('politiqueannulation');
    }
}