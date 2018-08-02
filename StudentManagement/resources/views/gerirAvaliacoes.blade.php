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

      <select name="cadeira" id="cadeira" class="form-control">
      <option value="">Escolher Cadeira</option>
      @foreach($cadeiras as $data)
      <option value="{{ $data->nome}}">
      {{ $data->id }}
      </option>
      @endforeach
      </select>

      <button style="margin-top: 25px;" id="addCuidador" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">Adicionar Avaliação</button>
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

          @foreach($avaliacoes as $data)
          @if($data->idCadeira))
          <tr>
            <th>{{$data->codigo}}</th>
            <th>{{$data->nome}}</th>
            <th>
              <button style="margin-right: 30px;" type="button" id="open" class="btn btn-info" data-toggle="modal" data-target="#myModal"
                data-id="{{$data->id}}" data-codigo="{{$data->codigo}}" data-nome="{{$data->nome}}">Editar</button>
              <button id="deleteCuidador" type="button" class="btn btn-danger" data-id="{{$data->id}}">Apagar</button>
            </th>
          </tr>
          @endif
          @endforeach
      </table>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
              <input type="hidden" class="form-control" name="id" id="id">
              <div class="form-group">
                <label for="title">Codigo</label>
                <input type="text" class="form-control" name="codigo" id="codigo">
              </div>

              <div class="form-group">
                <label for="des">Nome</label>
                <input type="text" class="form-control" name="nome" id="nome">
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
  </div>

@endif

<script>

$(document).ready(function () {
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal = $(this);
        modal.find('#id').val(button.data('id'))
        modal.find('#codigo').val(button.data('codigo'))
        modal.find('#nome').val(button.data('nome'))
    });

    $('select[name="cadeira"]').on('change', function(){
        var cadeiraId = $(this).val();
        if(cadeiraId) {
            $.ajax({
                url: '/getAvaliacoes/'+cadeiraId,
                type:"GET",
                dataType:"json",

                success:function(data) {
                console.log(data);
                },
            });
        } else {
            $('select[name="cadeira"]').empty();
        }

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
            <h4 class="modal-title" id="myModalLabel">Adicionar Cadeira</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ url('/inserirCadeira') }}" method="POST">
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

              <div class="form-group">
                <label for="title">Código</label>
                <input type="text" name="codigo" class="form-control" id="codigo">
              </div>

              <div class="form-group">
                <label for="des">Nome</label>
                <input type="text" name="nome" class="form-control" id="nome">
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

@endsection