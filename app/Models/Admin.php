<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Admin extends Model
{


    public function sacuvajBlog($naslov, $opis, $tekst, $fotografija, $tipObjave, $datumKreiranja, $autor, $statusBloga)
    {

        if ($fotografija) {
            $fotografija = Storage::url($fotografija);
        } else {
            $fotografija = null;
        }

        $data = [
            'naslov' => $naslov,
            'opis' => $opis,
            'tekst' => $tekst,
            'fotografija' => $fotografija,
            'tipObjave' => $tipObjave,
            'datumKreiranja' => $datumKreiranja,
            'autor' => $autor,
            'statusBloga' => $statusBloga,
        ];


        DB::table('blog_vesti')->insert($data);
    }
}