<?php
function countCustomers() {
    $servername = "db.dev.businesscompanion.ca";
    $username = "bctest1";
    $password = "bctest123";
    $dbname = "bc_customers";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT NAME
                                FROM CUSTOMERS
                                WHERE `REMOVED` != 1");
        $stmt->execute();

        return $stmt->rowCount();

    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    return 0;
}