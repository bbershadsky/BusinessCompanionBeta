<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Business Companion | Edit Customer</title>
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

    <?php
    $user = 'Beta Tester';
    $admin = 'Boris Bershadsky';

    //Client config
    $clientName = 'Business Companion';

    //DATABASE CREDENTIALS
    $keyfile = file('novaprospect/combine');
    $servername = trim($keyfile[0]);
    $username = trim($keyfile[1]);
    $password = trim($keyfile[2]);
    $dbname = trim($keyfile[3]);

    //Get the ID from previous page
    if (!empty($_GET['id'])) { $id = $_GET['id']; }
    if (!empty($_GET['updated'])) { $updated = $_GET['updated']; } else $updated = 0;

    //LOAD RECORD INTO PAGE
    //Fetch data using id as key
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT `NAME`, `PHONE`, `COMPANY`, `EMAIL`, `FACEBOOK`, `LINKEDIN`, `ADDRESS`, `NOTES`
                                FROM CUSTOMERS
                                WHERE `REMOVED` != 1
                                AND `CUSTOMER_ID` = $id");
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $name = $row['NAME'];
            $phone = $row['PHONE'];
            $company = $row['COMPANY'];
            $email = $row['EMAIL'];
            $address = $row['ADDRESS'];
            $notes = $row['NOTES'];
            $facebook = $row['FACEBOOK'];
            $linkedin = $row['LINKEDIN'];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;

    //Initialize values for editing functionality
    if (!empty($_GET['name'])) { $name = $_GET['name']; }
    if (!empty($_GET['phone'])) { $phone = $_GET['phone']; }
    if (!empty($_GET['company'])) { $company = $_GET['company']; }
    if (!empty($_GET['email'])) { $email = $_GET['email']; }
    if (!empty($_GET['address'])) { $address = $_GET['address']; }
    if (!empty($_GET['notes'])) { $notes = $_GET['notes']; }
    if (!empty($_GET['facebook'])) { $facebook = $_GET['facebook']; }
    if (!empty($_GET['linkedin'])) { $linkedin = $_GET['linkedin']; }
?>
</head>

<body class="
}hold-transition skin-blue sidebar-mini">
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
                Edit a Customer
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Edit Customer</li>
            </ol>

                    <!-- /.box -->
        </section>
        <!-- /.content -->

        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Customer Editing Form</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" onsubmit="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="box-body">


                                <div class="form-group">
                                    <label for="name">Customer Name</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="<?php echo $name; ?>">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <input type="number" name="phone" class="form-control" placeholder="(123) 456-7890" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?php echo $phone; ?>">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                        <input type="email" name="email" class="form-control" placeholder="example@gmail.com" value="<?php echo $email; ?>">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-home"></i>
                                        </div>
                                        <input type="text" name="address" class="form-control" placeholder="123 Real St." value="<?php echo $address; ?>">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-facebook"></i>
                                        </div>
                                        <input type="url" name="facebook" class="form-control" placeholder="(optional)" value="<?php echo $facebook; ?>">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label for="linkedin">LinkedIn</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-linkedin"></i>
                                        </div>
                                        <input type="url" name="linkedin" class="form-control" placeholder="(optional)" value="<?php echo $linkedin; ?>">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Notes</label>
                                        <textarea class="form-control" name="notes" rows="3" placeholder="This is a great customer!"><?php echo $notes; ?></textarea>
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-success">UPDATE Customer</button>
                                        <button type="submit" onclick="window.location='list_customers.php';return false;" class="btn btn-default">Return to Customer List</button>
                                    </div>
                                </div>

<input type="hidden" name="updated" value="1">
<!--                                Keep passing the ID for repeated adding-->
<input type="hidden" name="id" value="<?php echo $id; ?>">
</form>
                            </div>
                            <!-- /.box-body -->


                    </div>
                    <!-- /.box -->

                    <!-- Form Element sizes -->
