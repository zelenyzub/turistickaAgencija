<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

        $filteri = DB::table('blog_vesti')
            ->orderBy($sort, $sorting);

        if (!empty($search)) {
            $filteri = $filteri->whereRaw("(naslov LIKE '%{$search}%')");
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
                'polise_osiguranja.datumPutovanjaDo',
                'osiguranici.ime',
                'osiguranici.prezime',
                'osiguranici.datumRodjenja'
            )
            ->leftJoin('osiguranici', 'osiguranici.idPolise', '=', 'polise_osiguranja.idPolise')
            ->orderBy($sort, $sorting);

        if (!empty($search)) {
            $filteri = $filteri->whereRaw("(polise_osiguranja.imeNosiocaOsiguranja
            LIKE '%{$search}%' OR polise_osiguranja.prezimeNosiocaOsiguranja LIKE '%{$search}%' OR
            polise_osiguranja.vrstaPolise LIKE '%{$search}%' OR
            osiguranici.ime LIKE '%{$search}%' OR osiguranici.prezime LIKE '%{$search}%')");
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


    public function obrisiBlog($idBloga)
    {

        $query = DB::table('blog_vesti')->where('idBloga', $idBloga)->delete();
        return $query;
    }
}