<?php

namespace App\Http\Controllers;

use App\Http\Helpers\CorreiosAPI;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //$correiosAPI = new CorreiosAPI();

        //var_dump($correiosAPI->consultarCEP('13880-000'));

        return view('home');
    }
}
