<?php

namespace App\Http\Controllers;

use App\Models\Admin;
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

    public function loginKorisnika()
    {
        return view('login');
    }
    public function adminStrana()
    {
        return view('admin');
    }

    public function dodajPolisu(Request $request)
    {
        $imeNosioca = $request->input('imeNosioca');
        $prezimeNosioca = $request->input('prezimeNosioca');
        $vrstaPolise = $request->input('vrstaOsiguranja');
        $telefon = $request->input('telefon');
        $datumPutovanjaOd = Carbon::parse($request->input('datumOdmora')[0])->addDay()->toDateString();
        $datumPutovanjaDo = Carbon::parse($request->input('datumOdmora')[1])->addDay()->toDateString();
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

    public function login(Request $request)
    { {
            $korisnickoIme = $request->input('korisnickoIme');
            $lozinkaKorisnika = $request->input('lozinkaKorisnika');
            $role = $request->input('role');
            $ulogovan = new Admin();
            $ulogovan->login($korisnickoIme, $lozinkaKorisnika, $role);

            if ($ulogovan) {
                return redirect('/admin');
            } else {

                return back()->with('error', 'Pogrešno korisničko ime, lozinka ili uloga.');
            }
        }
    }
}