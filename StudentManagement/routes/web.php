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

    /* Neste tipo de routes é feita uma query que recebe um array
    da base de dados e o envia para a view */
Route::get('/gerirCadeiras', function() {
    $cadeiras = DB::table('cadeiras')->get();
    $alunos = DB::table('users')->get();
    $inscricoes = DB::table('inscricoes')->get();
    return view('gerirCadeiras', ['cadeiras' => $cadeiras, 'alunos' => $alunos, 'inscricoes' => $inscricoes]);
});

    /* Neste tipo de routes é feita uma query que recebe um array
    da base de dados e o envia para a view */
Route::get('/gerirAlunos', function() {
    $alunos = DB::table('users')->get();
    $cadeiras = DB::table('cadeiras')->get();
    return view('gerirAlunos', ['alunos' => $alunos, 'cadeiras' => $cadeiras]);
});

    /* Neste tipo de routes é feita uma query que recebe um array
    da base de dados e o envia para a view */
Route::get('/gerirAvaliacoes', function() {
    $avaliacoes = DB::table('avaliacoes')->get();
    $alunos = DB::table('users')->get();
    $cadeiras = DB::table('cadeiras')->get();
    return view('gerirAvaliacoes', ['avaliacoes' => $avaliacoes, 'cadeiras' => $cadeiras, 'alunos' => $alunos]);
});

Route::get('/consultarTrabalhos', function() {
    $trabalhos = DB::table('trabalhos')->get();
    $cadeiras = DB::table('cadeiras')->get();
    return view('consultarTrabalhos', ['trabalhos' => $trabalhos, 'cadeiras' => $cadeiras]);
});

    /* Routes normais. São constituidas por um url, uma variável opcional
    a passar como parametro, o controlador que vai fazer o processamento
    e a função que deve ser executado */

Route::get('/getAvaliacoes/{nome}', 'AdminAvaliacoes@getAvaliacoes');
Route::get('/getTrabalhos/{nome}', 'UploadController@getTrabalhos');
Route::get('/getInscricoes/{id}', 'AdminCadeiras@getAlunos');
Route::get('/getCadeirasAluno/{id}', 'AdminCadeiras@getAlunoCadeiras');
Route::get('/getIDAluno/{nome}', 'AdminAvaliacoes@getIDAluno');
Route::post('/editarCadeira','AdminCadeiras@editarCadeira');
Route::post('/removerCadeira/{id}','AdminCadeiras@removerCadeira');
Route::post('/removerInscricao/{id}/{nome}','AdminCadeiras@removerInscricao');
Route::post('/removerAvaliacao/{id}','AdminAvaliacoes@removerAvaliacao');
Route::post('/inserirInscricao', 'AdminCadeiras@inscreverAluno');
Route::post('/inserirAvaliacao', 'AdminAvaliacoes@inserir');
Route::post('/inserirCadeira','AdminCadeiras@inserir');
Route::get('/inserirAluno/{id}', 'AdminAvaliacoes@getAvaliacoes');
Route::get('gerirHorarios', 'EventController@index');
Route::post('/guardarHorario','EventController@inserir');

});

/*
Grupo que contém as routes do aluno. Se o utilizador não tiver autenticado
como aluno não consegue aceder às routes. Nesses casos é redirecionado para uma view
que diz que não tem acesso. Esta lógica está no ficheiro Middleware/AlunoMiddleware
*/
Route::group(['middleware' => ['App\Http\Middleware\AlunoMiddleware']], function () {
    Route::get('/consultarCadeiras', function() {
        $inscricoes = DB::table('inscricoes')->get();
        return view('consultarCadeiras', ['inscricoes' => $inscricoes]);
    });
    Route::post('/removerInscricao/{id}/{nome}','AdminCadeiras@removerInscricao');

    Route::get('/consultarAvaliacoes', function() {
        $avaliacoes = DB::table('avaliacoes')->get();
        return view('consultarAvaliacoes', ['avaliacoes' => $avaliacoes]);
    });

    Route::get('/submeterTrabalho', function() {
        $cadeiras = DB::table('cadeiras')->get();
        return view('submeterTrabalho', ['cadeiras' => $cadeiras]);
    });

    Route::post('/submeterTrabalho','UploadController@uploadFilePost');
});
