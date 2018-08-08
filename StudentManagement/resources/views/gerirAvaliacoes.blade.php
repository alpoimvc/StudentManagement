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

      <h2>Avaliações</h2>

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
      
      <button style="margin-top: 25px;" id="addCuidador" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">Adicionar Avaliação</button>
      <!-- verifica se o array recebido na view está vazio.-->
      @if(!empty($cadeiras))
      <table style="margin-top: 25px;" class="table table-hover, header-fixed" id="cadeirasTable">
        <thead>
          <tr>
            <th>IDAluno</th>
            <th>Nome</th>
            <th>Nota</th>
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
   receber as avaliações dos alunos a essa cadeira */
    $('select[name="cadeira"]').on('change', function(){
      $.getJSON("/getAvaliacoes/"+$(this).val(), function(jsonData){
        /* Variável usada para criar a tabela */
        row = '<tr>';
        $.each(jsonData, function(i,data)
        {
          row += '<th>'+data.idAluno+'</th>';
          row += '<th>'+data.nomeAluno+'</th>';
          row += '<th>'+data.nota+'</th>';
          row += '<th>';
          row += '<button id="removerAvaliacao" type="button" class="btn btn-danger" data-id="'+data.id+'">Apagar</button>';
          row += '</th>';
          row += '</tr>';
        });
        if(!$('select[name="cadeira"]').val()){
          row = '';
        }
        $("#tbody").html(row);
      });
    });

    /* Ao selecionar uma cadeira (no modal de inserir avaliaçao)
    faz-se o pedido ajax para receber os alunos inscritos a essa cadeira */
    $('select[name="nomeCadeira"]').on('change', function(){
      $('select[name="nomeAluno"]').empty();
      $.getJSON("/getInscricoes/"+$(this).val(), function(jsonData){

        /* Variável que vai criar as options para o select */
        option = '<option value="">Escolher aluno</option>';
        $.each(jsonData, function(i,data)
        {
          option += '<option val="'+data.nomeAluno+'">'+data.nomeAluno+'</option>';
        });
        if(!$('select[name="nomeCadeira"]').val()){
          option = '';
        } 
        $('select[name="nomeAluno"]').append(option);
      });
    });

    /* Ao selecionar um aluno o seu id é passado para um input
    que posteriormente vai ser submetido no formulário para identificar
    o aluno
    */
    $('select[name="nomeAluno"]').on('change', function(){
      $.getJSON("/getIDAluno/"+$(this).val(), function(jsonData){
        $.each(jsonData, function(i,data)
        {
          document.getElementById("inputAluno").value = data.id;
        });
      });
    });

    $(document).on('click', '#removerAvaliacao', function () {
      $.ajax({
        type: 'POST',
        /* É enviado para o controlador o id do aluno e o nome da cadeira a remover. */
        url: '/removerAvaliacao/{id}',
        data: {
          "_token": "{{ csrf_token() }}",
          "id": $(this).data("id"),
        },
        success: function(){
          location.reload(); //refreshes page
        },
      }); 
    });

});

$(document).on('click', '#deleteCadeira', function () {
      $.ajax({
        type: 'POST',
        url: '/apagarCadeira/{id}',
        //data : { id :  $(this).data("id") }
        data: {
          "_token": "{{ csrf_token() }}",
          "id": $(this).data("id")
        }
      });
      location.reload(); //refreshes page
});

</script>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Adicionar Avaliação</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ url('/inserirAvaliacao') }}" method="POST">
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                
                <div class="form-group">
                <label for="des">Cadeira:</label>
                <select name="nomeCadeira" id="nomeCadeira" class="form-control">
                <option value="">Escolher cadeira</option>
                    @foreach($cadeiras as $data)
                    <option value="{{ $data->nome }}">
                      {{ $data->nome }}
                    </option>
                    @endforeach
                </select>
                </div>

                <div class="form-group">
                <label for="des">Aluno:</label>
                <select name="nomeAluno" id="nomeAluno" class="form-control">

                </select>
                </div>

                <div id="divAluno" class="form-group">
                <input type="hidden" class="form-control" id="inputAluno" name="idAluno">
                </div>

              <div class="form-group">
                <label for="des">Nota</label>
                <input type="text" name="nota" class="form-control" id="nota">
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
</div>
</body>

<script>

</script>

@endsection