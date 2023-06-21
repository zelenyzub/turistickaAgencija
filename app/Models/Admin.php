<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    public static function login($korisnickoIme, $lozinkaKorisnika, $role){
        $query = DB::table('korisnici')
            ->select('korisnickoIme','lozinkaKorisnika','role')
            ->where('korisnickoIme', $korisnickoIme)
            ->where('lozinkaKorisnika', $lozinkaKorisnika)
            ->where('role', $role)
            ->exists();

        return $query;
    }
}
