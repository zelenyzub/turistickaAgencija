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
        $start = isset($request['start']) ? $request['start'] : 0;;
        $length = isset($request['length']) ? $request['length'] : 10;
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
    



    public function obrisiBlog($idBloga)
    {

        $query = DB::table('blog_vesti')->where('idBloga', $idBloga)->delete();
        return $query;
    }
}