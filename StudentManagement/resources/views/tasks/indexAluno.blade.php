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

</div>
</div>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
    $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            weekends: false, // will hide Saturdays and Sundays
            dayNamesShort:['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
            header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
            },
            defaultView: 'agendaWeek',
            events : [
                @foreach($tasks as $task)
                {
                    title : '{{ $task->name }}',
                    start : '{{ $task->task_date }}',
                    url : '{{ route('tasks.edit', $task->id) }}',
                    dow: '{{ $task->dow }}',
                    @if( $task->turno == 'A')
                    color  : '#33cc33'
                    @endif
                    @if( $task->turno == 'B')
                    color  : '#0000ff'
                    @endif
                    @if( $task->turno == 'C')
                    color  : '#ff6600'
                    @endif
                },
                @endforeach
            ],
            eventColor: '#01DF01'
        })
    });
</script>
@endsection
@section('script')
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
@endsection