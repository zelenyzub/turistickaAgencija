<?php

namespace App\Http\Controllers;

use App\Models\Tabele;
use Illuminate\Http\Request;

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
        $idBloga = $request->input('idBloga');
        $obrisi = new Tabele;
        $obrisi = $obrisi->obrisiBlog($idBloga);

        return response()->json(['success' => true]);

    }

    public function obrisiPolisu(Request $request)
    {
        $obrisi = new Tabele;
        $obrisi = $obrisi->obrisiPolisu($request->all());

        return response()->json(['success' => true]);

    }
}