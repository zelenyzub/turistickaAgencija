<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KupovinaController extends Controller
{
    public function onlineKupovina(){
        return view('onlineKupovina');
    }
}
