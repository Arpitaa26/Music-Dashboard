<script src="<?= base_url("assets/dist/js/pages/dashboard3.js") ?>"></script>



<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Dashboard</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
          <div class="inner">
            <h3><?= isset($students) ? $students : '' ?></h3>

            <p>Students</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="<?= base_url('user') ?>?user_type_id=5" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-cyan">
          <div class="inner">
            <h3><?= isset($teachers) ? $teachers : '' ?><sup style="font-size: 20px"></sup></h3>

            <p>Teachers</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="<?= base_url('user') ?>?user_type_id=4" name="user_type_id" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3><?= isset($active_students) ? $active_students : '' ?></h3>

            <p>Running Student</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="<?= base_url('user') ?>?user_type_id=5" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-teal">
          <div class="inner">
            <h3><?= isset($active_teachers) ? $active_teachers : '' ?></h3>

            <p>Running Teacher</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="<?= base_url('user') ?>?user_type_id=4" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>


      <!-- ./col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header no-border">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">Average Class</h3>
              <a href="javascript:void(0);">View Report</a>
            </div>
          </div>
          <div class="card-body">
            <div class="d-flex">
              <p class="d-flex flex-column">
                <span class="text-bold text-lg">820</span>
                <span>Average Class</span>
              </p>
              <p class="ml-auto d-flex flex-column text-right">
                <span class="text-success">
                  <i class="fa fa-arrow-up"></i> 12.5%
                </span>
                <span class="text-muted">Since last week</span>
              </p>
            </div>
            <!-- /.d-flex -->

            <div class="position-relative mb-4">
              <canvas id="weeks-chart" height="200"></canvas>
            </div>

            <div class="d-flex flex-row justify-content-end">
              <span class="mr-2">
                <i class="fa fa-square text-primary"></i> This Week
              </span>

              <span>
                <i class="fa fa-square text-gray"></i> Last Week
              </span>
            </div>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col-md-6 -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header no-border">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">Average Class</h3>
              <a href="javascript:void(0);">View Report</a>
            </div>
          </div>
          <div class="card-body">
            <div class="d-flex">
              <p class="d-flex flex-column">
                <span class="text-bold text-lg">23</span>
                <span>Average Class</span>
              </p>
              <p class="ml-auto d-flex flex-column text-right">
                <span class="text-success">
                  <i class="fa fa-arrow-up"></i> 33.1%
                </span>
                <span class="text-muted">Since last month</span>
              </p>
            </div>
            <!-- /.d-flex -->

            <div class="position-relative mb-4">
              <canvas id="classes-chart" height="200"></canvas>
            </div>

            <div class="d-flex flex-row justify-content-end">
              <span class="mr-2">
                <i class="fa fa-square text-primary"></i> This year
              </span>

              <span>
                <i class="fa fa-square text-gray"></i> Last year
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card direct-chat direct-chat-success" style="height: 405px;">
          <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">Today Task</h3>
            <div class="card-tools">

              <a href="<?= base_url('task') ?>?user_id=<?= $this->http->session_get("id") ?>" class="small-box-footer">View Tasks</a>

              <span title="<?= isset($incomplete) ? $incomplete : '' ?> New Messages" class="badge badge-success"><?= isset($incomplete) ? $incomplete : '' ?></span>

            </div>
          </div>

          <div class="card-body" style="display: block;">

            <div class="direct-chat-messages">

              <div class="direct-chat-msg right">
                <div class="direct-chat-infos clearfix">
                  <span class="direct-chat-name float-right"></span>
                </div>
                <?php
                if (isset($tasks)) :
                  foreach ($tasks as $key => $row) :
                ?>
                    <div class="direct-chat-text">
                      <a href="<?= base_url('task') ?>?user_id=<?= $tasks[$key]->user_id; ?>&role=<?= $tasks[$key]->role; ?>" style="color:#fff;"> <?= $tasks[$key]->task_title; ?></a>
                    </div>
                <?php
                  endforeach;
                endif;
                ?>
              </div>
            </div>
          </div>

          <!-- /.card -->
        </div>
      </div>


    </div>


 <!-- /.calendar -->
    <div class="row">
          <div class="col-md-3">
            <div class="sticky-top mb-3">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Draggable Events</h4>
                </div>
                <div class="card-body">
                  <!-- the events -->
                  <div id="external-events">
                    <div class="external-event bg-success">Lunch</div>
                    <div class="external-event bg-warning">Go home</div>
                    <div class="external-event bg-info">Do homework</div>
                    <div class="external-event bg-primary">Work on UI design</div>
                    <div class="external-event bg-danger">Sleep tight</div>
                    <div class="checkbox">
                      <label for="drop-remove">
                        <input type="checkbox" id="drop-remove">
                        remove after drop
                      </label>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Create Event</h3>
                </div>
                <div class="card-body">
                  <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                    <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>
                    </ul>
                  </div>
                  <!-- /btn-group -->
                  <div class="input-group">
                    <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                    <div class="input-group-append">
                      <button id="add-new-event" type="button" class="btn btn-primary">Add</button>
                    </div>
                    <!-- /btn-group -->
                  </div>
                  <!-- /input-group -->
                </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-primary">
              <div class="card-body p-0">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
                <canvas id="classChart"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->


  </div>
