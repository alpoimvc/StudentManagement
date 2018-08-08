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

      <!-- verifica se o array recebido está vazio.
      Este pedido é feito nas routes (web.php) -->
      @if(!empty($avaliacoes))
      <table style="margin-top: 25px;" class="table table-hover, header-fixed" id="cadeirasTable">
        <thead>
          <tr>
            <th>Cadeira</th>
            <th>Avaliação</th>
          </tr>
        </thead>
        <tbody>

          <!-- Recebe o array com todas as avaliacoes da base de dados
          e lista apenas as cadeiras às quais o aluno que está autenticado
          está inscrito -->
          @foreach($avaliacoes as $data)
          @if($data->idAluno == Auth::user()->id)
          <tr>
            <th>{{$data->nomeCadeira}}</th>
            <th>{{$data->nota}}</th>
          </tr>
          @endif
          @endforeach
      </table>

    </div>
    
  </div>

@endif

</body>

@endsection