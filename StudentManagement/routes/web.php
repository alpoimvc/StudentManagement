<?php

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

/*
Esta linha já vem por default com o laravel e representa todas as routes
relacionadas com login/registo e password resets.
*/
Auth::routes(); 

/*
Página para onde os utilizadores são redirecionados depois de fazerem o login
*/
Route::get('/home', 'HomeController@index')->name('home');

/*
Grupo que contém as routes do admin. Se o utilizador não tiver autenticado
como admin não consegue aceder às routes. Nesses casos é redirecionado para uma view
que diz que não tem acesso. Esta lógica está no ficheiro Middleware/AdminMiddleware
*/
Route::group(['middleware' => ['App\Http\Middleware\AdminMiddleware']], function () {
Route::get('/gerirCadeiras', function() {
    $cadeiras = DB::table('cadeiras')->get();
    return view('gerirCadeiras', ['cadeiras' => $cadeiras]);
});
Route::get('/gerirAlunos', function() {
    $alunos = DB::table('users')->get();
    return view('gerirAlunos', ['alunos' => $alunos]);
});
Route::get('/gerirAvaliacoes', function() {
    $avaliacoes = DB::table('avaliacoes')->get();
    $cadeiras = DB::table('cadeiras')->get();
    return view('gerirAvaliacoes', ['avaliacoes' => $avaliacoes, 'cadeiras' => $cadeiras]);
});

Route::get('/getAvaliacoes/{id}', 'AdminInserirAvaliacao@getAvaliacoes');

Route::post('/inserirCadeira','AdminInserirCadeira@inserir')->name('inserirCadeira');
Route::get('/editarCadeira','AdminUpdateCadeira@show');
Route::post('/editarCadeira','AdminUpdateCadeira@edit');
});
