<?php

namespace App\Models;

use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Tabele extends Model
{
    public function tabelaBlog($request)
    {

        $start = $request['start'];
        $length = $request['length'];
        $sort = 'blog_vesti.idBloga';
        $sorting = 'asc';
        $search = $request['search']['value'];

        switch ($request['order'][0]['column']) {
            case '0':
                $sort = 'idBloga';
                break;
            case '1':
                $sort = 'naslov';
                break;
            case '2':
                $sort = 'datumKreiranja';
                break;
        }

        $sorting = $request['order'][0]['dir'];
        if (isset($request['selektovaniDatum'])) {
            $selektovaniDatum = $request['selektovaniDatum'];
        } else {
           
        }
        

        $filteri = DB::table('blog_vesti')
            ->orderBy($sort, $sorting);

        if (!empty($search)) {
            $filteri = $filteri->whereRaw("(naslov LIKE '%{$search}%')");
        }

        if (!empty($selektovaniDatum)) {
            $filteri = $filteri->whereRaw("(datumKreiranja LIKE '%{$selektovaniDatum}%')");
        }

        $filtered = $filteri->count();

        $total = $filteri->offset($start)
            ->limit($length)
            ->get();

        return [
            'filtered' => $filtered,
            'data' => $total
        ];
    }

    public function tabelaOsiguranja($request)
    {
        $start = $request['start'];
        $length = $request['length'];
        $sort = 'polise_osiguranja.idPolise';
        $sorting = 'asc';
        $search = $request['search']['value'];

        switch ($request['order'][0]['column']) {
            case '0':
                $sort = 'idPolise';
                break;
            case '1':
                $sort = 'imeNosiocaOsiguranja';
                break;
            case '2':
                $sort = 'prezimeNosiocaOsiguranja';
                break;
            case '3':
                $sort = 'vrstaPolise';
                break;
            case '4':
                $sort = 'datumPutovanjaOd';
                break;
            case '5':
                $sort = 'datumPutovanjaDo';
                break;
        }

        $sorting = $request['order'][0]['dir'];

        $filteri = DB::table('polise_osiguranja')
            ->select(
                'polise_osiguranja.idPolise',
                'polise_osiguranja.imeNosiocaOsiguranja',
                'polise_osiguranja.prezimeNosiocaOsiguranja',
                'polise_osiguranja.vrstaPolise',
                'polise_osiguranja.telefon',
                'polise_osiguranja.datumPutovanjaOd',
                'polise_osiguranja.datumPutovanjaDo'
            )
            ->orderBy($sort, $sorting);

        if (!empty($search)) {
            $filteri = $filteri->whereRaw("(polise_osiguranja.imeNosiocaOsiguranja
            LIKE '%{$search}%' OR polise_osiguranja.prezimeNosiocaOsiguranja LIKE '%{$search}%' OR
            polise_osiguranja.vrstaPolise LIKE '%{$search}%')");
        }

        $filtered = $filteri->count();

        $total = $filteri->offset($start)
            ->limit($length)
            ->get();

        return [
            'filtered' => $filtered,
            'data' => $total
        ];
    }

    public function tabelaOsiguranici($request)
    {
        $start = isset($request['start']) ? $request['start'] : 0;
        ;

        $orderColumn = isset($request['order'][0]['column']) ? $request['order'][0]['column'] : 0;
        $orderDir = isset($request['order'][0]['dir']) ? $request['order'][0]['dir'] : 'asc';
        $search = isset($request['search']['value']) ? $request['search']['value'] : '';

        switch ($orderColumn) {
            case '0':
                $orderColumn = 'idOsiguranika';
                break;
            case '1':
                $orderColumn = 'ime';
                break;
            case '2':
                $orderColumn = 'prezime';
                break;
            case '3':
                $orderColumn = 'datumRodjenja';
                break;
        }



        $filteri = DB::table('osiguranici')
            ->select(
                'osiguranici.idPolise',
                'osiguranici.ime',
                'osiguranici.prezime',
                'osiguranici.datumRodjenja'
            )
            ->orderBy($orderColumn, $orderDir);
        $length = isset($request['length']) ? $request['length'] : $filteri->count();
        if (!empty($search)) {
            $filteri = $filteri->whereRaw("(osiguranici.ime
            LIKE '%{$search}%' OR osiguranici.prezime LIKE '%{$search}%')");
        }

        $filtered = $filteri->count();

        $total = $filteri->offset($start)
            ->limit($length)
            ->get();

        return [
            'filtered' => $filtered,
            'data' => $total
        ];

    }

    public function obrisiPolisu($idPolise)
    {
        $query = DB::table('polise_osiguranja')
            ->where('idPolise', $idPolise)
            ->delete();
        return $query;
    }


    public function obrisiBlog($idBloga)
    {

        $query = DB::table('blog_vesti')
            ->where('idBloga', $idBloga)
            ->delete();
        return $query;
    }

    public function izmeniPolisu($idPolise, $imeNosioca, $prezimeNosioca, $telefon, $datumPutovanjaOd, $datumPutovanjaDo)
    {
        DB::table('polise_osiguranja')
            ->where('idPolise', $idPolise)
            ->update([
                'idPolise' => $idPolise,
                'imeNosiocaOsiguranja' => $imeNosioca,
                'prezimeNosiocaOsiguranja' => $prezimeNosioca,
                'telefon' => $telefon,
                'datumPutovanjaOd' => $datumPutovanjaOd,
                'datumPutovanjaDo' => $datumPutovanjaDo,
            ]);
        //dd($datumPutovanjaOd);
    }


    public function izmeniBlog($idBloga, $naslov, $opis, $tekst, $fotografija, $tipObjave, $autor)
    {

        if ($fotografija) {
            $fotografija = Storage::url($fotografija);
        } else {
            $fotografija = null;
        }

        DB::table('blog_vesti')
            ->where('idBloga', $idBloga)
            ->update([
                'idBloga' => $idBloga,
                'naslov' => $naslov,
                'opis' => $opis,
                'tekst' => $tekst,
                'fotografija' => $fotografija,
                'tipObjave' => $tipObjave,
                'autor' => $autor,
            ]);
    }

    public function objavi($idBloga, $statusBloga, $datumObjavljivanja)
    {
        DB::table('blog_vesti')
            ->where('idBloga', $idBloga)
            ->update([
                'idBloga' => $idBloga,
                'statusBloga' => $statusBloga,
                'datumObjavljivanja' => $datumObjavljivanja,

            ]);
    }

    public function arhiviraj($idBloga, $statusBloga, $datumArhiviranja)
    {
        DB::table('blog_vesti')
            ->where('idBloga', $idBloga)
            ->update([
                'idBloga' => $idBloga,
                'statusBloga' => $statusBloga,
                'datumArhiviranja' => $datumArhiviranja
            ]);
    }

    public function blog()
    {

        $query = DB::table('blog_vesti')
            ->select('naslov', 'opis', 'tekst', 'fotografija', 'tipObjave', 'datumKreiranja', 'autor', 'statusBloga', 'datumObjavljivanja')
            ->where('statusBloga', 'objavljeno')
            ->get();
        //dd($query);

        return $query;

    }

    public function popuniPodBlog($idBloga, $naslov, $opis, $tekst, $fotografija, $tipObjave, $autor)
    {
        $blogVest = DB::table('blog_vesti')
            ->select('naslov', 'opis', 'tekst', 'fotografija', 'tipObjave', 'autor')
            ->where('idBloga', $idBloga)
            ->get();

        //dd($blogVest);
        return $blogVest;

    }
    public function popuniPodPolise($idPolise, $imeNosioca, $prezimeNosioca, $telefon, $datumPutovanjaOd, $datumPutovanjaDo)
    {
        $poupuniPolisu = DB::table('polise_osiguranja')
            ->select('imeNosiocaOsiguranja','prezimeNosiocaOsiguranja','telefon','datumPutovanjaOd','datumPutovanjaDo')
            ->where('idPolise', $idPolise)
            ->get();

        //dd($idPolise);
        return $poupuniPolisu;

    }
}