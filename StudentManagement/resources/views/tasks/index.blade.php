@extends('layout')
@section('style')
<style>
.ui-datepicker {
    position: relative !important;
    top: -260px !important;
    right: 0 !important;
}
</style>
@endsection
@section('content')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

<div class="container" style="display:flex;">
<div style="width: 900px;" id='calendar'></div>

<div style="flex-grow: 1; margin-left: 15px;">
<h4>Adicionar aula</h4>
<form action="{{ route('tasks.store') }}" method="post">
  {{ csrf_field() }}
  Cadeira
  <br />
    <select class="form-control" name="name" required>
    <option name="name" value="">Escolher cadeira</option>
    @foreach($cadeiras as $cadeira)
    <option name="name" value="{{ $cadeira->nome }}">{{ $cadeira->nome }}</option>
    @endforeach
    </select>
  <br />
  Descrição:
  <br />
  <textarea name="description"></textarea>
  <br /><br />
  Inicio da aula:
  <br />
  <input type="datetime" value="" id="time-holder" name="task_date" required>
  <br />
  Fim da aula:
  <br />
  <input type="datetime" value="" id="time-holder2" name="task_date_end" required>
  <input type="button" value="Obter hora atual" id="time">
  <br /><br />
  Dia:
  <br />
    <select class="form-control" name="dow" required>
    <option name="dow" value="">Escolher dia</option>
    <option name="dow" value="1">Segunda-feira</option>
    <option name="dow" value="2">Terça-feira</option>
    <option name="dow" value="3">Quarta-feira</option>
    <option name="dow" value="4">Quinta-feira</option>
    <option name="dow" value="5">Sexta-feira</option>
    </select>
  <br />
  Turno:
  <br />
    <select class="form-control" name="turno" required>
    <option name="turno" value="">Escolher turno</option>
    <option name="turno" value="A">A</option>
    <option name="turno" value="B">B</option>
    <option name="turno" value="C">C</option>
    </select>
    <br />
  <input type="submit" value="Save" />
</form>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script>
    $('#time').click(function(){
		var time = moment().format('YYYY-MM-DD hh:mm:ss');
        $('#time-holder').val(time);  
        $('#time-holder2').val(time);  
    });
</script>
</div>

</div>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            weekends: false, // will hide Saturdays and Sundays
            events : [
                @foreach($tasks as $task)
                {
                    title : '{{ $task->name }}',
                    start : '{{ $task->task_date }}',
                    url : '{{ route('tasks.edit', $task->id) }}',
                    dow: '{{ $task->dow }}'
                },
                @endforeach
            ]
        })
    });
</script>
@endsection
@section('script')
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
@endsection