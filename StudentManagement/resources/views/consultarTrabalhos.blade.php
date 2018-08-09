@extends('layouts.app') @section('content')

<head>

  <!-- <script src="//code.jquery.com/jquery-1.10.2.js"></script> -->
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>

  <!-- Bootstrap JavaScript -->
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.1/js/bootstrap.min.js"></script>

  <!-- toastr notifications -->
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

  <!-- icheck checkboxes -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>

</head>

<style>
  .header-fixed {
    width: 100%
  }

  .header-fixed>thead,
  .header-fixed>tbody,
  .header-fixed>thead>tr,
  .header-fixed>tbody>tr,
  .header-fixed>thead>tr>th,
  .header-fixed>tbody>tr>td {
    display: block;
  }

  .header-fixed>tbody>tr:after,
  .header-fixed>thead>tr:after {
    content: ' ';
    display: block;
    visibility: hidden;
    clear: both;
  }

  .header-fixed>tbody {
    overflow-y: auto;
    height: 150px;
  }

  .header-fixed>tbody>tr>td,
  .header-fixed>thead>tr>th {
    width: 20%;
    float: left;
  }

</style>

<body>
  <div class="container" style="width: 90%; clear:both; display: table; margin: 0 auto;">
    <div class="col-md">

      <h2>Trabalhos</h2>

      <!-- Primeiro seleciona-se a cadeira e posteriormente são mostradas 
      as avaliações dessa cadeira através de um pedido ajax -->
      <select name="cadeira" id="cadeira" class="form-control">
      <option value="0">Escolher Cadeira</option>
      @foreach($cadeiras as $data)
      <option value="{{ $data->nome}}">
      {{ $data->nome }}
      </option>
      @endforeach
      </select>
      
      <!-- verifica se o array recebido na view está vazio.-->
      @if(!empty($trabalhos))
      <table style="margin-top: 25px;" class="table table-hover, header-fixed" id="cadeirasTable">
        <thead>
          <tr>
            <th>IDAluno</th>
            <th>Nome</th>
            <th>Documento</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="tbody">

        <tbody>
      </table>
    </div>

  </div>

@endif

<script>

$(document).ready(function () {
   /* Ao selecionar uma cadeira faz-se o pedido ajax para
   receber os trabalhos dos alunos a essa cadeira */
    $('select[name="cadeira"]').on('change', function(){
      $.getJSON("/getTrabalhos/"+$(this).val(), function(jsonData){
        row = '<tr>';
        $.each(jsonData, function(i,data)
        {
          row += '<th>'+data.idAluno+'</th>';
          row += '<th>'+data.nomeAluno+'</th>';
          /* Para cada trabalho faz-se um link para o respetivo caminho */
          row += '<th><a href="http://localhost:8000/storage/'+data.caminho+'" target="_blank">'+data.caminho+'</a></th>';
          row += '</tr>';
        });
        if(!$('select[name="cadeira"]').val()){
          row = '';
        }
        $("#tbody").html(row);
      });
    });
});

</script>


@endsection