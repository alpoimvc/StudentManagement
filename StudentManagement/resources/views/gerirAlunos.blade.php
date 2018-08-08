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
      <h2>Alunos</h2>

      <!-- verifica se o array recebido na view está vazio.-->
      @if(!empty($alunos))
      <table style="margin-top: 25px;" class="table table-hover, header-fixed" id="cadeirasTable">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Email</th>
            <th></th>
          </tr>
        </thead>
        <tbody>

          <!-- Recebe o array com todos os utilizadores da base de dados
          e lista apenas os alunos -->
          @foreach($alunos as $data)
          @if($data->type == 'aluno')
          <tr>
            <th>{{$data->name}}</th>
            <th>{{$data->email}}</th>
            <th>
                <!-- Botão que abre o modal (popup) para ver as cadeiras -->
                <button style="margin-right: 30px;" type="button" id="verCadeiras" class="btn btn-primary" data-toggle="modal" data-target="#modalCadeiras"
                data-id="{{$data->id}}" data-name="{{$data->name}}">Ver cadeiras</button>
            </th>
          </tr>
          @endif
          @endforeach
      </table>

    </div>

    <!-- Modal para inscrever em cadeiras -->
    <div class="modal fade" id="modalCadeiras" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Cadeiras a que o aluno está inscrito</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <!-- Form que irá submeter os dados (idAluno, nomeAluno e nomeCadeira)
              para o url especificado. Ver nas routes para que controlador o pedido é redirecionado -->
            <form action="{{ url('/inserirInscricao') }}" method="POST" onsubmit="myFunction()">
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <input type="hidden" class="form-control" name="idAluno" id="idAluno">
              <input type="hidden" class="form-control" name="nomeAluno" id="nomeAluno">

              <table style="margin-top: 25px;" class="table table-hover, header-fixed" id="cadeirasTable">
              <thead>
              </thead>
              <tbody id="tbody">

              </tbody>
              </table>
 
              <div class="form-group">
                <label for="des">Inscrever a cadeira:</label>
                <!-- Select que lista as cadeiras -->
                <select name="nomeCadeira" id="nomeCadeira" class="form-control">
                <option value="">Escolher cadeira</option>
                    @foreach($cadeiras as $data)
                    <option value="{{ $data->nome }}">
                      {{ $data->nome }}
                    </option>
                    @endforeach
                </select>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="submitInscricao" class="btn btn-info" >Save changes</button>
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
     atribuídos às variáveis idAluno e nomeAluno. Por sua vez, estas
     definem o valor dos inputs no formulário */
      $('#modalCadeiras').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var modal = $(this);
      var idAluno = button.data('id');
      var nomeAluno = button.data('name');
      $("#idAluno").val(idAluno);
      $("#nomeAluno").val(nomeAluno);

        /* Ao abrir o modal é feito um pedido ajax que recebe as
        cadeiras às quais o aluno está inscrito */
      $.getJSON("/getCadeirasAluno/"+idAluno, function(jsonData){
        /* Para cada cadeira é criada a variável row que contém a tabela e um botão */
        row = '<tr>';
        $.each(jsonData, function(i,data)
        {
          row += '<th>'+data.nomeCadeira+'</th>';
          row += '</tr>';
        });
        $("#tbody").html(row);
      });
      });

    });

  </script>

@endif

</body>

@endsection