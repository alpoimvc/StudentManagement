<?php

namespace App\Http\Controllers;

use App\Cadeira;
use Illuminate\Http\Request;
use DB;
use Validator;

class AdminInserirAvaliacao extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    public function inserir(Request $req)
    {
          $cadeira = new Cadeira;
          $cadeira->codigo = $req->input('codigo');
          $cadeira->nome = $req->input('nome');
          $cadeira->save();
          return redirect()->to('/gerirCadeiras');
    }

    public function getAvaliacoes($id) {
        //$avaliacoes = DB::table("avaliacoes")->select('idAluno','nomeAluno','nota')->where("idCadeira",$id);
        $avaliacoes = DB::table("avaliacoes")->select('idAluno','nomeAluno','nota')->where('idCadeira', '=', $id)->get();
        return json_encode($avaliacoes);
        //dd($avaliacoes);
        //return Response::json( $avaliacoes );
        //return "ola";
    }

}