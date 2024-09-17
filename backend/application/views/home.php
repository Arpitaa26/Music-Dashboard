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
    <!-- /.class barchar -->
    <div class="row">

      <div class="col-lg-12">
        <div class="card">
          <div class="card-header no-border">
            <div class="btn-group nav nav-pills ml-auto">
              <button class="fc-timeGridWeek-button btn btn-primary" id="dailyButton">Daily</button>
              <button class="fc-timeGridWeek-button btn btn-primary" id="weeklyButton">Weekly</button>
              <button class="fc-timeGridWeek-button btn btn-primary" id="monthlyButton">Monthly</button>
              <button class="fc-timeGridWeek-button btn btn-primary" id="yearlyButton">Yearly</button>
            </div>

          </div>
          <div class="card-body">

            <div class="position-relative mb-4">
              <canvas id="myChart" height="200"></canvas>
            </div>

          </div>
        </div>
      </div>
    </div>
    <!-- /.row class barchar-->
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header no-border">
            <div class="d-flex justify-content-between">
              <h3 class="card-title"><strong>Support Ticket</strong></h3>
              <a href="javascript:void(0);">View Report</a>
            </div>
          </div>
          <div class="card-body">

            <div class="position-relative mb-6">
              <!-- <canvas id="weeks-chart" height="200"></canvas> -->
              <!-- Support Ticket -->
              <div class="progress-group">
                Raised Ticket
                <!-- total task -->
                <span class="float-right"><b><?=$raised_ticket?></b>/<?=$raised_ticket?></span>
                <div class="progress progress-sm">
                  <div class="progress-bar bg-primary" style="width:<?=($raised_ticket/$raised_ticket)*100?>%"></div>
                </div>
              </div>

              <div class="progress-group">
                Pending Ticket <!-- totaltask-closed task -->
                <span class="float-right"><b><?=$pending_ticket?></b>/<?=$raised_ticket?></span>
                <div class="progress progress-sm">
                  <div class="progress-bar bg-danger" style="width: <?=($pending_ticket/$raised_ticket)*100?>%"></div>
                </div>
              </div>

              <!-- <div class="progress-group">
          <span class="progress-text">Visit Premium Page</span>
          <span class="float-right"><b>480</b>/800</span>
          <div class="progress progress-sm">
            <div class="progress-bar bg-success" style="width: 60%"></div>
          </div>
        </div> -->

              <div class="progress-group">
                Resolved Ticket<!--closed task -->
                <span class="float-right"><b><?=$resolved_ticket?></b>/<?=$raised_ticket?></span>
                <div class="progress progress-sm">
                  <div class="progress-bar bg-warning" style="width: <?=($resolved_ticket/$raised_ticket)*100?>%"></div>
                </div>
              </div>
              <!-- /.Support Ticket -->
            </div>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col-md-6 -->
   
      <div class="col-lg-6">
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
    <!-- /row-->


    <!-- /.calendar -->
    <div class="row">
   
      <!-- /.col -->
      <div class="col-md-12">
        <div class="card card-primary">
        <div id="external-events">
               
          </div>
          <div class="card-body p-0">
            <!-- THE CALENDAR -->
            <div id="calendar"></div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- /.calendar -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  </div>
</section>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Calendar Event</h4>
      </div>
      <div class="modal-body">
        Form Goes Here
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Calendar Event</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open(site_url("calendar/add_event"), array("class" => "form-horizontal")) ?>
        <div class="form-group">
          <label for="p-in" class="col-md-4 label-heading">Event Name</label>
          <div class="col-md-8 ui-front">
            <input type="text" class="form-control" name="name" value="">
          </div>
        </div>
        <div class="form-group">
          <label for="p-in" class="col-md-4 label-heading">Description</label>
          <div class="col-md-8 ui-front">
            <input type="text" class="form-control" name="description">
          </div>
        </div>
        <div class="form-group">
          <label for="p-in" class="col-md-4 label-heading">Start Date</label>
          <div class="col-md-8">
            <input type="text" class="form-control" name="start_date">
          </div>
        </div>
        <div class="form-group">
          <label for="p-in" class="col-md-4 label-heading">End Date</label>
          <div class="col-md-8">
            <input type="text" class="form-control" name="end_date">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Add Event">
        <?php echo form_close() ?>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Calendar Event</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open(site_url("calendar/edit_event"), array("class" => "form-horizontal")) ?>
        <div class="form-group">
          <label for="p-in" class="col-md-4 label-heading">Event Name</label>
          <div class="col-md-8 ui-front">
            <input type="text" class="form-control" name="name" value="" id="name">
          </div>
        </div>
        <div class="form-group">
          <label for="p-in" class="col-md-4 label-heading">Description</label>
          <div class="col-md-8 ui-front">
            <input type="text" class="form-control" name="description" id="description">
          </div>
        </div>
        <div class="form-group">
          <label for="p-in" class="col-md-4 label-heading">Start Date</label>
          <div class="col-md-8">
            <input type="text" class="form-control" name="start_date" id="start_date">
          </div>
        </div>
        <div class="form-group">
          <label for="p-in" class="col-md-4 label-heading">End Date</label>
          <div class="col-md-8">
            <input type="text" class="form-control" name="end_date" id="end_date">
          </div>
        </div>
        <div class="form-group">
          <label for="p-in" class="col-md-4 label-heading">Delete Event</label>
          <div class="col-md-8">
            <input type="checkbox" name="delete" value="1">
          </div>
        </div>
        <input type="hidden" name="eventid" id="event_id" value="0" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Update Event">
        <?php echo form_close() ?>
      </div>
    </div>
  </div>
</div>

