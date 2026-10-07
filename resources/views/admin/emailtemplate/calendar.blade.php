@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

@endsection

@section('content')

    <div class="card card-calendar">
        <div class="card-body ">
            @php
                $UserLevel = App\Models\UsersLevel::select('l_promotion','UserId')->where('UserId',Auth::user()->id)->first();
            @endphp
            @if($UserLevel->l_promotion == 1)
                <a href="{{ route('promotion.emailtemplate.index') }}">
                    <button class="btn btn-round" type="button"><i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูลปฏิทินโปรโมชั่น</button>
                </a>
            @endif
            <div id="fullCalendar"></div>
        </div>
    </div>

@include('admin.promotion.emailtemplate.modal.delete')
@endsection

@section('js')
<script src="{{ asset('assets/backend/js/plugins/fullcalendar.min.js') }}"></script>

<script>
    $(document).ready(function() {
      initFullCalendar();
    });

    function initFullCalendar(){

        $.ajax({
            type: "GET",
            url: '{!! route('promotion.emailtemplate.calendar.json') !!}',
            cache: false,
            beforeSend: function () { },
            success: function (response) {

                var dataEvent = [];
                $.each(response, function (index, item) {

                    dataEvent.push(item);
                })

                $calendar = $('#fullCalendar');

                today = new Date();
                today.toLocaleString('th-TH', { timeZone: 'Asia/Bangkok' });
                y = today.getFullYear();
                m = today.getMonth();
                d = today.getDate();

                $calendar.fullCalendar({

                    viewRender: function(view, element) {
                        // We make sure that we activate the perfect scrollbar when the view isn't on Month
                        if (view.name != 'month') {
                        $(element).find('.fc-scroller').perfectScrollbar();
                        }
                    },
                    header: {
                        left: 'title',
                        center: 'month,agendaWeek,agendaDay',
                        right: 'prev,next,today'
                    },
                    defaultDate: today,
                    selectable: true,
                    selectHelper: true,
                    views: {
                        month: { // name of view
                        titleFormat: 'MMMM YYYY'
                        // other view-specific options here
                        },
                        week: {
                        titleFormat: " MMMM D YYYY"
                        },
                        day: {
                        titleFormat: 'D MMM, YYYY'
                        }
                    },
                    editable: true,
                    eventLimit: true, // allow "more" link when too many events

                    // color classes: [ event-blue | event-azure | event-green | event-orange | event-red ]
                    events: dataEvent
                });
            }
        })

    }
  </script>
@endsection
