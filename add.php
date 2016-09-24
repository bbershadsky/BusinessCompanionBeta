 <?php
                                $keyfile = file('../novaprospect/combine');
                                $servername = trim($keyfile[0]);
                                $username = trim($keyfile[1]);
                                $password = trim($keyfile[2]);
                                $dbname = trim($keyfile[3]);

                                //Check if the record already exists
                                if ($name != '') {
                                    try {
                                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        $stmt = $conn->prepare("SELECT UPPER(NAME) FROM bc_customers.CUSTOMERS where NAME = UPPER(:name)");
                                        $stmt->bindParam(':name', $name);
                                        $stmt->execute();
                                        $result = $stmt->fetchAll();
//        print_r($result);
                                        if (empty($result)) {
                                            try {
                                                //echo "unique, add it in";
                                                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                $stmt = $conn->prepare("INSERT INTO bc_customers.CUSTOMERS (NAME, PHONE, COMPANY, EMAIL, ADDRESS, NOTES, LINKEDIN, FACEBOOK) VALUES (:name, :phone, :company, :email, :address, :notes, :linkedin, :facebook)");
                                                $stmt->bindParam(':name', $name);
                                                $stmt->bindParam(':phone', $phone);
                                                $stmt->bindParam(':company', $company);
                                                $stmt->bindParam(':email', $email);
                                                $stmt->bindParam(':address', $address);
                                                $stmt->bindParam(':notes', $notes);
                                                $stmt->bindParam(':linkedin', $linkedin);
                                                $stmt->bindParam(':facebook', $facebook);
                                                $stmt->execute();

                                            } catch (PDOException $e) {
                                                echo "Error: " . $e->getMessage();
                                            }
                                            $conn = null;
                                            echo "<div class=\"alert alert-success no-print\"><strong>Customer Added Successfully! Forwarding you to Customer List...</strong></div>";
                                            echo "<script type=\"application/javascript\">
                    window.setTimeout(function(){
                    window.location.href = \"../list_customers.php\";
                    }, 5000);
                    </script>";
                                        }
                                        //Customer name is duplicated
                                        else {
                                            echo "<div class=\"alert alert-error no-print\"><strong>Customer already exists! Duplicate record below:</strong></div>";
                                            ?>
                                            <table id='list_customers' class='table table-hover'>
                                                <tr>
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
                                                <?php
                                                //Show them the duplicate entry
                                                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                $stmt = $conn->prepare("SELECT `CUSTOMER_ID`, `NAME`, `PHONE`, `COMPANY`, `EMAIL`, `FACEBOOK`, `LINKEDIN`, `ADDRESS`, `NOTES`,
                                          `CUSTOMER_SINCE`
                                        FROM CUSTOMERS
                                        WHERE `REMOVED` != 1
                                        AND NAME = '$name'");
                                                $stmt->execute();

                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                    <tr>
                                                        <td><?php echo $row['CUSTOMER_ID']; ?></td>
                                                        <td class="name"><?php echo $row['NAME']; ?></td>
                                                        <td class="phone"><?php echo $row['PHONE']; ?></td>
                                                        <td class="company"><?php echo $row['COMPANY']; ?></td>
                                                        <td class="email"><?php echo $row['EMAIL']; ?></td>
                                                        <td>
                                                            <?php
                                                            if (isset($row['FACEBOOK'])) {
                                                                echo '<a href=\''. $row['FACEBOOK'] .
                                                                    '\' target=\'_blank\'><i class=\'fa fa-facebook aria-hidden=\'true\'></i></a>'; }

                                                            if (isset($row['FACEBOOK']) && (isset($row['LINKEDIN'])))
                                                                echo " | ";

                                                            if (isset($row['LINKEDIN'])) {
                                                                echo '<a href=\''. $row['LINKEDIN'] .
                                                                    '\' target=\'_blank\'><i class=\'fa fa-linkedin aria-hidden=\'true\'></i></a>'; }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $row['ADDRESS']; ?></td>
                                                        <td><?php echo $row['NOTES']; ?></td>
                                                        <td><?php echo $row['CUSTOMER_SINCE']; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                $conn = null;
                                                ?>
                                                </tbody></table>
                                            <button type="submit" onclick="window.location='../add_customer_form.php?' +
                                                ' <?php echo
                                                'name=' . $name .
                                                '&phone=' . $phone .
                                                '&company=' . $company .
                                                '&email=' . $email .
                                                '&address=' . $address .
                                                '&notes=' . $notes .
                                                '&facebook=' . $facebook .
                                                '&linkedin=' . $linkedin
                                            ;
                                            ?>';
                                                return false;">OK, let me fix it</button>
                                            <button type="submit" onclick="window.location='../list_customers.php';return false;">Cancel the add, take me back</button>
                                            <?php

                                        }

                                    } catch (PDOException $e) {
                                        echo "Error: " . $e->getMessage();
                                    }
                                    $conn = null;
                                }

                                else {
                                    echo "Name cannot be blank!</br>";
                                }
                                ?>













                                FORM













                                <!-- Main content -->
                                        <section class="content">
                                            <div class="col-md-6">
                                                <div class="box-header">
                                                    <h3 class="box-title"></h3>

                                                    <!-- general form elements -->
                                                    <div class="box box-primary">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title">New Customer Form</h3>
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
                                                                        <input type="text" name="name" class="form-control" placeholder="Enter Name">
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="phone">Phone Number</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-phone"></i>
                                                                        </div>
                                                                        <input type="number" class="form-control" placeholder="(123) 456-7890" data-inputmask='"mask": "(999) 999-9999"' data-mask >
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="email">Email Address</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-envelope"></i>
                                                                        </div>
                                                                        <input type="email" class="form-control" placeholder="example@gmail.com">
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="address">Address</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-home"></i>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="123 Real St.">
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="facebook">Facebook</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-facebook"></i>
                                                                        </div>
                                                                        <input type="url" class="form-control" placeholder="(optional)">
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="linkedin">LinkedIn</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-linkedin"></i>
                                                                        </div>
                                                                        <input type="url" class="form-control" placeholder="(optional)">
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="form-group">
                                                                        <label>Notes</label>
                                                                        <textarea class="form-control" rows="3" placeholder="This is a great customer!"></textarea>
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="box-footer">
                                                                        <button type="submit" class="btn btn-success">Save NEW Customer</button>
                                                                        <button class="btn btn-default" href="list_customers.php">Cancel</button>
                                                                    </div>
                                                                </div>

                                                                </form>
