<!--TODO-->
<!--Modal popup-->
<!--Markz: scheduled time, full date, full name, (optional)subject, (optional) additional notes-->


<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Business Companion | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <!--    CUSTOMER SEARCH BAR STYLING-->
    <link rel="stylesheet" href="dist/css/search.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <meta charset='utf-8' />
    <link href='css/fullcalendar.css' rel='stylesheet' />
    <link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />
    <script src='js/moment.min.js'></script>
    <script src='js/jquery.min.js'></script>
    <script src='js/jquery-ui.min.js'></script>
    <script src='js/fullcalendar.min.js'></script>
    <script>

        $(document).ready(function() {

            var zone = "05:00";  //Change this to your timezone

            $.ajax({
                url: 'process.php',
                type: 'POST', // Send post data
                data: 'type=fetch',
                async: false,
                success: function(s){
                    json_events = s;
                }
            });


            var currentMousePos = {
                x: -1,
                y: -1
            };
            jQuery(document).on("mousemove", function (event) {
                currentMousePos.x = event.pageX;
                currentMousePos.y = event.pageY;
            });

            /* initialize the external events
             -----------------------------------------------------------------*/

            $('#external-events .fc-event').each(function() {

                // store data so the calendar knows to render an event upon drop
                $(this).data('event', {
                    title: $.trim($(this).text()), // use the element's text as the event title
                    stick: true // maintain when user navigates (see docs on the renderEvent method)
                });

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999,
                    revert: true,      // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                });

            });


            /* initialize the calendar
             -----------------------------------------------------------------*/

            $('#calendar').fullCalendar({
                events: JSON.parse(json_events),
                //events: [{"id":"14","title":"New Event","start":"2015-01-24T16:00:00+04:00","allDay":false}],
                utc: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: true,
                droppable: true,
                slotDuration: '00:30:00',
                eventReceive: function(event){
                    var title = event.title;
                    var start = event.start.format("YYYY-MM-DD[T]HH:mm:SS");
                    $.ajax({
                        url: 'process.php',
                        data: 'type=new&title='+title+'&startdate='+start+'&zone='+zone,
                        type: 'POST',
                        dataType: 'json',
                        success: function(response){
                            event.id = response.eventid;
                            $('#calendar').fullCalendar('updateEvent',event);
                        },
                        error: function(e){
                            console.log(e.responseText);

                        }
                    });
                    $('#calendar').fullCalendar('updateEvent',event);
                    console.log(event);
                },
                eventDrop: function(event, delta, revertFunc) {
                    var title = event.title;
                    var start = event.start.format();
                    var end = (event.end == null) ? start : event.end.format();
                    $.ajax({
                        url: 'process.php',
                        data: 'type=resetdate&title='+title+'&start='+start+'&end='+end+'&eventid='+event.id,
                        type: 'POST',
                        dataType: 'json',
                        success: function(response){
                            if(response.status != 'success')
                                revertFunc();
                        },
                        error: function(e){
                            revertFunc();
                            alert('Error processing your request: '+e.responseText);
                        }
                    });
                },
                eventClick: function(event, jsEvent, view) {
                    console.log(event.id);
                    var title = prompt('Event Title:', event.title, { buttons: { Ok: true, Cancel: false} });
                    if (title){
                        event.title = title;
                        console.log('type=changetitle&title='+title+'&eventid='+event.id);
                        $.ajax({
                            url: 'process.php',
                            data: 'type=changetitle&title='+title+'&eventid='+event.id,
                            type: 'POST',
                            dataType: 'json',
                            success: function(response){
                                if(response.status == 'success')
                                    $('#calendar').fullCalendar('updateEvent',event);
                            },
                            error: function(e){
                                alert('Error processing your request: '+e.responseText);
                            }
                        });
                    }
                },
                eventResize: function(event, delta, revertFunc) {
                    console.log(event);
                    var title = event.title;
                    var end = event.end.format();
                    var start = event.start.format();
                    $.ajax({
                        url: 'process.php',
                        data: 'type=resetdate&title='+title+'&start='+start+'&end='+end+'&eventid='+event.id,
                        type: 'POST',
                        dataType: 'json',
                        success: function(response){
                            if(response.status != 'success')
                                revertFunc();
                        },
                        error: function(e){
                            revertFunc();
                            alert('Error processing your request: '+e.responseText);
                        }
                    });
                },
                eventDragStop: function (event, jsEvent, ui, view) {
                    if (isElemOverDiv()) {
                        var con = confirm('Are you sure to delete this event permanently?');
                        if(con == true) {
                            $.ajax({
                                url: 'process.php',
                                data: 'type=remove&eventid='+event.id,
                                type: 'POST',
                                dataType: 'json',
                                success: function(response){
                                    console.log(response);
                                    if(response.status == 'success'){
                                        $('#calendar').fullCalendar('removeEvents');
                                        getFreshEvents();
                                    }
                                },
                                error: function(e){
                                    alert('Error processing your request: '+e.responseText);
                                }
                            });
                        }
                    }
                }
            });

            function getFreshEvents(){
                $.ajax({
                    url: 'process.php',
                    type: 'POST', // Send post data
                    data: 'type=fetch',
                    async: false,
                    success: function(s){
                        freshevents = s;
                    }
                });
                $('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
            }


            function isElemOverDiv() {
                var trashEl = jQuery('#trash');

                var ofs = trashEl.offset();

                var x1 = ofs.left;
                var x2 = ofs.left + trashEl.outerWidth(true);
                var y1 = ofs.top;
                var y2 = ofs.top + trashEl.outerHeight(true);

                if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
                    currentMousePos.y >= y1 && currentMousePos.y <= y2) {
                    return true;
                }
                return false;
            }

        });

    </script>
    <style>

        body {
            /*margin-top: 40px;*/
            /*text-align: center;*/
            font-size: 14px;
            font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
        }

        #trash{
            width:32px;
            height:32px;
            float:left;
            padding-bottom: 15px;
            position: relative;
        }

        #wrap {
            width: 1100px;
            /*margin: 0 auto;*/
        }

        #external-events {
            float: left;
            width: 150px;
            padding: 0 10px;
            border: 1px solid #ccc;
            background: #eee;
            text-align: left;
        }

        #external-events h4 {
            font-size: 16px;
            margin-top: 0;
            padding-top: 1em;
        }

        #external-events .fc-event {
            margin: 10px 0;
            cursor: pointer;
        }

        #external-events p {
            margin: 1.5em 0;
            font-size: 11px;
            color: #666;
        }

        #external-events p input {
            margin: 0;
            vertical-align: middle;
        }

        #calendar {
            float: right;
            width: 900px;
        }

    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <?php include_once 'logo.php'; ?>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <?php include_once 'navbar.php'; ?>
        </nav>
    </header>

    <?php include_once 'sidebar.php'; ?>

    <!--  MAIN PAGE CONTENT STARTS-->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo $clientName;?> Customer List <?php if (isset($searchQuery)) {echo 'search for \'' . $searchQuery . '\'';} ; ?>
                <small>Version 2.0</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                <li class="active">Customer List</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div id='wrap'>

                <div id='external-events'>
                    <h4>Draggable Events</h4>
                    <div class='fc-event'>New Event</div>
                    <p>
                        <img src="img/trashcan.png" id="trash" alt="">
                    </p>
                </div>

                <div id='calendar'></div>

                <div style='clear:both'></div>

            </div>
        </section>
        <!-- /.content -->
    </div>

    <!--  MAIN PAGE ENDS-->

    <?php
    include_once 'footer.php';
    include_once 'control_sidebar.php';
    ?>
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

</div>





<!-- jQuery 2.2.3 -->

<!--//TODO FIGURE OUT DUPLICATE WHY IT'S NOT WORKING-->
<!--<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>-->
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
