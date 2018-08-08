<?php

namespace App\Http\Controllers;

use App\Avaliacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use Validator;

class AdminAvaliacoes extends Controller
{
    /* Recebe os parametros da view (informaçao do aluno)
    e faz a query para inserir na base de dados. As outras funçoes sao
    semelhantes, sendo que algumas retornam um json (tipicamente para os pedidos ajax) */
    public function inserir(Request $req)
    {
        $avaliacao = new Avaliacao;
        $avaliacao->nomeCadeira = $req->input('nomeCadeira');
        $avaliacao->idAluno = $req->input('idAluno');
        $avaliacao->nomeAluno = $req->input('nomeAluno');
        $avaliacao->nota = $req->input('nota');

        $check = DB::table("avaliacoes")->select('nomeCadeira')->where('nomeCadeira', '=', $avaliacao->nomeCadeira)->where('idAluno', '=', $avaliacao->idAluno)->get();
        if ($check->count()){
            return redirect()->to('/gerirAvaliacoes');
        }
        $avaliacao = DB::insert('insert into avaliacoes (nomeCadeira, idAluno, nomeAluno, nota) values (?, ?, ?, ?)',[$avaliacao->nomeCadeira, $avaliacao->idAluno, $avaliacao->nomeAluno, $avaliacao->nota]);
        return redirect()->to('/gerirAvaliacoes');
    }

    public function getAvaliacoes($nome) {
        $avaliacoes = DB::table("avaliacoes")->select('id','idAluno','nomeAluno','nota')->where('nomeCadeira', '=', $nome)->get();
        return json_encode($avaliacoes);
    }

    public function getIDAluno($nome) {
        $aluno = DB::table("users")->select('id')->where('name', '=', $nome)->get();
        return json_encode($aluno);
    }

    public function removerAvaliacao()
    {
        $id = Input::get('id');

        DB::delete('delete from avaliacoes where id = ?',[$id]);
    }

}