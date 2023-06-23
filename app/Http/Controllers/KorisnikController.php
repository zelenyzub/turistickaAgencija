<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;


class KorisnikController extends Controller
{
    public function sacuvajBlog(Request $request)
    {

        if ($request->hasFile('fotografija')) {
            $fotografija = $request->file('fotografija')->store('public/images');
           
        } else {
            $fotografija = null;
        }
        //dd($fotografija);
        $naslov = $request->input('naslov');
        $opis = $request->input('opis');
        $tekst = $request->input('tekst');
        $tipObjave = $request->input('tipObjave');
        $datumKreiranja = Carbon::parse($request->input('datumKreiranja'))->toDateString();
        $autor = $request->input('autor');
        $statusBloga = $request->input('statusBloga');
        $sacuvaj = new Admin();
        $sacuvaj->sacuvajBlog($naslov, $opis, $tekst, $fotografija, $tipObjave, $datumKreiranja, $autor, $statusBloga);



        return response()->json(['message' => 'Uspesno sacuvan blog.']);

    }
}