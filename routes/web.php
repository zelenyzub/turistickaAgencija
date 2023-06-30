<?php


use App\Http\Controllers\KorisnikController;
use App\Http\Controllers\TabeleContreller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KupovinaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/osiguranje',[KupovinaController::class,'onlineKupovina']);
Route::post('/dodajPolisu',[KupovinaController::class,'dodajPolisu']);
Route::get('/admin',[KupovinaController::class,'adminStrana']);
Route::get('/tabelaBlog',[TabeleContreller::class,'tabelaBlogStrana']);
Route::get('/prikazBlog',[TabeleContreller::class,'tabelaBlog']);
Route::post('/obrisiBlog',[TabeleContreller::class,'obrisiBlog']);
Route::post('/obrisiPolisu',[TabeleContreller::class,'obrisiPolisu']);
Route::get('/tabelaOsiguranja',[TabeleContreller::class,'tabelaOsiguranjaStrana']);
Route::get('/prikaziOsiguranja',[TabeleContreller::class,'tabelaOsiguranja']);
Route::post('/prikaziOsiguranike',[TabeleContreller::class,'tabelaOsiguranici']);
Route::get('/izmeni',[TabeleContreller::class,'izmeniPolisuStrana']);
Route::post('/izmeniPolisu',[TabeleContreller::class,'izmeniPolisu']);
Route::post('/objavi',[TabeleContreller::class,'objavi']);
Route::post('/arhiviraj',[TabeleContreller::class,'arhiviraj']);
Route::get('/blog',[TabeleContreller::class,'blogStrana']);
Route::get('/blogovi',[TabeleContreller::class,'blog']);

Route::post('/sacuvajBlog',[KorisnikController::class,'sacuvajBlog']);