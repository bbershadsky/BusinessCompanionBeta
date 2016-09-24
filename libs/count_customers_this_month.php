<?php
function countCustomersThisMonth() {
    $servername = "db.dev.businesscompanion.ca";
    $username = "bctest1";
    $password = "bctest123";
    $dbname = "bc_customers";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT COUNT(*) CUST_THIS_MONTH from bc_customers.CUSTOMERS
                                WHERE `REMOVED` != 1 AND `CUSTOMER_SINCE`
                                BETWEEN SUBDATE(CURDATE(), INTERVAL 1 MONTH)
                                AND NOW()
                                ORDER BY `CUSTOMER_SINCE` DESC");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['CUST_THIS_MONTH'];
        }
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    return 0;
}