</section>

<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
<script type="text/javascript">
  /* global Chart:false */

  $(function() {

    'use strict'

    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }

    var mode = 'index'
    var intersect = true
    var cData = JSON.parse(`<?php echo $month_whise; ?>`);
    var $classesChart = $('#classes-chart')
    // eslint-disable-next-line no-unused-vars

    var classesChart = new Chart($classesChart, {
      type: 'bar',
      data: {
        labels: cData.months,
        datasets: [{
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: cData.users
          },
          {
            backgroundColor: '#ced4da',
            borderColor: '#ced4da',
            data: cData.batches
          },
          {
            backgroundColor: '#9994da',
            borderColor: '#c994da',
            data: cData.classes
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,

              // Include a dollar sign in the ticks
              callback: function(value) {
                if (value >= 1000) {
                  value /= 1000
                  value += 'Day'
                }

                return '' + value
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })

    var $weeksChart = $('#weeks-chart')
    // eslint-disable-next-line no-unused-vars
    var wData = JSON.parse(`<?php echo $day_whise; ?>`);
    var weeksChart = new Chart($weeksChart, {
      data: {
        labels: wData.days,
        datasets: [{
            type: 'line',
            data: wData.users,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            pointBorderColor: '#007bff',
            pointBackgroundColor: '#007bff',
            fill: false
            // pointHoverBackgroundColor: '#007bff',
            // pointHoverBorderColor    : '#007bff'
          },
          {
            type: 'line',
            data: wData.classes,
            backgroundColor: 'tansparent',
            borderColor: '#ced4da',
            pointBorderColor: '#ced4da',
            pointBackgroundColor: '#ced4da',
            fill: false
            // pointHoverBackgroundColor: '#ced4da',
            // pointHoverBorderColor    : '#ced4da'
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,
              suggestedMax: 200
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })
  })

  // lgtm [js/unused-local-variable]
</script>
<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (https://fullcalendar.io/docs/event-object)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    ini_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------

    new Draggable(containerEl, {
      itemSelector: '.external-event',
      eventData: function(eventEl) {
        return {
          title: eventEl.innerText,
          backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
        };
      }
    });

    var calendar = new Calendar(calendarEl, {
      headerToolbar: {
        left  : 'prev,next today',
        center: 'title',
        right : 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      themeSystem: 'bootstrap',
      //Random default events
      events: [
        {
          title          : 'All Day Event',
          start          : new Date(y, m, 1),
          backgroundColor: '#f56954', //red
          borderColor    : '#f56954', //red
          allDay         : true
        },
        {
          title          : 'Long Event',
          start          : new Date(y, m, d - 5),
          end            : new Date(y, m, d - 2),
          backgroundColor: '#f39c12', //yellow
          borderColor    : '#f39c12' //yellow
        },
        {
          title          : 'Meeting',
          start          : new Date(y, m, d, 10, 30),
          allDay         : false,
          backgroundColor: '#0073b7', //Blue
          borderColor    : '#0073b7' //Blue
        },
        {
          title          : 'Lunch',
          start          : new Date(y, m, d, 12, 0),
          end            : new Date(y, m, d, 14, 0),
          allDay         : false,
          backgroundColor: '#00c0ef', //Info (aqua)
          borderColor    : '#00c0ef' //Info (aqua)
        },
        {
          title          : 'Birthday Party',
          start          : new Date(y, m, d + 1, 19, 0),
          end            : new Date(y, m, d + 1, 22, 30),
          allDay         : false,
          backgroundColor: '#00a65a', //Success (green)
          borderColor    : '#00a65a' //Success (green)
        },
        {
          title          : 'Click for Google',
          start          : new Date(y, m, 28),
          end            : new Date(y, m, 29),
          url            : 'https://www.google.com/',
          backgroundColor: '#3c8dbc', //Primary (light-blue)
          borderColor    : '#3c8dbc' //Primary (light-blue)
        }
      ],
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function(info) {
        // is the "remove after drop" checkbox checked?
        if (checkbox.checked) {
          // if so, remove the element from the "Draggable Events" list
          info.draggedEl.parentNode.removeChild(info.draggedEl);
        }
      }
    });

    calendar.render();
    // $('#calendar').fullCalendar()

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    // Color chooser button
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      // Save color
      currColor = $(this).css('color')
      // Add color effect to button
      $('#add-new-event').css({
        'background-color': currColor,
        'border-color'    : currColor
      })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      // Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      // Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.text(val)
      $('#external-events').prepend(event)

      // Add draggable funtionality
      ini_events(event)

      // Remove event from text input
      $('#new-event').val('')
    })
  })



</script>


  
<script type="text/javascript">
    $calendar = $('#calendar');
    var base_url = 'https://demo.smart-hospital.in/';
    today = new Date();
    y = today.getFullYear();
    m = today.getMonth();
    d = today.getDate();
    var viewtitle = 'month';
    var pagetitle = "Dashboard";

    if (pagetitle == "Dashboard") {
        viewtitle = 'agendaWeek';
    }

    $calendar.fullCalendar({
        viewRender: function (view, element) {
            // We make sure that we activate the perfect scrollbar when the view isn't on Month

        },

        header: {
            center: 'title',
            right: 'month,agendaWeek,agendaDay',
            left: 'prev,next,today'
        },
        defaultDate: today,
        defaultView: viewtitle,
        selectable: true,
        selectHelper: true,
        views: {
            month: {// name of view
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
        timezone: 'UTC',
        draggable: false,
        lang: 'en',
        editable: false,
        eventLimit: false, // allow "more" link when too many events
        // color classes: [ event-blue | event-azure | event-green | event-orange | event-red ]
        events: {
            url: base_url + 'admin/calendar/getevents'

        },

        eventRender: function (event, element) {
            element.attr('title', event.title);
            element.attr('onclick', event.onclick);
            element.attr('data-toggle', 'tooltip');
            if ((!event.url) && (event.event_type != 'task')) {
                element.attr('title', event.title + '-' + event.description);
                element.click(function () {
                    view_event(event.id);

                });
            }
        },
        dayClick: function (date, jsEvent, view) {

            var d = date.format();
            if (!$.fullCalendar.moment(d).hasTime()) {
                d += ' 05:30';
            }
           

             var datetime_format = 'MM/DD/YYYY h:mm A';

                $("#input-field").val('');
                $("#desc-field").text('');
                $("#date-field").daterangepicker({

                    startDate: date,
                    endDate: date,
                    timePicker: true, timePickerIncrement: 5, locale: {
                    format: datetime_format

                    }
                });

                $('#newEventModal').modal('show');

            return false;
        }
    });
</script>
<script>
// Sample data (replace this with your actual data)
var dailyData = [5, 6, 4, 7, 8, 5, 6];
var weeklyData = [25, 28, 30, 27];
var monthlyData = [100, 110, 105, 120, 130];
var yearlyData = [1200, 1250, 1300, 1350];

var ctx = document.getElementById('classChart').getContext('2d');
var classChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], // Days of the week
        datasets: [
            {
                label: 'Daily',
                data: dailyData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'Weekly',
                data: weeklyData,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            },
            {
                label: 'Monthly',
                data: monthlyData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Yearly',
                data: yearlyData,
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>