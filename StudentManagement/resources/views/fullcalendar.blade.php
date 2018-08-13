@extends('layout')
@section('style')
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
@endsection
@section('content')

<div>
<div id='calendar' style="max-width: 650px; margin: 40px auto;">
<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
</div>
</div>
</div>

<button type="button" id="guardar" class="btn btn-primary">Guardar</button>
</div>

@endsection
@section('script')
<script>
$(function() {
$('#calendar').fullCalendar({
  selectable: true,
  defaultView: 'agendaWeek',
  header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay'
  },
  dayClick: function(date) {
    alert('clicked ' + date.format());
  },
  select: function(startDate, endDate) {
    var title = prompt("Nome da cadeira");
    //alert('selected ' + startDate.format() + ' to ' + endDate.format());
    $.ajax({
        type: 'POST',
        url: '/guardarHorario',
        data: {
          "_token": "{{ csrf_token() }}",
          "title": title,
          "start_date": startDate.format(),
          "end_date": endDate.format(),
        },
        success: function(){
          location.reload(); //refreshes page
        },
      }); 
  }
});

});

$(document).on('click', '#guardar', function () {
      $.ajax({
        type: 'POST',
        /* É enviado para o controlador */
        url: '/guardarHorario',
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
{!! $calendar->script() !!}
@endsection