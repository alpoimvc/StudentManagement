@extends('layout')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
@endsection
@section('content')
<div class="container" style="display:flex;">
    <div class="row" style="">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"></div>
                <div class="panel-body" >
                {!! $calendar->calendar() !!}
                {!! $calendar->script() !!}
                </div>
            </div>
        </div>
        <div style="flex-grow: 1;">
        <h1>Gestão de aulas</h1>
        <div class="form-group">
                <label for="des">Escolher aluno:</label>
                <!-- Select que lista as cadeiras -->
                <select name="nomeAluno" id="nomeAluno" class="form-control">
                <option value="">Escolher aluno</option>
                    @foreach($aluno as $data)
                    <option value="{{ $data->name }}">
                      {{ $data->name }}
                    </option>
                    @endforeach
                </select>
              </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
{!! $calendar->script() !!}
@endsection