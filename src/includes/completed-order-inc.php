<?php

    if (isset($_POST['submit'])) {

        $paymentType = $_POST['submit'];
        $cardNumber = $_POST['card-number'];
        $cardName = $_POST['card-name'];
        $cardExpiry = $_POST['exp-date'];
        $cardCvv = $_POST['cvv'];

        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        if (emptyPaymentType($cardNumber, $cardName, $cardExpiry, $cardCvv) && $paymentType == "Card") {
            header("location: ../checkout.php?error=emptyInput");  
            exit();
        } else {

            $orderedItems = array(
                "id" => array(),
                "quantity" => array()
            );

            $orderTotal = 0;
            
            for ($index = 0; $index < count($_SESSION['cart']); $index++) {
                $orderedItems['id'][] = $_SESSION['cart'][$index]['id'];
                $orderedItems['quantity'][] = $_SESSION['cart'][$index]['quantity'];

                $orderTotal += $_SESSION['cart'][$index]['quantity'] * $_SESSION['cart'][$index]['price'];
            }

            addOrder($conn, $orderedItems, $orderTotal, $paymentType);
            header("location: ../index.php?success=orderCompleted"); 
            exit();
        }
    }
?>