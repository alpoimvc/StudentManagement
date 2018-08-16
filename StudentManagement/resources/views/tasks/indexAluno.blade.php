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


<div style="width: 100%; float:center;" id='calendar'></div>


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
            },
            defaultView: 'month',
            events : [
                @foreach($tasks as $task)
                {
                    id : '{{ $task->id }}',
                    title : '{{ $task->name }}',
                    start : '{{ $task->task_date }}',
                    url : '{{ route('tasks.edit', $task->id) }}',
                    dow: '{{ $task->dow }}',
                    hour : '{{ $task->hour }}',
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
            displayEventTime: false,
            eventMouseover: function(calEvent, jsEvent) {
                var tooltip = '<div class="tooltipevent" style="width:100px;height:100px;background:#ccc;position:absolute;z-index:10001;">' + calEvent.hour + '</div>';
                $("body").append(tooltip);
                $(this).mouseover(function(e) {
                    $(this).css('z-index', 10000);
                    $('.tooltipevent').fadeIn('500');
                    $('.tooltipevent').fadeTo('10', 1.9);
                }).mousemove(function(e) {
                    $('.tooltipevent').css('top', e.pageY + 10);
                    $('.tooltipevent').css('left', e.pageX + 20);
                });
            },

            eventMouseout: function(calEvent, jsEvent) {
                $(this).css('z-index', 8);
                $('.tooltipevent').remove();
            },
            /*function( event, jsEvent, view ) { 
                .fullCalendar( ‘removeEvents’ [event.id] )
            }*/
        })
    });
</script>
@endsection
@section('script')
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
@endsection