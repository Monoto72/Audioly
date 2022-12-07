<?php

    if (isset($_POST['submit'])) {
        $address = $_POST['address'];
        $city = $_POST['city'];
        $postcode = $_POST['post-code'];
        $country = $_POST['country'];

        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        if (emptyBillingAddress($address, $city, $postcode, $country)) {
            header("location: ../index.php?error=emptyInput");  
            exit();
        } else {
            addBillingAddress($conn, $address, $city, $postcode, $country, $_SESSION['userId']);
            exit();
        }
    }

?>