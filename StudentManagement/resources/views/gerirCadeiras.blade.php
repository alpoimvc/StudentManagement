@extends('layouts.app') @section('content')

<head>

  <meta name="csrf-token" content="{{ csrf_token() }}">

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

      <h2>Cadeiras</h2>

      <button style="margin-top: 25px;" id="addCadeira" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAdicionar">Adicionar Cadeira</button>
      
      <!-- verifica se o array recebido na view está vazio.-->
      @if(!empty($cadeiras))
      <table style="margin-top: 25px;" class="table table-hover, header-fixed" id="cadeirasTable">
        <thead>
          <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Opções</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          
          <!-- Recebe o array com todas as cadeiras da base de dados -->
          @foreach($cadeiras as $data)
          <tr>
            <th>{{$data->id}}</th>
            <th>{{$data->nome}}</th>
            <th>
              <button style="margin-right: 20px;" type="button" id="open" class="btn btn-info" data-toggle="modal" data-target="#modalEditar"
                data-id="{{$data->id}}" data-nome="{{$data->nome}}">Editar</button>
              <button style="margin-right: 20px;" id="deleteCadeira" type="button" class="btn btn-danger" data-id="{{$data->id}}">Apagar</button>
              <button style="margin-right: 20px;" type="button" id="verAlunos" data-nome="{{$data->nome}}" data-id="{{$data->id}}" class="btn btn-info" data-toggle="modal" data-target="#modalAlunos">Alunos Inscritos</button>
            </th>
          </tr>
          @endforeach
      </table>

    </div>

    <!-- Modal  que contém um formulario para editar o nome da cadeira -->
    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Editar Cadeira</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ url('/editarCadeira') }}" method="POST">
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <input type="hidden" name="idCadeira" id="idCadeira">

              <div class="form-group">
                <label for="des">Nome</label>
                <input type="text" class="form-control" name="nomeCadeira" id="nomeCadeira">
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="ajaxSubmit" class="btn btn-info" data-id='{{$data->id}}'>Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal que contém um formulario para inserir uma nova cadeira
    Os dados são enviados pela route "/inserirCadeira" -->
    <div class="modal fade" id="modalAdicionar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ url('/inserirCadeira') }}" method="POST">
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

              <div class="form-group">
                <label for="des">Nome</label>
                <input type="text" name="nome" class="form-control">
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" data-nome='{{$data->nome}}'>Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal que mostra os alunos inscritos -->
    <div class="modal fade" id="modalAlunos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Alunos inscritos</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

              <table style="margin-top: 25px;" class="table table-hover, header-fixed" id="cadeirasTable">
              <thead>
              <tr>
              <th>Número</th>
              <th>Nome</th>
              </tr>
              </thead>

              <tbody id="tbody">

              </tbody>
              </table>
 
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
  </div>

  <script>
    $(document).ready(function () {

      /*Quando o modal é aberto, os dados passados pelo botão são
      atribuídos aos elementos com id "idCadeira" e "nomeCadeira".*/

      $('#modalEditar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal = $(this);
        modal.find('#idCadeira').val(button.data('id'));
        modal.find('#nomeCadeira').val(button.data('nome'));
      });

      /*Quando o modal é aberto é feito um pedido ajax que recebe as
      inscricoes à cadeira. As inscrições são mostradas no modal que aparece ao
      clicar em "Alunos Inscritos" */
      $('#modalAlunos').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal = $(this);
        $.getJSON("/getInscricoes/"+button.data('nome'), function(jsonData){
        row = '<tr>';
        $.each(jsonData, function(i,data)
        {
          row += '<th>'+data.idAluno+'</th>';
          row += '<th>'+data.nomeAluno+'</th>';
          row += '<th>';
          row += '</th>';
          row += '</tr>';
        });
        $("#tbody").html(row);
      });
      });
    });

    /* Ao clicar no botão de delete é feito um pedido ajax que identifica
    o id da cadeira a remover */
    $(document).on('click', '#deleteCadeira', function () {
      $.ajax({
        type: 'POST',
        url: '/removerCadeira/{id}',
        data: {
          "_token": "{{ csrf_token() }}",
          "id": $(this).data("id"),
        },
        success: function(){
          location.reload(); //refreshes page
        },
      });
      
    });

  </script>

@endif

</body>
 
@endsection