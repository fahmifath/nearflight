<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Airport;

class HomeController extends Controller
{
    /**
     * Display the landing page.
     */
    public function landing()
    {
        // Get popular routes/flights
        $popularFlights = Flight::limit(6)->get();
        
        // Get all airports for destination suggestions
        $airports = Airport::all();
        
        // Statistics for the landing page
        $stats = [
            'passengers' => 50000,
            'routes' => 150,
            'flights_daily' => 500,
            'airlines' => 20
        ];
        
        return view('landing.index', compact('popularFlights', 'airports', 'stats'));
    }

    /**
     * Display the home/index page.
     */
    public function index()
    {
        return $this->landing();
    }
}
