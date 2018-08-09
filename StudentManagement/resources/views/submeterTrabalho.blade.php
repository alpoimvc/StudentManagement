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

<body>

  <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">Submeter Trabalho</div>
 
                <div class="card-body">
                    @if ($message = Session::get('success'))
 
                        <div class="alert alert-success alert-block">
 
                            <button type="button" class="close" data-dismiss="alert">×</button>
 
                            <strong>{{ $message }}</strong>
 
                        </div>
 
                    @endif
 
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
 
 
                        <form action="/submeterTrabalho" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <select name="nomeCadeira" class="form-control">
                                <option value="0">Escolher Cadeira</option>
                                @foreach($cadeiras as $data)
                                <option value="{{ $data->nome}}">
                                {{ $data->nome }}
                                </option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control-file" name="fileToUpload" id="exampleInputFile" aria-describedby="fileHelp">
                                <small id="fileHelp" class="form-text text-muted">O tamanho do ficheiro não deve ser maior do que 2MB.</small>
                            </div>
  
                            <button type="submit" class="btn btn-primary">Submeter</button>
                        </form>
                </div>
            </div>
        </div>
    </div>

</body>

@endsection