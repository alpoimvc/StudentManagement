<?php

namespace App\Http\Controllers;

use App\Cadeira;
use App\Inscricao;
use Illuminate\Http\Request;
use DB;
use Validator;

class AdminCadeiras extends Controller
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

    public function getAlunos($id) {
        $alunos = DB::table("inscricoes")->select('idAluno','nomeAluno')->where('idCadeira', '=', $id)->get();
        return json_encode($alunos);
    }

    public function getAlunoCadeiras($id) {
        $cadeiras = DB::table("inscricoes")->select('nomeCadeira')->where('idAluno', '=', $id)->get();
        return json_encode($cadeiras);
    }

    public function inscreverAluno(Request $req)
    {
        $inscricao = new Inscricao;
        $inscricao->idAluno = $req->input('idAluno');
        $inscricao->nomeAluno = $req->input('nameAluno');
        $inscricao->nomeCadeira = $req->input('nameCadeira');
        //$inscricao->save();
        $check = DB::table("inscricoes")->select('nomeCadeira')->where('nomeCadeira', '=', $inscricao->nomeCadeira)->get();
        if ($check->count()){
            return redirect()->to('/gerirAlunos');
        }
        $inscricao =  DB::insert('insert into inscricoes (idAluno, nomeAluno, nomeCadeira) values (?, ?, ?)',[$inscricao->idAluno, $inscricao->nomeAluno, $inscricao->nomeCadeira]);
        return redirect()->to('/gerirAlunos');
    }

}