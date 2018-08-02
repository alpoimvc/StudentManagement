<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Cadeira;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminUpdateCadeira extends Controller
{
    public function index(){
        $cadeiras = DB::select('select * from cadeiras');
        return view('gerirCadeiras',['cadeiras'=>$cadeiras]);
     }
     public function show($id) {
        $cadeiras = DB::select('select * from cadeiras where id = ?',[$id]);
        return $cadeiras;
        //return view('cuidadorUpdate',['users'=>$users]);
     }
     
     public function edit(Request $request) {
        $cadeira = Cadeira::findOrFail($request->id);
        $cadeira->codigo = $request->codigo;
        $cadeira->nome = $request->nome;
        $cadeira->save();

        return redirect()->to('/gerirCadeiras');
     }

}