<?php

    if (isset($_POST['submit'])) {
        $slug = $_POST['slug'];
        $quantity = $_POST['quantity'];
        $type = $_POST['submit'];

        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        if (emptyInputAddToCart($quantity) !== false) {
            header("location: ../index.php?error=emptyInput");  
            exit();
        } else if (productExists($conn, $slug) === false) {
            header("location: ../index.php?error=productDoesNotExist");
            exit();
        } else {
            addToCart($conn, $slug, $quantity);
            if ($type == "continue") header("location: ../checkout.php");
            if ($type == "checkout") header("location: ../checkout.php");
            exit();
        }
    }

?>