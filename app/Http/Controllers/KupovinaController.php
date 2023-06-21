<?php

namespace App\Http\Controllers;

use App\Models\KupovinaPolise;
use App\Models\Osiguranici;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KupovinaController extends Controller
{
    public function onlineKupovina()
    {
        return view('onlineKupovina');
    }
    public function registracijaKorisnika()
    {
        return view('registracija');
    }

    public function dodajPolisu(Request $request)
    {
        $imeNosioca = $request->input('imeNosioca');
        $prezimeNosioca = $request->input('prezimeNosioca');
        $vrstaPolise = $request->input('vrstaOsiguranja');
        $telefon = $request->input('telefon');
        $datumPutovanjaOd = Carbon::parse($request->input('datumOdmora')[0])->toDateString();
        $datumPutovanjaDo = Carbon::parse($request->input('datumOdmora')[1])->toDateString();
        $osiguranici = $request->input('osiguranici');
        if ($vrstaPolise === 'grupna') {
            $osiguranici = array_map(function ($osiguranik) {
                $osiguranik['datumRodjenja'] = Carbon::parse($osiguranik['datumRodjenja'])->toDateString();
                return $osiguranik;
            }, $osiguranici);
        }


        $polisaOsiguranja = new KupovinaPolise();
        $polisaOsiguranja->dodajPolisu($imeNosioca, $prezimeNosioca, $vrstaPolise, $telefon, $datumPutovanjaOd, $datumPutovanjaDo, $osiguranici);

        return response()->json(['message' => 'Polisa osiguranja je uspešno dodata'], );

    }
}