<?php

namespace App\Http\Controllers;

use App\Http\Helpers\CorreiosAPI;
use Illuminate\Http\Request;

class CorreiosController extends Controller
{
    public function index(Request $request)
    {
        $correios = new CorreiosAPI();
        $response =  $correios->consultarCEP($request->get('cep'));
        return response()->json($response);
    }
}
