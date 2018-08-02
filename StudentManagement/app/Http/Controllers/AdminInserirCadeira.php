<?php

namespace App\Http\Controllers;

use App\Cadeira;
use Illuminate\Http\Request;
use DB;
use Validator;

class AdminInserirCadeira extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    public function inserir(Request $req)
    {
        //dd($req->all());
        /*$validator = Validator::make($req->all(), [
            'name'  => 'required|max:255',
            //'email' => 'required|email|unique:users',
          ]);
          // If validator fails, short circut and redirect with errors
          if($validator->fails()){
            return back()
              ->withErrors($validator)
              ->withInput();
          }*/

          //add new user to database
          $cadeira = new Cadeira;
          $cadeira->codigo = $req->input('codigo');
          $cadeira->nome = $req->input('nome');
          $cadeira->save();
          return redirect()->to('/gerirCadeiras');
    }

}