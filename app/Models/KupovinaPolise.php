<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use TheSeer\Tokenizer\Exception;


class KupovinaPolise extends Model
{
    use HasFactory;

    public function dodajPolisu($imeNosioca, $prezimeNosioca, $vrstaPolise, $telefon, $datumPutovanjaOd, $datumPutovanjaDo, $osiguranici)
    {
        $data = [
            'imeNosiocaOsiguranja' => $imeNosioca,
            'prezimeNosiocaOsiguranja' => $prezimeNosioca,
            'vrstaPolise' => $vrstaPolise,
            'telefon' => $telefon,
            'datumPutovanjaOd' => $datumPutovanjaOd,
            'datumPutovanjaDo' => $datumPutovanjaDo,
        ];

        DB::beginTransaction();

        try{
            $idPolise = DB::table('polise_osiguranja')->insertGetId($data);

            if($vrstaPolise === 'grupna'){
                foreach($osiguranici as $osiguranik){
                    $osiguranik['idPolise'] = $idPolise;
                    DB::table('osiguranici')->insert($osiguranik);
                }
            }
            DB::commit();
        }
        catch(Exception $e){
            DB::rollBack();
        }
    }
}