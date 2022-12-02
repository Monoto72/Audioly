<?php
    $dbusername = "root";
    $dbpassword = "root";
    $host = "localhost";
    $port = 3306; 
    $database = "testing";

    $conn = mysqli_init();

    if (!$conn) {
        echo "<p>Initalising MySQLi failed</p>";
    } else {
        mysqli_ssl_set($conn, NULL, NULL, NULL, '/public_html/sys_tests', NULL);

        mysqli_real_connect($conn, $host, $dbusername, $dbpassword, $database, $port, NULL, MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);
        if (mysqli_connect_errno()) {
            echo "<p>Failed to connect to MySQL. " .
            "Error (" . mysqli_connect_errno() . "): " . mysqli_connect_error() . "</p>";
        } 
    } 

    mysqli_set_charset($conn, "utf8");
?>