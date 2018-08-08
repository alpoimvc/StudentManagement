<?php

namespace App\Http\Controllers;

use App\Cadeira;
use App\Inscricao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use Validator;

class AdminCadeiras extends Controller
{

    public function inserir(Request $req)
    {
        $cadeira = new Cadeira;
        $cadeira->nome = $req->input('nome');
        $cadeira->save();
        return redirect()->to('/gerirCadeiras');
    }

    public function getAlunos($nomeCadeira) {
        $alunos = DB::table("inscricoes")->select('idAluno','nomeAluno')->where('nomeCadeira', '=', $nomeCadeira)->get();
        return json_encode($alunos);
    }

    public function getAlunoCadeiras($id) {
        $cadeiras = DB::table("inscricoes")->select( 'idAluno', 'nomeCadeira')->where('idAluno', '=', $id)->get();
        return json_encode($cadeiras);
    }

    public function inscreverAluno(Request $req)
    {
        $inscricao = new Inscricao;
        $inscricao->idAluno = $req->input('idAluno');
        $inscricao->nomeAluno = $req->input('nomeAluno');
        $inscricao->nomeCadeira = $req->input('nomeCadeira');
        //$inscricao->save();
        $check = DB::table("inscricoes")->select('nomeCadeira')->where('nomeCadeira', '=', $inscricao->nomeCadeira)->where('idAluno', '=', $inscricao->idAluno)->get();
        if ($check->count()){
            return redirect()->to('/gerirAlunos');
        }
        $inscricao = DB::insert('insert into inscricoes (idAluno, nomeAluno, nomeCadeira) values (?, ?, ?)',[$inscricao->idAluno, $inscricao->nomeAluno, $inscricao->nomeCadeira]);
        return redirect()->to('/gerirAlunos');
    }

    public function editarCadeira(Request $request) {
        $cadeira = DB::table('cadeiras')
            ->where('id', $request->idCadeira)
            ->update(['nome' => $request->nomeCadeira]);
        return redirect()->to('/gerirCadeiras');
    }

    public function removerCadeira()
    {
        $id = Input::get('id');
        DB::delete('delete from cadeiras where id = ?',[$id]);
        return redirect()->to('/gerirCadeiras'); 
    }

    public function removerInscricao()
    {
        $id = Input::get('id');
        $nome = Input::get('nome');

        DB::delete('delete from inscricoes where nomeCadeira = ? and idAluno = ?',[$nome, $id]);
        //return json_encode($inscricao);
        return redirect()->to('/gerirAlunos'); 
    }
    

}