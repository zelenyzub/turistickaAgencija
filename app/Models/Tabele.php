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


    public function obrisiBlog($idBloga){
        
        $query = DB::table('blog_vesti')->where('idBloga', $idBloga)->delete();
        return $query;
    }
}