<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use DB;

class UploadController extends Controller
{
    
    /** Return view to upload file */
    public function uploadFile(){
        return view('submeterTrabalho');
    }

    /** File Upload */
    public function uploadFilePost(Request $request){
        
        $request->validate([
            'fileToUpload' => 'required|file|max:25600',
            'nomeCadeira' => 'required|string|min:4|max:255',
        ]);
        
        $fileName = $request->fileToUpload->getClientOriginalName();
        //$fileName = $originalName.'.'.request()->fileToUpload->getClientOriginalExtension();
        //$fileName = "fileName".time().'.'.request()->fileToUpload->getClientOriginalExtension();
 
        $path = $request->fileToUpload->storeAs('trabalhos',$fileName);

        $idAluno = Auth::user()->id;
        $nomeAluno = Auth::user()->name;
        $guardar = DB::insert('insert into trabalhos (nomeCadeira, idAluno, nomeAluno, caminho) values (?, ?, ?, ?)',[$request->nomeCadeira, $idAluno, $nomeAluno, $path]);
 
        //return $path;
        return back()
            ->with('success','Documento submetido com sucesso.');
    }

    public function getTrabalhos($nome) {
        $trabalhos = DB::table("trabalhos")->select('idAluno','nomeAluno','caminho')->where('nomeCadeira', '=', $nome)->get();
        return json_encode($trabalhos);
    }

}