<script>
  /* global calender*/
  $(function() {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function() {

        // create an Event Object (https://fullcalendar.io/docs/event-object)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex: 1070,
          revert: true, // will cause the event to go back to its
          revertDuration: 0 //  original position after the drag
        })

      })
    }

    ini_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d = date.getDate(),
      m = date.getMonth(),
      y = date.getFullYear()

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
          backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
          borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
          textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
        };
      }
    });

    var calendar = new Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },

      themeSystem: 'bootstrap',
      events: '<?php echo base_url(); ?>api/calendar/get_class',
      //events: '<?php echo base_url(); ?>api/calendar/get_availability',
      //events: '<?php echo base_url(); ?>api/calendar/get_events',


      //   //Random default events
      //   events: [
      //     {
      //       title          : 'All Day Event',
      //       start          : new Date(y, m, 1),
      // end          : new Date(y, m, 1),
      //       backgroundColor: '#f56954', //red
      //       borderColor    : '#f56954', //red
      //       allDay         : true
      //     },

      //   ],
      selectable: true,
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar !!!
      drop: function(info) {
        // is the "remove after drop" checkbox checked?
        if (checkbox.checked) {
          // if so, remove the element from the "Draggable Events" list
          info.draggedEl.parentNode.removeChild(info.draggedEl);
        }
      },

      eventClick_s: function(info) {
        // Handle event click for editing or deleting
        if (confirm("Do you want to delete this event?")) {
          $.ajax({
            url: '<?php echo base_url(); ?>api/calendar/delete_event' + info.event.id,
            type: 'POST',
            success: function() {
              calendar.refetchEvents();
            }
          });
        }
      },
      dateClick_s: function(info) {
        // Handle date click for adding new event
        var title = prompt('Enter event title:');
        var desc = prompt('Enter event title:');
        if (title) {
          var eventData = {
            title: title,
            start: info.dateStr,
            end: info.dateStr,
            desc: desc
          };
          $.ajax({
            url: '<?php echo base_url(); ?>api/calendar/add_event',
            type: 'POST',
            data: eventData,
            success: function() {
              calendar.refetchEvents();
            }
          });
        }
        // $('#addModal').modal();
      },
      eventClick_s: function(info) {
        $('#name').val(info.event.title);
        $('#description').val(info.event.description);
        $('#start_date').val(moment(info.event.start).format('YYYY-MM-DD HH:mm'));
        if (event.end) {
          $('#end_date').val(moment(info.event.end).format('YYYY-MM-DD HH:mm'));
        } else {
          $('#end_date').val(moment(info.event.start).format('YYYY-MM-DD HH:mm'));
        }
        $('#event_id').val(info.event.id);
        $('#editModal').modal();
      },
    });

    calendar.render();
    // $('#calendar').fullCalendar()

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    // Color chooser button
    $('#color-chooser > li > a').click(function(e) {
      e.preventDefault()
      // Save color
      currColor = $(this).css('color')
      // Add color effect to button
      $('#add-new-event').css({
        'background-color': currColor,
        'border-color': currColor
      })
    })
    $('#add-new-event').click(function(e) {
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
        'border-color': currColor,
        'color': '#fff'
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
    var cData = JSON.parse(`<?php echo $get_months_whise; ?>`);
    var $classesChart = $('#classes-chart')
    // eslint-disable-next-line no-unused-vars

    var classesChart = new Chart($classesChart, {
      type: 'bar',
      data: {
        labels: cData.months,
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


  })
</script>
<script>
  // Initial data (replace with your actual data)
  var cData = JSON.parse(`<?php echo $get_last_7_days_data; ?>`);

  const initialLabels =cData.daysname;
  const initialData = cData.users;
  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true
  // Chart configuration
  const chartConfig = {
    type: 'bar',
    data: {
      labels: initialLabels,
      datasets: [{
        label: 'Data',
        data: initialData,
        backgroundColor: '#007bff',
        borderColor: '#007bff',
        borderWidth: 1
      }]
    },
    // options: {
    //     scales: {
    //         y: {
    //             beginAtZero: true
    //         }
    //     }
    // }
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
  };

  // Create a Chart.js instance
  const ctx = document.getElementById('myChart').getContext('2d');
  const myChart = new Chart(ctx, chartConfig);
  document.getElementById('dailyButton').addEventListener('click', () => {
    // Update chart data with daily data
    var cData = JSON.parse(`<?php echo $get_last_7_days_data; ?>`);
    const dailyData = JSON.parse(`<?php echo $get_days_whise; ?>`);
    myChart.data.labels = dailyData.days;
    myChart.data.datasets[0].data = dailyData.users;
    myChart.update();
  });

  document.getElementById('weeklyButton').addEventListener('click', () => {
    // Update chart data with weekly data
    var cData = JSON.parse(`<?php echo $get_last_7_days_data; ?>`);
    const weeklyData = JSON.parse(`<?php echo $get_weeks_whise; ?>`);
    myChart.data.labels = cData.days;
    myChart.data.datasets[0].data = cData.users;
    myChart.update();
  });

  document.getElementById('monthlyButton').addEventListener('click', () => {
    // Update chart data with monthly data
    const monthlyData = JSON.parse(`<?php echo $get_months_whise; ?>`);
    myChart.data.labels = monthlyData.months;
    myChart.data.datasets[0].data = monthlyData.users;
    myChart.update();
  });
  document.getElementById('yearlyButton').addEventListener('click', () => {
    // Update chart data with monthly data
    const monthlyData = JSON.parse(`<?php echo $get_years_whise; ?>`);
    myChart.data.labels = monthlyData.years;
    myChart.data.datasets[0].data = monthlyData.users;
    myChart.update();
  });
</script>