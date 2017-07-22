@extends('layouts.app')
@section('content')

<h3>Calendar</h3>
<div>
    {!! $calendar->calendar() !!}


</div>

@endsection

@push('styles')
<link href="/js/fullCalendar/fullcalendar.min.css" rel="stylesheet">
@endpush

@push('scripts')

<script type="text/javascript" charset="utf8" src="/js/fullCalendar/moment.min.js"></script>
<script type="text/javascript" charset="utf8" src="/js/fullCalendar/fullcalendar.min.js"></script>
 {!! $calendar->script() !!}
<script>


    $(document).ready(function() {
        
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            events : [

            ]
        })
    });
</script>

@endpush