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
Route::get('/registracija',[KupovinaController::class,'registracijaKorisnika']);
Route::get('/loginKorisnika',[KupovinaController::class,'loginKorisnika']);
Route::post('/login',[KupovinaController::class,'login']);
Route::get('/admin',[KupovinaController::class,'adminStrana']);
Route::get('/tabelaBlog',[TabeleContreller::class,'tabelaBlogStrana']);
Route::get('/prikazBlog',[TabeleContreller::class,'tabelaBlog']);
Route::post('/obrisiBlog',[TabeleContreller::class,'obrisiBlog']);
Route::get('/tabelaOsiguranja',[TabeleContreller::class,'tabelaOsiguranjaStrana']);
Route::get('/prikaziOsiguranike',[TabeleContreller::class,'tabelaOsiguranja']);


Route::post('/sacuvajBlog',[KorisnikController::class,'sacuvajBlog']);