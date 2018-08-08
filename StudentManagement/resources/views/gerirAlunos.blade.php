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

          @foreach($alunos as $data)
          @if($data->type == 'aluno')
          <tr>
            <th>{{$data->name}}</th>
            <th>{{$data->email}}</th>
            <th>
                <button style="margin-right: 30px;" type="button" id="verCadeiras" class="btn btn-primary" data-toggle="modal" data-target="#modalCadeiras"
                data-id="{{$data->id}}" data-name="{{$data->name}}">Ver cadeiras</button>
            </th>
          </tr>
          @endif
          @endforeach
      </table>

    </div>

    <div class="modal fade" id="modalCadeiras" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Inscrever a cadeiras</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ url('/inserirInscricao') }}" method="POST" onsubmit="myFunction()">
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <input type="hidden" class="form-control" name="idAluno" id="idAluno">
              <input type="hidden" class="form-control" name="nomeAluno" id="nomeAluno">

              <table style="margin-top: 25px;" class="table table-hover, header-fixed" id="cadeirasTable">
              <thead>
              <tr>
              </tr>
              </thead>
              <tbody id="tbody">

              </tbody>
              </table>
 
              <div class="form-group">
                <label for="des">Inscrever a cadeira:</label>
                <select name="nomeCadeira" id="nomeCadeira" class="form-control">
                <option value="">Escolher cadeira</option>
                    @foreach($cadeiras as $data)
                    <option value="{{ $data->nome }}">
                      {{ $data->nome }}
                    </option>
                    @endforeach
                </select>
                <h3 id="message"></h4>
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
      $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal = $(this);
        modal.find('#id').val(button.data('id'));
        modal.find('#name').val(button.data('name'));
        modal.find('#email').val(button.data('email'));
      });

      $('#modalCadeiras').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var modal = $(this);
      var idAluno = button.data('id');
      var nomeAluno = button.data('name');
      $("#idAluno").val(idAluno);
      $("#nomeAluno").val(nomeAluno);

      $.getJSON("/getCadeirasAluno/"+idAluno, function(jsonData){
        row = '<tr>';
        $.each(jsonData, function(i,data)
        {
          row += '<th>'+data.nomeCadeira+'</th>';
          row += '<th>';
          row += '<button id="removerInscricao" type="button" class="btn btn-danger" data-id="'+data.idAluno+'" data-nome="'+data.nomeCadeira+'">Apagar</button>';
          row += '</th>';
          row += '</tr>';
        });
        /*if(!$('select[name="cadeira"]').val()){
          row = '';
        }*/
        $("#tbody").html(row);

      });

      });

    });

    $(document).on('click', '#removerInscricao', function () {
      $.ajax({
        type: 'POST',
        url: '/removerInscricao/{id}/{nome}',
        data: {
          "_token": "{{ csrf_token() }}",
          "id": $(this).data("id"),
          "nome": $(this).data("nome"),
        },
        success: function(result) { //we got the response
             alert('Successfully called');
        },
        error: function(jqxhr, status, exception) {
             alert('Exception:', exception);
        }
      });
      location.reload(); //refreshes page
    });

  </script>

@endif

</body>

@endsection