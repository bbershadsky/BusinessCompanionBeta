<?php
include_once '../header.php';
//include_once '../toolbar.php';

//Initialize values upon form refresh
if (!empty($_GET['name'])) { $name = $_GET['name']; }
if (!empty($_GET['phone'])) { $phone = $_GET['phone']; }
if (!empty($_GET['company'])) { $company = $_GET['company']; }
if (!empty($_GET['email'])) { $email = $_GET['email']; }
if (!empty($_GET['address'])) { $address = $_GET['address']; }
if (!empty($_GET['notes'])) { $notes = $_GET['notes']; }
if (!empty($_GET['facebook'])) { $facebook = $_GET['facebook']; }
if (!empty($_GET['linkedin'])) { $linkedin = $_GET['linkedin']; }

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

else {echo "Name cannot be blank!</br>";
?>
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
<?php }?>