<!--                    <div class="box box-success">-->
<!--                        <div class="box-header with-border">-->
<!--                            <h3 class="box-title">Different Height</h3>-->
<!--                        </div>-->
<!--                        <div class="box-body">-->
<!--                            <input class="form-control input-lg" type="text" placeholder=".input-lg">-->
<!--                            <br>-->
<!--                            <input class="form-control" type="text" placeholder="Default input">-->
<!--                            <br>-->
<!--                            <input class="form-control input-sm" type="text" placeholder=".input-sm">-->
<!--                        </div>-->
<!--                        <!-- /.box-body -->
<!--                    </div>-->
<!--                    <!-- /.box -->
<!---->
<!--                    <div class="box box-danger">-->
<!--                        <div class="box-header with-border">-->
<!--                            <h3 class="box-title">Different Width</h3>-->
<!--                        </div>-->
<!--                        <div class="box-body">-->
<!--                            <div class="row">-->
<!--                                <div class="col-xs-3">-->
<!--                                    <input type="text" class="form-control" placeholder=".col-xs-3">-->
<!--                                </div>-->
<!--                                <div class="col-xs-4">-->
<!--                                    <input type="text" class="form-control" placeholder=".col-xs-4">-->
<!--                                </div>-->
<!--                                <div class="col-xs-5">-->
<!--                                    <input type="text" class="form-control" placeholder=".col-xs-5">-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <!-- /.box-body -->
<!--                    </div>-->
<!--                    <!-- /.box -->
<!---->
<!--                    <!-- Input addon -->
<!--                    <div class="box box-info">-->
<!--                        <div class="box-header with-border">-->
<!--                            <h3 class="box-title">Input Addon</h3>-->
<!--                        </div>-->
<!--                        <div class="box-body">-->
<!--                            <div class="input-group">-->
<!--                                <span class="input-group-addon">@</span>-->
<!--                                <input type="text" class="form-control" placeholder="Username">-->
<!--                            </div>-->
<!--                            <br>-->
<!---->
<!--                            <div class="input-group">-->
<!--                                <input type="text" class="form-control">-->
<!--                                <span class="input-group-addon">.00</span>-->
<!--                            </div>-->
<!--                            <br>-->
<!---->
<!--                            <div class="input-group">-->
<!--                                <span class="input-group-addon">$</span>-->
<!--                                <input type="text" class="form-control">-->
<!--                                <span class="input-group-addon">.00</span>-->
<!--                            </div>-->
<!---->
<!--                            <h4>With icons</h4>-->
<!---->
<!--                            <div class="input-group">-->
<!--                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>-->
<!--                                <input type="email" class="form-control" placeholder="Email">-->
<!--                            </div>-->
<!--                            <br>-->
<!---->
<!--                            <div class="input-group">-->
<!--                                <input type="text" class="form-control">-->
<!--                                <span class="input-group-addon"><i class="fa fa-check"></i></span>-->
<!--                            </div>-->
<!--                            <br>-->
<!---->
<!--                            <div class="input-group">-->
<!--                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>-->
<!--                                <input type="text" class="form-control">-->
<!--                                <span class="input-group-addon"><i class="fa fa-ambulance"></i></span>-->
<!--                            </div>-->
<!---->
<!--                            <h4>With checkbox and radio inputs</h4>-->
<!---->
<!--                            <div class="row">-->
<!--                                <div class="col-lg-6">-->
<!--                                    <div class="input-group">-->
<!--                        <span class="input-group-addon">-->
<!--                          <input type="checkbox">-->
<!--                        </span>-->
<!--                                        <input type="text" class="form-control">-->
<!--                                    </div>-->
<!--                                    <!-- /input-group -->
<!--                                </div>-->
<!--                                <!-- /.col-lg-6 -->
<!--                                <div class="col-lg-6">-->
<!--                                    <div class="input-group">-->
<!--                        <span class="input-group-addon">-->
<!--                          <input type="radio">-->
<!--                        </span>-->
<!--                                        <input type="text" class="form-control">-->
<!--                                    </div>-->
<!--                                    <!-- /input-group -->
<!--                                </div>-->
<!--                                <!-- /.col-lg-6 -->
<!--                            </div>-->
<!--                            <!-- /.row -->
<!---->
<!--                            <h4>With buttons</h4>-->
<!---->
<!--                            <p class="margin">Large: <code>.input-group.input-group-lg</code></p>-->
<!---->
<!--                            <div class="input-group input-group-lg">-->
<!--                                <div class="input-group-btn">-->
<!--                                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Action-->
<!--                                        <span class="fa fa-caret-down"></span></button>-->
<!--                                    <ul class="dropdown-menu">-->
<!--                                        <li><a href="#">Action</a></li>-->
<!--                                        <li><a href="#">Another action</a></li>-->
<!--                                        <li><a href="#">Something else here</a></li>-->
<!--                                        <li class="divider"></li>-->
<!--                                        <li><a href="#">Separated link</a></li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                                <!-- /btn-group -->
<!--                                <input type="text" class="form-control">-->
<!--                            </div>-->
<!--                            <!-- /input-group -->
<!--                            <p class="margin">Normal</p>-->
<!---->
<!--                            <div class="input-group">-->
<!--                                <div class="input-group-btn">-->
<!--                                    <button type="button" class="btn btn-danger">Action</button>-->
<!--                                </div>-->
<!--                                <!-- /btn-group -->
<!--                                <input type="text" class="form-control">-->
<!--                            </div>-->
<!--                            <!-- /input-group -->
<!--                            <p class="margin">Small <code>.input-group.input-group-sm</code></p>-->
<!---->
<!--                            <div class="input-group input-group-sm">-->
<!--                                <input type="text" class="form-control">-->
<!--                    <span class="input-group-btn">-->
<!--                      <button type="button" class="btn btn-info btn-flat">Go!</button>-->
<!--                    </span>-->
<!--                            </div>-->
<!--                            <!-- /input-group -->
<!--                        </div>-->
<!--                        <!-- /.box-body -->
<!--                    </div>-->
                    <!-- /.box -->

                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">
                    <!-- Horizontal Form -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Result</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal">
                            <div class="box-body">
                                <?php if ($updated == 0) {
                                    echo "<div class=\"alert alert-info no-print\">
<strong>Customer Data Loaded. You can edit this customer or return to the customer screen.</strong></div>";
}
    if ($updated == 1 && $id > 0) {
        //TODO NOW ACTUALLY UPDATE IT ON THE DB
                                try {
                                            //Update the record
                                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            $stmt = $conn->prepare("UPDATE bc_customers.CUSTOMERS
                                            SET
                                            `NAME` = '$name',
                                            `PHONE` = '$phone',
                                            `COMPANY` = '$company',
                                            `EMAIL` = '$email',
                                            `ADDRESS` = '$address',
                                            `NOTES` = '$notes',
                                            `LINKEDIN` = '$linkedin',
                                            `FACEBOOK` = '$facebook'
                                            WHERE `CUSTOMER_ID` = $id");
                                            $stmt->execute();

                                        } catch (PDOException $e) {
                                            echo "Error: " . $e->getMessage();
                                        }
                                        $conn = null;
                                        echo "<div class=\"alert alert-success no-print\"><strong>Customer Updated Successfully!</strong></div>";

//                                            echo "<script type=\"application/javascript\">
//                    window.setTimeout(function(){
//                    window.location.href = \"../list_customers.php\";
//                    }, 5000);
//                    </script>";


    }
 ?>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" onclick="window.location='list_customers.php';return false;" class="btn btn-default">Return to Customer List</button>
                            </div>
                            <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                    <!-- general form elements disabled -->
<!--                    <div class="box box-warning">-->
<!--                        <div class="box-header with-border">-->
<!--                            <h3 class="box-title">General Elements</h3>-->
<!--                        </div>-->
<!--                        <!-- /.box-header -->
<!--                        <div class="box-body">-->
<!--                            <form role="form">-->
<!--                                <!-- text input -->
<!--                                <div class="form-group">-->
<!--                                    <label>Text</label>-->
<!--                                    <input type="text" class="form-control" placeholder="Enter ...">-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <label>Text Disabled</label>-->
<!--                                    <input type="text" class="form-control" placeholder="Enter ..." disabled>-->
<!--                                </div>-->
<!---->
<!--                                <!-- textarea -->
<!--                                <div class="form-group">-->
<!--                                    <label>Textarea</label>-->
<!--                                    <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <label>Textarea Disabled</label>-->
<!--                                    <textarea class="form-control" rows="3" placeholder="Enter ..." disabled></textarea>-->
<!--                                </div>-->
<!---->
<!--                                <!-- input states -->
<!--                                <div class="form-group has-success">-->
<!--                                    <label class="control-label" for="inputSuccess"><i class="fa fa-check"></i> Input with success</label>-->
<!--                                    <input type="text" class="form-control" id="inputSuccess" placeholder="Enter ...">-->
<!--                                    <span class="help-block">Help block with success</span>-->
<!--                                </div>-->
<!--                                <div class="form-group has-warning">-->
<!--                                    <label class="control-label" for="inputWarning"><i class="fa fa-bell-o"></i> Input with-->
<!--                                        warning</label>-->
<!--                                    <input type="text" class="form-control" id="inputWarning" placeholder="Enter ...">-->
<!--                                    <span class="help-block">Help block with warning</span>-->
<!--                                </div>-->
<!--                                <div class="form-group has-error">-->
<!--                                    <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> Input with-->
<!--                                        error</label>-->
<!--                                    <input type="text" class="form-control" id="inputError" placeholder="Enter ...">-->
<!--                                    <span class="help-block">Help block with error</span>-->
<!--                                </div>-->
<!---->
<!--                                <!-- checkbox -->
<!--                                <div class="form-group">-->
<!--                                    <div class="checkbox">-->
<!--                                        <label>-->
<!--                                            <input type="checkbox">-->
<!--                                            Checkbox 1-->
<!--                                        </label>-->
<!--                                    </div>-->
<!---->
<!--                                    <div class="checkbox">-->
<!--                                        <label>-->
<!--                                            <input type="checkbox">-->
<!--                                            Checkbox 2-->
<!--                                        </label>-->
<!--                                    </div>-->
<!---->
<!--                                    <div class="checkbox">-->
<!--                                        <label>-->
<!--                                            <input type="checkbox" disabled>-->
<!--                                            Checkbox disabled-->
<!--                                        </label>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                                <!-- radio -->
<!--                                <div class="form-group">-->
<!--                                    <div class="radio">-->
<!--                                        <label>-->
<!--                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>-->
<!--                                            Option one is this and that&mdash;be sure to include why it's great-->
<!--                                        </label>-->
<!--                                    </div>-->
<!--                                    <div class="radio">-->
<!--                                        <label>-->
<!--                                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">-->
<!--                                            Option two can be something else and selecting it will deselect option one-->
<!--                                        </label>-->
<!--                                    </div>-->
<!--                                    <div class="radio">-->
<!--                                        <label>-->
<!--                                            <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" disabled>-->
<!--                                            Option three is disabled-->
<!--                                        </label>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                                <!-- select -->
<!--                                <div class="form-group">-->
<!--                                    <label>Select</label>-->
<!--                                    <select class="form-control">-->
<!--                                        <option>option 1</option>-->
<!--                                        <option>option 2</option>-->
<!--                                        <option>option 3</option>-->
<!--                                        <option>option 4</option>-->
<!--                                        <option>option 5</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <label>Select Disabled</label>-->
<!--                                    <select class="form-control" disabled>-->
<!--                                        <option>option 1</option>-->
<!--                                        <option>option 2</option>-->
<!--                                        <option>option 3</option>-->
<!--                                        <option>option 4</option>-->
<!--                                        <option>option 5</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!---->
<!--                                <!-- Select multiple-->
<!--                                <div class="form-group">-->
<!--                                    <label>Select Multiple</label>-->
<!--                                    <select multiple class="form-control">-->
<!--                                        <option>option 1</option>-->
<!--                                        <option>option 2</option>-->
<!--                                        <option>option 3</option>-->
<!--                                        <option>option 4</option>-->
<!--                                        <option>option 5</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <label>Select Multiple Disabled</label>-->
<!--                                    <select multiple class="form-control" disabled>-->
<!--                                        <option>option 1</option>-->
<!--                                        <option>option 2</option>-->
<!--                                        <option>option 3</option>-->
<!--                                        <option>option 4</option>-->
<!--                                        <option>option 5</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!---->
<!--                            </form>-->
<!--                        </div>-->
<!--                        <!-- /.box-body -->
<!--                    </div>-->
                    <!-- /.box -->
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
<!--        </section>-->
    </div>

    <!--  MAIN PAGE ENDS-->

    <?php
    include_once 'footer.php';
    include_once 'control_sidebar.php';
    ?>
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
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