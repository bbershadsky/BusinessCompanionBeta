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

<!--    HOVER.CSS EFFECTS-->
    <link rel="stylesheet" href="css/hover-min.css">
    <style type="text/css">
        .hvr-icon-pulse:before {
            content: "\f040";
        }
    </style>

<!--    TABLE SORTING-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">

    <?php
    $user = 'Beta Tester';
    $admin = 'Boris Bershadsky';

    //Client config
    $clientName = 'Business Companion';

    //DATABASE CREDENTIALS
    $keyfile = file('../novaprospect/combine');
    $servername = trim($keyfile[0]);
    $username = trim($keyfile[1]);
    $password = trim($keyfile[2]);
    $dbname = trim($keyfile[3]);

    //Initialize values upon form refresh
    if (!empty($_GET['del_id'])) { $del_id = $_GET['del_id']; }

    //Get the search query
    if (!empty($_GET['q'])) { $searchQuery = $_GET['q']; }
    ?>

    <!--        TABLE SORT-->
    <script type="application/javascript">
        $(document).ready(function() {
            $('#list_customers').DataTable();
        } );
    </script>
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

            <?php
                        $order = 'name';
                        if (!empty($_GET['order'])) { $order = $_GET['order']; }
            ?>

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"></h3>

                    <div id="users" class="users">
                        <div align="center">
                            <?php


                            //Check if the record already exists
                            if ($del_id != '') {
                                try {
                                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    $stmt = $conn->prepare("UPDATE bc_customers.CUSTOMERS SET `REMOVED` = 1 where $del_id = `CUSTOMER_ID`");
                                    $stmt->execute();
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                                $conn = null;
                                echo "<div class=\"alert alert-warning no-print\"><strong>Customer Deleted Successfully!</strong></div>";
                            }
                            ?>

                            <input class="search no-print" id="search" size="40" placeholder="<?php if (isset($searchQuery)) { echo 'Filter'; } else { echo 'Search'; }; ?> by Name / Company / Phone / Email"/><br/>
                            <br/>
                            <a class="js-open-modal btn btn-success btn-lg no-print" href="add_customer.php" data-modal-id="add_customer"><span
                                    class="fa fa-user-plus"></span> Add a Customer</a>
                            <br/>
                            <br/>
                            <div class="no-print">
                                Sort by:
                                <div class="btn-group" role="group" aria-label="...">
                                    <button type="button" class="btn <?php echo ($order == 'name') ? 'btn-info' : 'btn-default'; ?>" onclick="window.location='list_customers.php?order=name';return false;">Name</button>
                                    <button type="button" class="btn <?php echo ($order == 'company') ? 'btn-info' : 'btn-default'; ?>" onclick="window.location='list_customers.php?order=company';return false;">Company</button>
                                    <button type="button" class="btn <?php echo ($order == 'customer_since') ? 'btn-info' : 'btn-default'; ?>" onclick="window.location='list_customers.php?order=customer_since';return false;">Date Created</button>
                                </div>
                            </div>

                            <br/>

                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">

                    <table id='list_customers' class='table table-bordered table-striped table-responsive table-hover'>
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Customer Id</th>
                                <th>Name</th>
                                <th>Phone #</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Social</th>
                                <th>Address</th>
                                <th>Notes</th>
                                <th>Customer Since</th>
                            </tr>
                        </thead>
                        <!-- IMPORTANT, class="list" have to be at tbody -->
                        <tbody class="list">

                        <?php
                                            try {
                                                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                $sql = 'SELECT `CUSTOMER_ID`, `NAME`, `PHONE`, `COMPANY`, `EMAIL`, `FACEBOOK`, `LINKEDIN`, `ADDRESS`, `NOTES`,
                                                                  `CUSTOMER_SINCE`
                                                                FROM CUSTOMERS
                                                                WHERE `REMOVED` != 1';
                                                if (isset($searchQuery)) { $sql.= ' AND `NAME` LIKE \'%' . $searchQuery . '%\' ';}
                                                                $sql .= ' ORDER BY ' . $order;

                                                //Descending order fix
                                                if ($order == 'customer_since') {
                                                    $sql .= ' DESC';
                                                }
                                                //echo $sql;
                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute();

                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                    <tr>

                                                        <td><a href="edit_customer.php?id=<?php echo $row['CUSTOMER_ID']; ?>"><i class="fa fa-pencil fa-lg"></i></a> | <a href="list_customers.php?del_id=<?php echo $row['CUSTOMER_ID']; ?>" onclick="return confirm('Are you sure you want to delete this customer?')"><i class="fa fa-trash-o fa-lg" style="color: firebrick;"></i></a></td>
                                                        <td><?php echo $row['CUSTOMER_ID']; ?></td>
                                                        <td class="name"><?php echo $row['NAME']; ?></td>
                                                        <td class="phone"><?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $row['PHONE']); ?></td>
                                                        <td class="company"><?php echo $row['COMPANY']; ?></td>
                                                        <td class="email"><?php echo $row['EMAIL']; ?></td>
                                                        <td>
                                                            <?php
                                                            if (strlen($row['FACEBOOK']) > 7)  {
                                                                echo '<a href=\''. $row['FACEBOOK'] .
                                                                    '\' target=\'_blank\'><i class=\'fa fa-facebook aria-hidden=\'true\'></i></a>'; }

                                                            if (((strlen($row['FACEBOOK']) > 7)) && (strlen($row['LINKEDIN']) > 7))
                                                                echo " | ";

                                                            if (strlen($row['LINKEDIN']) > 7) {
                                                                echo '<a href=\''. $row['LINKEDIN'] .
                                                                    '\' target=\'_blank\'><i class=\'fa fa-linkedin aria-hidden=\'true\'></i></a>'; }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $row['ADDRESS']; ?></td>
                                                        <td><?php echo $row['NOTES']; ?></td>
                                                        <td><?php echo $row['CUSTOMER_SINCE']; ?></td>
                                                    </tr>
                                                <?php }
                                            } catch (PDOException $e) {
                                                echo "Error: " . $e->getMessage();
                                            }
                                            $conn = null;
                                            ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Action</th>
                            <th>Customer Id</th>
                            <th>Name</th>
                            <th>Phone #</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Social</th>
                            <th>Address</th>
                            <th>Notes</th>
                            <th>Customer Since</th>
                        </tr>
                        </tfoot>
                    </table>
                    <script src="http://listjs.com/no-cdn/list.js"></script>
                    <!--FILTERING BY TABLE DATA-->
                    <script>
                        var options = {
                            valueNames: ['name', 'phone', 'company', 'email']
                        };
                        var userList = new List('users', options);
                    </script>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
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
