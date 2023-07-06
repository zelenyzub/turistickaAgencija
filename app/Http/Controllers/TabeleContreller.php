<?php

namespace App\Http\Controllers;

use App\Models\Tabele;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TabeleContreller extends Controller
{
    public function tabelaBlogStrana()
    {
        return view('tabelaBlog');
    }
    public function tabelaOsiguranjaStrana()
    {
        return view('tabelaOsiguranja');
    }
    public function izmeniPolisuStrana()
    {
        return view('izmeniPolisu');
    }
    public function izmeniBlogStrana()
    {
        return view('izmeniBlog');
    }

    public function blogStrana(){
        return view('blog');
    }


    public function tabelaBlog(Request $request)
    {

        $model = new Tabele();
        $upit = $model->tabelaBlog($request->all());

        $data['draw'] = $request->draw;
        $data['recordsFiltered'] = $upit['filtered'];
        $data['recordsTotal'] = count($upit['data']);
        $data['data'] = $upit['data'];

        return response()->json($data);
    }
    public function tabelaOsiguranici(Request $request)
    {
        $model = new Tabele();
        $upit = $model->tabelaOsiguranici($request->all());

        $data['draw'] = $request->draw;
        $data['recordsFiltered'] = $upit['filtered'];
        $data['recordsTotal'] = count($upit['data']);
        $data['data'] = $upit['data'];

        return response()->json($data);
    }

    public function tabelaOsiguranja(Request $request)
    {
        $model = new Tabele();
        $upit = $model->tabelaOsiguranja($request->all());

        $data['draw'] = $request->draw;
        $data['recordsFiltered'] = $upit['filtered'];
        $data['recordsTotal'] = count($upit['data']);
        $data['data'] = $upit['data'];

        return response()->json($data);
    }


    public function obrisiBlog(Request $request)
    {
        $obrisi = new Tabele;
        $obrisi = $obrisi->obrisiBlog($request->all());

        return response()->json(['success' => true]);

    }

    public function obrisiPolisu(Request $request)
    {
        $obrisi = new Tabele;
        $obrisi = $obrisi->obrisiPolisu($request->all());

        return response()->json(['success' => true]);

    }
    public function izmeniPolisu(Request $request){

       
        $idPolise = $request->input('idPolise');
        $imeNosioca = $request->input('imeNosioca');
        $prezimeNosioca = $request->input('prezimeNosioca');
        $telefon = $request->input('telefon');
        $datumPutovanjaOd = Carbon::parse($request->input('datumOdmora')[0])->addDay()->toDateString();
        $datumPutovanjaDo = Carbon::parse($request->input('datumOdmora')[1])->addDay()->toDateString();

        $query = new Tabele();
        $query->izmeniPolisu($idPolise,$imeNosioca,$prezimeNosioca,$telefon,$datumPutovanjaOd,$datumPutovanjaDo);
        //dd($request->all());
        //dd($request->input('datumOdmora'));
        return response()->json(['message' => 'Polisa osiguranja je uspešno izmenjena'], );
    }

    public function objavi(Request $request){
        $idBloga = $request->input('idBloga');
        $statusBloga = $request->input('statusBloga');
        $datumObjavljivanja = $request->input('datumObjavljivanja');

        $query = new Tabele();
        $query->objavi($idBloga,$statusBloga,$datumObjavljivanja);
    }

    public function arhiviraj(Request $request){
        $idBloga = $request->input('idBloga');
        $statusBloga = $request->input('statusBloga');
        $datumArhiviranja = $request->input('datumArhiviranja');

        $query = new Tabele();
        $query->arhiviraj($idBloga,$statusBloga,$datumArhiviranja);

    }

    public function blog(){


        $query = new Tabele();
        $data = $query->blog();
        //dd($data);
        return response()->json($data);
    }

    public function izmeniBlog(Request $request)
    {

        if ($request->hasFile('fotografija')) {
            $fotografija = $request->file('fotografija')->store('public/images');
           
        } else {
            $fotografija = null;
        }
        //dd($fotografija);
        $idBloga = $request->input('idBloga');
        $naslov = $request->input('naslov');
        $opis = $request->input('opis');
        $tekst = $request->input('tekst');
        $tipObjave = $request->input('tipObjave');
        $autor = $request->input('autor');
        $izmeniBlog = new Tabele();
        $izmeniBlog->izmeniBlog($idBloga,$naslov, $opis, $tekst, $fotografija, $tipObjave,  $autor);



        return response()->json(['message' => 'Uspesno sacuvan blog.']);
    
    }

    public static function popuniPodBlog(Request $request)
    {
        $idBloga = $request -> input('idBloga');
        $idBloga = $request->input('idBloga');
        $naslov = $request->input('naslov');
        $opis = $request->input('opis');
        $tekst = $request->input('tekst');
        $fotografija = $request->input('fotografija');
        $tipObjave = $request->input('tipObjave');
        $autor = $request->input('autor');
        $query = new Tabele();
        $data = $query->popuniPodBlog($idBloga,$naslov, $opis, $tekst, $fotografija, $tipObjave,  $autor);
    

        return response()->json($data);
    }

    public static function popuniPodPolise(Request $request)
    {
        $idPolise = $request->input('idPolise');
        $imeNosioca = $request->input('imeNosioca');
        $prezimeNosioca = $request->input('prezimeNosioca');
        $telefon = $request->input('telefon');
        $datumPutovanjaOd = $request->input('datumOdmora');
        $datumPutovanjaDo = $request->input('datumOdmora');
        $vrstaPolise = $request->input('vrstaPolise');
        $query = new Tabele();
        $data = $query->popuniPodPolise($idPolise, $imeNosioca, $prezimeNosioca, $telefon, $datumPutovanjaOd, $datumPutovanjaDo,$vrstaPolise);

        //dd($data);
    

        return response()->json($data);
    }


}